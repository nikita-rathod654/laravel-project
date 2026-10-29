@extends('layouts.app')

@section('title', 'Marketing Management')

@section('breadcrumbs')
    <span class="text-slate-400 font-medium">Enterprise</span>
    <span class="text-slate-300">/</span>
    <h1 class="text-slate-900 font-bold text-base tracking-tight">Campaigns & Growth Marketing</h1>
@endsection

@section('content')
<div class="space-y-6">

    <!-- KPI Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Allocated Budget</span>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">${{ number_format($totalBudget, 2) }}</h3>
            <span class="text-xs text-slate-500 mt-2 block">Approved quarterly expenditure</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Ad Spend</span>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-blue-600 mt-1">${{ number_format($totalSpent, 2) }}</h3>
            <div class="w-full bg-slate-100 rounded-full h-1.5 mt-2 overflow-hidden">
                <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $totalBudget > 0 ? min(100, round(($totalSpent / $totalBudget) * 100)) : 0 }}%;"></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Gross Impressions</span>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-purple-600 mt-1">{{ number_format($totalImpressions) }}</h3>
            <span class="text-xs text-purple-600 font-semibold mt-2 block">Reach across Google, Meta, & Email</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Attributed Conversions</span>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-emerald-600 mt-1">{{ number_format($totalConversions) }}</h3>
            <span class="text-xs text-emerald-600 font-semibold mt-2 block">New customer orders secured</span>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        
        <!-- Toolbar -->
        <div class="p-5 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <form action="{{ route('marketing.index') }}" method="GET" class="flex flex-wrap items-center gap-3 flex-1">
                <!-- Search -->
                <div class="relative w-full sm:w-64">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Search campaign, audience..." 
                           class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                </div>

                <!-- Channel Filter -->
                <select name="channel" onchange="this.form.submit()" class="py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="All" {{ request('channel') === 'All' ? 'selected' : '' }}>All Channels</option>
                    <option value="Social Media" {{ request('channel') === 'Social Media' ? 'selected' : '' }}>Social Media (Meta, TikTok)</option>
                    <option value="Google Ads" {{ request('channel') === 'Google Ads' ? 'selected' : '' }}>Google Search & Display</option>
                    <option value="Email" {{ request('channel') === 'Email' ? 'selected' : '' }}>Email Blasts</option>
                    <option value="SMS" {{ request('channel') === 'SMS' ? 'selected' : '' }}>SMS Retargeting</option>
                </select>

                <!-- Status Filter -->
                <select name="status" onchange="this.form.submit()" class="py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="All" {{ request('status') === 'All' ? 'selected' : '' }}>All Statuses</option>
                    <option value="Active" {{ request('status') === 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Draft" {{ request('status') === 'Draft' ? 'selected' : '' }}>Draft</option>
                    <option value="Paused" {{ request('status') === 'Paused' ? 'selected' : '' }}>Paused</option>
                    <option value="Completed" {{ request('status') === 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>

                @if (request()->hasAny(['search', 'channel', 'status']))
                    <a href="{{ route('marketing.index') }}" class="text-xs text-rose-600 hover:text-rose-700 font-semibold px-2 py-1">Reset</a>
                @endif
            </form>

            <button type="button" 
                    onclick="openCreateCampaignModal()" 
                    class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs sm:text-sm rounded-xl shadow-xs transition-colors flex items-center justify-center gap-2 shrink-0">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span>Launch Campaign</span>
            </button>
        </div>

        <!-- Table View -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/50 text-slate-400 uppercase text-[10px] tracking-wider font-bold">
                        <th class="py-3 px-5">Campaign & Audience</th>
                        <th class="py-3 px-5">Channel</th>
                        <th class="py-3 px-5">Budget vs Spent</th>
                        <th class="py-3 px-5">Impressions</th>
                        <th class="py-3 px-5">Clicks (CTR)</th>
                        <th class="py-3 px-5">Conversions</th>
                        <th class="py-3 px-5">Status</th>
                        <th class="py-3 px-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($campaigns as $camp)
                        @php
                            $ctr = $camp->impressions > 0 ? round(($camp->clicks / $camp->impressions) * 100, 2) : 0;
                            $budgetPercent = $camp->budget > 0 ? min(100, round(($camp->spent / $camp->budget) * 100)) : 0;
                        @endphp
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="py-4 px-5">
                                <div class="font-bold text-slate-900">{{ $camp->name }}</div>
                                <div class="text-xs text-slate-400">{{ $camp->target_audience ?? 'Broad audience' }}</div>
                            </td>
                            <td class="py-4 px-5">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    {{ $camp->channel }}
                                </span>
                            </td>
                            <td class="py-4 px-5">
                                <div class="font-bold text-slate-900">${{ number_format($camp->spent, 2) }} <span class="font-normal text-xs text-slate-400">/ ${{ number_format($camp->budget, 2) }}</span></div>
                                <div class="w-28 bg-slate-100 rounded-full h-1.5 mt-1 overflow-hidden">
                                    <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $budgetPercent }}%;"></div>
                                </div>
                            </td>
                            <td class="py-4 px-5 font-medium text-slate-800">
                                {{ number_format($camp->impressions) }}
                            </td>
                            <td class="py-4 px-5">
                                <div class="font-bold text-slate-900">{{ number_format($camp->clicks) }}</div>
                                <span class="text-[10px] text-blue-600 font-semibold">{{ $ctr }}% CTR</span>
                            </td>
                            <td class="py-4 px-5">
                                <span class="font-extrabold text-emerald-600 text-sm">{{ number_format($camp->conversions) }}</span>
                                <span class="text-[10px] text-slate-400 block">Orders</span>
                            </td>
                            <td class="py-4 px-5">
                                @if ($camp->status === 'Active')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">Active</span>
                                @elseif ($camp->status === 'Paused')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800">Paused</span>
                                @elseif ($camp->status === 'Completed')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700">Completed</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-purple-100 text-purple-800">Draft</span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button" 
                                            onclick='openEditCampaignModal(@json($camp))'
                                            class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit Campaign">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('marketing.destroy', $camp) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete campaign {{ $camp->name }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Delete Campaign">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-10 text-center text-slate-400">
                                No marketing campaigns found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-slate-100 flex items-center justify-between">
            <div class="text-xs text-slate-500">
                Showing {{ $campaigns->firstItem() ?? 0 }} to {{ $campaigns->lastItem() ?? 0 }} of {{ $campaigns->total() }} campaigns
            </div>
            <div>
                {{ $campaigns->links() }}
            </div>
        </div>
    </div>

</div>

<!-- Create / Edit Campaign Modal -->
<div id="campaignModal" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl border border-slate-100 relative animate-fade-in">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <h3 id="campaignModalTitle" class="text-base font-bold text-slate-900">Launch Marketing Campaign</h3>
            <button type="button" onclick="closeCampaignModal()" class="text-slate-400 hover:text-slate-600">
                &times;
            </button>
        </div>

        <form id="campaignForm" method="POST" action="{{ route('marketing.store') }}" class="space-y-4 pt-4">
            @csrf
            <div id="campaignMethodSpoof"></div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Campaign Name *</label>
                <input type="text" name="name" id="campName" required placeholder="Summer Launch 2026" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:bg-white focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Channel *</label>
                    <select name="channel" id="campChannel" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm">
                        <option value="Social Media">Social Media</option>
                        <option value="Google Ads">Google Ads</option>
                        <option value="Email">Email</option>
                        <option value="SMS">SMS</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status *</label>
                    <select name="status" id="campStatus" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm">
                        <option value="Active">Active</option>
                        <option value="Draft">Draft</option>
                        <option value="Paused">Paused</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Target Audience Demographics</label>
                <input type="text" name="target_audience" id="campAudience" placeholder="e.g. Young Adults 18-35 interested in tech" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:bg-white focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Total Budget ($) *</label>
                    <input type="number" step="0.01" min="0" name="budget" id="campBudget" required placeholder="2500.00" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:bg-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Spent To Date ($)</label>
                    <input type="number" step="0.01" min="0" name="spent" id="campSpent" value="0.00" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:bg-white focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Start Date</label>
                    <input type="date" name="start_date" id="campStartDate" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:bg-white">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">End Date</label>
                    <input type="date" name="end_date" id="campEndDate" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:bg-white">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <button type="button" onclick="closeCampaignModal()" class="px-4 py-2 border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs sm:text-sm font-semibold rounded-xl">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-bold rounded-xl shadow-xs">Save Campaign</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openCreateCampaignModal() {
        document.getElementById('campaignModalTitle').innerText = 'Launch Marketing Campaign';
        document.getElementById('campaignForm').action = "{{ route('marketing.store') }}";
        document.getElementById('campaignMethodSpoof').innerHTML = '';
        document.getElementById('campName').value = '';
        document.getElementById('campChannel').value = 'Social Media';
        document.getElementById('campStatus').value = 'Active';
        document.getElementById('campAudience').value = '';
        document.getElementById('campBudget').value = '';
        document.getElementById('campSpent').value = '0.00';
        document.getElementById('campStartDate').value = '';
        document.getElementById('campEndDate').value = '';
        document.getElementById('campaignModal').classList.remove('hidden');
    }

    function openEditCampaignModal(c) {
        document.getElementById('campaignModalTitle').innerText = `Edit '${c.name}'`;
        document.getElementById('campaignForm').action = `/marketing/${c.id}`;
        document.getElementById('campaignMethodSpoof').innerHTML = '@method("PUT")';
        document.getElementById('campName').value = c.name;
        document.getElementById('campChannel').value = c.channel;
        document.getElementById('campStatus').value = c.status;
        document.getElementById('campAudience').value = c.target_audience || '';
        document.getElementById('campBudget').value = c.budget;
        document.getElementById('campSpent').value = c.spent || '0.00';
        document.getElementById('campStartDate').value = c.start_date ? c.start_date.substring(0, 10) : '';
        document.getElementById('campEndDate').value = c.end_date ? c.end_date.substring(0, 10) : '';
        document.getElementById('campaignModal').classList.remove('hidden');
    }

    function closeCampaignModal() {
        document.getElementById('campaignModal').classList.add('hidden');
    }
</script>
@endpush
@endsection
