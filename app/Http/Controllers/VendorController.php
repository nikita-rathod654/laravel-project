<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VendorController extends Controller
{
    public function index(Request $request): View
    {
        $userId = auth()->id();
        $baseQuery = Vendor::where('user_id', $userId);

        $query = (clone $baseQuery);

        if ($request->filled('search')) {
            $term = trim($request->input('search'));
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('company_name', 'like', "%{$term}%")
                  ->orWhere('email', 'like', "%{$term}%");
            });
        }

        if ($request->filled('category') && $request->input('category') !== 'All') {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('status') && $request->input('status') !== 'All') {
            $query->where('status', $request->input('status'));
        }

        $vendors = $query->latest()->paginate(10)->withQueryString();

        $totalVendors = (clone $baseQuery)->count();
        $activeVendors = (clone $baseQuery)->where('status', 'Active')->count();
        $onHoldVendors = (clone $baseQuery)->where('status', 'On-Hold')->count();
        $categories = (clone $baseQuery)->distinct('category')->pluck('category');

        return view('vendors.index', compact(
            'vendors',
            'totalVendors',
            'activeVendors',
            'onHoldVendors',
            'categories'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:vendors,email',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'category' => 'required|string|max:100',
            'payment_terms' => 'required|string|max:50',
            'status' => 'required|in:Active,Inactive,On-Hold',
            'rating' => 'nullable|numeric|min:1|max:5',
        ]);

        if (empty($validated['rating'])) {
            $validated['rating'] = 4.5;
        }

        $validated['user_id'] = auth()->id();
        Vendor::create($validated);

        return redirect()->route('vendors.index')->with('success', "Vendor '{$validated['company_name']}' onboarded successfully!");
    }

    public function update(Request $request, Vendor $vendor): RedirectResponse
    {
        if ($vendor->user_id !== auth()->id()) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:vendors,email,' . $vendor->id,
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'category' => 'required|string|max:100',
            'payment_terms' => 'required|string|max:50',
            'status' => 'required|in:Active,Inactive,On-Hold',
            'rating' => 'nullable|numeric|min:1|max:5',
        ]);

        $vendor->update($validated);

        return redirect()->route('vendors.index')->with('success', "Vendor '{$vendor->company_name}' updated successfully!");
    }

    public function destroy(Vendor $vendor): RedirectResponse
    {
        if ($vendor->user_id !== auth()->id()) {
            abort(404);
        }

        $name = $vendor->company_name;
        $vendor->delete();

        return redirect()->route('vendors.index')->with('success', "Vendor '{$name}' deleted.");
    }
}
