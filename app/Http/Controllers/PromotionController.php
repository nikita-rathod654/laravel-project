<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PromotionController extends Controller
{
    public function index(Request $request): View
    {
        $userId = auth()->id();
        $baseQuery = Promotion::where('user_id', $userId);

        $query = (clone $baseQuery);

        if ($request->filled('search')) {
            $term = trim($request->input('search'));
            $query->where(function ($q) use ($term) {
                $q->where('code', 'like', "%{$term}%")
                  ->orWhere('title', 'like', "%{$term}%");
            });
        }

        if ($request->filled('status') && $request->input('status') !== 'All') {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('type') && $request->input('type') !== 'All') {
            $query->where('discount_type', $request->input('type'));
        }

        $promotions = $query->latest()->paginate(10)->withQueryString();

        $totalPromos = (clone $baseQuery)->count();
        $activePromos = (clone $baseQuery)->where('status', 'Active')->count();
        $expiredPromos = (clone $baseQuery)->where('status', 'Expired')->count();
        $totalRedeemed = (clone $baseQuery)->sum('used_count');

        return view('promotions.index', compact(
            'promotions',
            'totalPromos',
            'activePromos',
            'expiredPromos',
            'totalRedeemed'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:promotions,code',
            'title' => 'required|string|max:255',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0.01',
            'min_spend' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'status' => 'required|in:Active,Expired,Disabled',
        ]);

        $validated['code'] = strtoupper(trim($validated['code']));
        $validated['user_id'] = auth()->id();
        Promotion::create($validated);

        return redirect()->route('promotions.index')->with('success', "Coupon '{$validated['code']}' created successfully!");
    }

    public function update(Request $request, Promotion $promotion): RedirectResponse
    {
        if ($promotion->user_id !== auth()->id()) {
            abort(404);
        }

        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:promotions,code,' . $promotion->id,
            'title' => 'required|string|max:255',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0.01',
            'min_spend' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'status' => 'required|in:Active,Expired,Disabled',
        ]);

        $validated['code'] = strtoupper(trim($validated['code']));
        $promotion->update($validated);

        return redirect()->route('promotions.index')->with('success', "Coupon '{$promotion->code}' updated successfully!");
    }

    public function destroy(Promotion $promotion): RedirectResponse
    {
        if ($promotion->user_id !== auth()->id()) {
            abort(404);
        }

        $code = $promotion->code;
        $promotion->delete();

        return redirect()->route('promotions.index')->with('success', "Coupon '{$code}' deleted.");
    }
}
