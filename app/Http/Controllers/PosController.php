<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PosController extends Controller
{
    public function index(Request $request): View
    {
        $userId = auth()->id();

        $categories = Product::where('user_id', $userId)
            ->distinct()
            ->whereNotNull('category')
            ->orderBy('category')
            ->pluck('category');

        $products = Product::where('user_id', $userId)
            ->where('status', 'Active')
            ->where('stock_quantity', '>', 0)
            ->orderBy('name')
            ->get();

        $promotions = Promotion::where('user_id', $userId)
            ->where('status', 'Active')
            ->get();

        return view('pos.index', compact('categories', 'products', 'promotions'));
    }

    public function checkout(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string|in:Cash,Credit Card,UPI,Debit Card',
            'customer_name' => 'nullable|string|max:100',
            'coupon_code' => 'nullable|string|max:50',
            'amount_tendered' => 'nullable|numeric|min:0',
        ]);

        return DB::transaction(function () use ($validated) {
            $customerName = !empty($validated['customer_name']) ? $validated['customer_name'] : 'Walk-in Customer';
            $orderNumber = 'POS-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));

            $subtotal = 0;
            $orderItemsData = [];

            foreach ($validated['items'] as $item) {
                $product = Product::lockForUpdate()->find($item['product_id']);

                if (!$product) {
                    return response()->json([
                        'success' => false,
                        'message' => "Product not found.",
                    ], 422);
                }

                if ($product->stock_quantity < $item['quantity']) {
                    return response()->json([
                        'success' => false,
                        'message' => "Insufficient stock for '{$product->name}'. Available: {$product->stock_quantity}.",
                    ], 422);
                }

                $unitPrice = (float) $product->price;
                $lineSubtotal = round($unitPrice * $item['quantity'], 2);
                $subtotal += $lineSubtotal;

                // Decrement inventory in MySQL
                $product->decrement('stock_quantity', $item['quantity']);

                $orderItemsData[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'unit_price' => $unitPrice,
                    'quantity' => $item['quantity'],
                    'subtotal' => $lineSubtotal,
                ];
            }

            // Coupon discount calculation
            $discountAmount = 0;
            $appliedPromo = null;
            if (!empty($validated['coupon_code'])) {
                $promo = Promotion::where('code', strtoupper($validated['coupon_code']))
                    ->where('status', 'Active')
                    ->first();

                if ($promo) {
                    if ($subtotal >= (float) $promo->min_spend) {
                        if ($promo->discount_type === 'percentage') {
                            $discountAmount = round(($subtotal * (float) $promo->discount_value) / 100, 2);
                        } else {
                            $discountAmount = min($subtotal, (float) $promo->discount_value);
                        }
                        $promo->increment('used_count');
                        $appliedPromo = $promo->code;
                    }
                }
            }

            $taxRate = 0.08; // 8% sales tax
            $taxAmount = round(($subtotal - $discountAmount) * $taxRate, 2);
            $totalAmount = max(0, round($subtotal - $discountAmount + $taxAmount, 2));

            $amountTendered = isset($validated['amount_tendered']) ? (float) $validated['amount_tendered'] : $totalAmount;
            $changeAmount = max(0, round($amountTendered - $totalAmount, 2));

            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => $orderNumber,
                'customer_name' => $customerName,
                'customer_email' => null,
                'customer_phone' => null,
                'source' => 'In-Store / POS',
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'discount_amount' => $discountAmount,
                'total_amount' => $totalAmount,
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'Paid',
                'order_status' => 'Completed',
                'notes' => $appliedPromo ? "POS Transaction - Promo '{$appliedPromo}' applied" : "POS In-Store Checkout",
            ]);

            foreach ($orderItemsData as $itemData) {
                $order->items()->create($itemData);
            }

            return response()->json([
                'success' => true,
                'message' => "Order {$orderNumber} completed successfully!",
                'order' => [
                    'order_number' => $orderNumber,
                    'date' => now()->format('M d, Y h:i A'),
                    'customer' => $customerName,
                    'payment_method' => $validated['payment_method'],
                    'subtotal' => number_format($subtotal, 2),
                    'tax' => number_format($taxAmount, 2),
                    'discount' => number_format($discountAmount, 2),
                    'total' => number_format($totalAmount, 2),
                    'tendered' => number_format($amountTendered, 2),
                    'change' => number_format($changeAmount, 2),
                    'items' => $orderItemsData,
                ],
            ]);
        });
    }
}
