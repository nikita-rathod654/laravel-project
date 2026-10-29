<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function index(Request $request): View
    {
        $userId = auth()->id();
        $baseQuery = Store::where('user_id', $userId);

        $query = (clone $baseQuery);

        if ($request->filled('search')) {
            $term = trim($request->input('search'));
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('code', 'like', "%{$term}%")
                  ->orWhere('city', 'like', "%{$term}%");
            });
        }

        if ($request->filled('status') && $request->input('status') !== 'All') {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('type') && $request->input('type') !== 'All') {
            $query->where('type', $request->input('type'));
        }

        $stores = $query->latest()->paginate(10)->withQueryString();

        $totalStores = (clone $baseQuery)->count();
        $activeStores = (clone $baseQuery)->where('status', 'Active')->count();
        $maintenanceStores = (clone $baseQuery)->where('status', 'Maintenance')->count();
        $citiesCount = (clone $baseQuery)->distinct('city')->count('city');

        return view('stores.index', compact(
            'stores',
            'totalStores',
            'activeStores',
            'maintenanceStores',
            'citiesCount'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:stores,code',
            'type' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'phone' => 'nullable|string|max:50',
            'manager_name' => 'nullable|string|max:100',
            'status' => 'required|in:Active,Maintenance,Closed',
        ]);

        $validated['user_id'] = auth()->id();
        Store::create($validated);

        return redirect()->route('stores.index')->with('success', "Store '{$validated['name']}' created successfully!");
    }

    public function update(Request $request, Store $store): RedirectResponse
    {
        if ($store->user_id !== auth()->id()) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:stores,code,' . $store->id,
            'type' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'phone' => 'nullable|string|max:50',
            'manager_name' => 'nullable|string|max:100',
            'status' => 'required|in:Active,Maintenance,Closed',
        ]);

        $store->update($validated);

        return redirect()->route('stores.index')->with('success', "Store '{$store->name}' updated successfully!");
    }

    public function destroy(Store $store): RedirectResponse
    {
        if ($store->user_id !== auth()->id()) {
            abort(404);
        }

        $name = $store->name;
        $store->delete();

        return redirect()->route('stores.index')->with('success', "Store '{$name}' removed from registry.");
    }
}
