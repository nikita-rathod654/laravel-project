<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a paginated listing of the products with filters and search.
     */
    public function index(Request $request): View|JsonResponse
    {
        // 1. Calculate KPI Metrics for the header cards
        $totalProducts = Product::count();
        $activeProducts = Product::where('status', 'Active')->count();
        $lowStockProducts = Product::where('stock_quantity', '>', 0)
            ->whereColumn('stock_quantity', '<=', 'low_stock_threshold')
            ->count();
        $outOfStockProducts = Product::where('stock_quantity', '<=', 0)->count();

        // Listing coverage percentage
        $coveragePercentage = $totalProducts > 0 
            ? round(($activeProducts / $totalProducts) * 100, 1) 
            : 0;

        // 2. Fetch distinct categories for the filter dropdown
        $categories = Product::distinct()
            ->whereNotNull('category')
            ->orderBy('category')
            ->pluck('category');

        // 3. Build filtered and sorted product query
        $query = Product::query();

        // Search by partial name or SKU
        if ($request->filled('search')) {
            $query->search($request->input('search'));
        }

        // Filter by Category
        if ($request->filled('category')) {
            $query->filterCategory($request->input('category'));
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->filterStatus($request->input('status'));
        }

        // Apply Sorting
        $sortBy = $request->input('sort_by', 'latest');
        $query->applySorting($sortBy);

        // Server-side pagination with query preservation
        $perPage = (int) $request->input('per_page', 10);
        if ($perPage < 1 || $perPage > 100) {
            $perPage = 10;
        }

        $products = $query->paginate($perPage)->withQueryString();

        // 4. Critical Stock Replenishment data for bottom widget
        $criticalReplenishment = Product::where('stock_quantity', '<=', 20)
            ->orderBy('stock_quantity', 'asc')
            ->take(2)
            ->get();

        // 5. SKU Category Breakdown for bottom widget
        $categoryBreakdown = Product::selectRaw('category, count(*) as count')
            ->groupBy('category')
            ->orderByDesc('count')
            ->get()
            ->map(function ($item) use ($totalProducts) {
                $percentage = $totalProducts > 0 ? round(($item->count / $totalProducts) * 100, 1) : 0;
                return [
                    'category' => $item->category,
                    'count' => $item->count,
                    'percentage' => $percentage,
                ];
            });

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $products,
                'metrics' => [
                    'total' => $totalProducts,
                    'active' => $activeProducts,
                    'low_stock' => $lowStockProducts,
                    'out_of_stock' => $outOfStockProducts,
                    'coverage' => $coveragePercentage,
                ],
            ]);
        }

        return view('products.index', compact(
            'products',
            'categories',
            'totalProducts',
            'activeProducts',
            'lowStockProducts',
            'outOfStockProducts',
            'coveragePercentage',
            'criticalReplenishment',
            'categoryBreakdown'
        ));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(StoreProductRequest $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validated();

        // Handle Image Upload
        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($validated);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Product '{$product->name}' created successfully!",
                'product' => $product,
            ]);
        }

        return redirect()->route('products.index')
            ->with('success', "Product '{$product->name}' created successfully!");
    }

    /**
     * Display the specified product (JSON for modal / details).
     */
    public function show(Product $product, Request $request): View|JsonResponse
    {
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'product' => $product,
                'image_url' => $product->image_url,
            ]);
        }

        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product (JSON for modal / page).
     */
    public function edit(Product $product, Request $request): View|JsonResponse
    {
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'product' => $product,
                'image_url' => $product->image_url,
            ]);
        }

        $categories = Product::distinct()->whereNotNull('category')->orderBy('category')->pluck('category');

        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse|JsonResponse
    {
        $validated = $request->validated();

        // Handle Image Upload & Replacement
        if ($request->hasFile('image')) {
            // Delete old physical image if stored locally
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Product '{$product->name}' updated successfully!",
                'product' => $product,
            ]);
        }

        return redirect()->route('products.index')
            ->with('success', "Product '{$product->name}' updated successfully! Changes synchronized to multi-channel inventory.");
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product, Request $request): RedirectResponse|JsonResponse
    {
        $productName = $product->name;

        // Delete physical image if exists
        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Product '{$productName}' deleted successfully.",
            ]);
        }

        return redirect()->route('products.index')
            ->with('success', "Product '{$productName}' deleted successfully.");
    }

    /**
     * Generate a unique SKU according to category prefix and random code.
     */
    public function generateSku(Request $request): JsonResponse
    {
        $category = $request->input('category', 'PROD');
        $prefix = match (strtoupper(substr($category, 0, 3))) {
            'APP' => 'APP',
            'ELE' => 'ELE',
            'HOM' => 'HOM',
            'ACC' => 'ACC',
            'FOO' => 'FOO',
            default => 'PRD',
        };

        do {
            $randomCode = strtoupper(Str::random(3)) . '-' . mt_rand(100, 999);
            $sku = "{$prefix}-{$randomCode}";
        } while (Product::where('sku', $sku)->exists());

        return response()->json([
            'success' => true,
            'sku' => $sku,
        ]);
    }

    /**
     * Handle bulk actions (bulk delete, bulk activate, bulk deactivate).
     */
    public function bulk(Request $request): RedirectResponse
    {
        $action = $request->input('bulk_action');
        $ids = $request->input('selected_ids', []);

        if (empty($ids) || !is_array($ids)) {
            return redirect()->route('products.index')
                ->with('error', 'No products were selected for bulk action.');
        }

        $products = Product::whereIn('id', $ids);
        $count = $products->count();

        match ($action) {
            'delete' => (function () use ($products) {
                foreach ($products->get() as $p) {
                    if ($p->image_path && Storage::disk('public')->exists($p->image_path)) {
                        Storage::disk('public')->delete($p->image_path);
                    }
                }
                $products->delete();
            })(),
            'mark_active' => $products->update(['status' => 'Active']),
            'mark_inactive' => $products->update(['status' => 'Inactive']),
            'mark_draft' => $products->update(['status' => 'Draft']),
            default => null,
        };

        return redirect()->route('products.index')
            ->with('success', "Bulk action '{$action}' applied successfully to {$count} products.");
    }

    /**
     * Export products to CSV format.
     */
    public function export(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $query->search($request->input('search'));
        }
        if ($request->filled('category')) {
            $query->filterCategory($request->input('category'));
        }
        if ($request->filled('status')) {
            $query->filterStatus($request->input('status'));
        }

        $products = $query->orderBy('id', 'asc')->get();

        $filename = 'products_export_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($products) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'SKU', 'Category', 'Price', 'Sale Price', 'Stock Quantity', 'Status', 'Created At']);

            foreach ($products as $product) {
                fputcsv($file, [
                    $product->id,
                    $product->name,
                    $product->sku,
                    $product->category,
                    $product->price,
                    $product->sale_price ?? 'N/A',
                    $product->stock_quantity,
                    $product->status,
                    $product->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
