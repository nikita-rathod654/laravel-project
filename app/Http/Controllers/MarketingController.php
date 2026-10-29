<?php

namespace App\Http\Controllers;

use App\Models\MarketingCampaign;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MarketingController extends Controller
{
    public function index(Request $request): View
    {
        $query = MarketingCampaign::query();

        if ($request->filled('search')) {
            $term = trim($request->input('search'));
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('channel', 'like', "%{$term}%")
                  ->orWhere('target_audience', 'like', "%{$term}%");
            });
        }

        if ($request->filled('channel') && $request->input('channel') !== 'All') {
            $query->where('channel', $request->input('channel'));
        }

        if ($request->filled('status') && $request->input('status') !== 'All') {
            $query->where('status', $request->input('status'));
        }

        $campaigns = $query->latest()->paginate(10)->withQueryString();

        $totalBudget = MarketingCampaign::sum('budget');
        $totalSpent = MarketingCampaign::sum('spent');
        $totalImpressions = MarketingCampaign::sum('impressions');
        $totalConversions = MarketingCampaign::sum('conversions');
        $activeCampaigns = MarketingCampaign::where('status', 'Active')->count();

        return view('marketing.index', compact(
            'campaigns',
            'totalBudget',
            'totalSpent',
            'totalImpressions',
            'totalConversions',
            'activeCampaigns'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'channel' => 'required|string|max:100',
            'target_audience' => 'nullable|string|max:255',
            'budget' => 'required|numeric|min:0',
            'spent' => 'nullable|numeric|min:0',
            'status' => 'required|in:Draft,Active,Paused,Completed',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        if (!isset($validated['spent'])) {
            $validated['spent'] = 0;
        }

        MarketingCampaign::create($validated);

        return redirect()->route('marketing.index')->with('success', "Campaign '{$validated['name']}' launched successfully!");
    }

    public function update(Request $request, MarketingCampaign $campaign): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'channel' => 'required|string|max:100',
            'target_audience' => 'nullable|string|max:255',
            'budget' => 'required|numeric|min:0',
            'spent' => 'nullable|numeric|min:0',
            'status' => 'required|in:Draft,Active,Paused,Completed',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $campaign->update($validated);

        return redirect()->route('marketing.index')->with('success', "Campaign '{$campaign->name}' updated successfully!");
    }

    public function destroy(MarketingCampaign $campaign): RedirectResponse
    {
        $name = $campaign->name;
        $campaign->delete();

        return redirect()->route('marketing.index')->with('success', "Campaign '{$name}' deleted.");
    }
}
