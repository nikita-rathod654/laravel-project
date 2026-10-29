@extends('layouts.app')

@section('title', 'Promotions & Discounts')

@section('breadcrumbs')
    <span class="text-slate-400 font-medium">Enterprise</span>
    <span class="text-slate-300">/</span>
    <h1 class="text-slate-900 font-bold text-base tracking-tight">Coupons & Promotional Rules</h1>
@endsection

@section('content')
<div class="space-y-6">

    <!-- KPI Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Coupons</span>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">{{ $totalPromos }}</h3>
            <span class="text-xs text-slate-500 mt-2 block">Configured promotional offers</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Active Campaigns</span>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-emerald-600 mt-1">{{ $activePromos }}</h3>
            <span class="text-xs text-emerald-600 font-semibold mt-2 block">Usable at checkout & POS</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Expired / Disabled</span>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-700 mt-1">{{ $expiredPromos }}</h3>
            <span class="text-xs text-slate-400 mt-2 block">Past validity or closed</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Redemptions</span>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-blue-600 mt-1">{{ number_format($totalRedeemed) }}</h3>
            <span class="text-xs text-blue-600 font-semibold mt-2 block">Customer redemptions tracked</span>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        
        <!-- Toolbar -->
        <div class="p-5 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <form action="{{ route('promotions.index') }}" method="GET" class="flex flex-wrap items-center gap-3 flex-1">
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
                           placeholder="Search coupon code or title..." 
                           class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                </div>

                <!-- Status Filter -->
                <select name="status" onchange="this.form.submit()" class="py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="All" {{ request('status') === 'All' ? 'selected' : '' }}>All Statuses</option>
                    <option value="Active" {{ request('status') === 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Expired" {{ request('status') === 'Expired' ? 'selected' : '' }}>Expired</option>
                    <option value="Disabled" {{ request('status') === 'Disabled' ? 'selected' : '' }}>Disabled</option>
                </select>

                <!-- Type Filter -->
                <select name="type" onchange="this.form.submit()" class="py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="All" {{ request('type') === 'All' ? 'selected' : '' }}>All Types</option>
                    <option value="percentage" {{ request('type') === 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                    <option value="fixed" {{ request('type') === 'fixed' ? 'selected' : '' }}>Fixed Amount ($)</option>
                </select>

                @if (request()->hasAny(['search', 'status', 'type']))
                    <a href="{{ route('promotions.index') }}" class="text-xs text-rose-600 hover:text-rose-700 font-semibold px-2 py-1">Reset</a>
                @endif
            </form>

            <button type="button" 
                    onclick="openCreatePromoModal()" 
                    class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs sm:text-sm rounded-xl shadow-xs transition-colors flex items-center justify-center gap-2 shrink-0">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span>New Promotion Code</span>
            </button>
        </div>

        <!-- Table View -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/50 text-slate-400 uppercase text-[10px] tracking-wider font-bold">
                        <th class="py-3 px-5">Coupon Code</th>
                        <th class="py-3 px-5">Title & Campaign</th>
                        <th class="py-3 px-5">Discount</th>
                        <th class="py-3 px-5">Min Spend</th>
                        <th class="py-3 px-5">Usage Limit</th>
                        <th class="py-3 px-5">Validity</th>
                        <th class="py-3 px-5">Status</th>
                        <th class="py-3 px-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($promotions as $promo)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="py-4 px-5">
                                <div class="inline-flex items-center gap-2">
                                    <span class="font-mono font-extrabold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-lg border border-blue-200">
                                        {{ $promo->code }}
                                    </span>
                                    <button type="button" onclick="navigator.clipboard.writeText('{{ $promo->code }}'); alert('Code copied to clipboard: {{ $promo->code }}');" class="text-slate-400 hover:text-slate-600" title="Copy Code">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            <td class="py-4 px-5">
                                <span class="font-bold text-slate-900 block">{{ $promo->title }}</span>
                            </td>
                            <td class="py-4 px-5">
                                @if ($promo->discount_type === 'percentage')
                                    <span class="font-extrabold text-emerald-600 text-sm">{{ floatval($promo->discount_value) }}% OFF</span>
                                @else
                                    <span class="font-extrabold text-blue-600 text-sm">${{ number_format($promo->discount_value, 2) }} FLAT</span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-slate-600">
                                ${{ number_format($promo->min_spend, 2) }}
                            </td>
                            <td class="py-4 px-5">
                                <div class="font-semibold text-slate-800">{{ $promo->used_count }} / {{ $promo->usage_limit ?? '∞' }}</div>
                                @if ($promo->usage_limit)
                                    <div class="w-24 bg-slate-100 rounded-full h-1.5 mt-1 overflow-hidden">
                                        <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ min(100, round(($promo->used_count / $promo->usage_limit) * 100)) }}%;"></div>
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-xs text-slate-500 whitespace-nowrap">
                                @if ($promo->expires_at)
                                    <span>Until {{ $promo->expires_at->format('M d, Y') }}</span>
                                @else
                                    <span class="text-emerald-600 font-semibold">No Expiration</span>
                                @endif
                            </td>
                            <td class="py-4 px-5">
                                @if ($promo->status === 'Active')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">Active</span>
                                @elseif ($promo->status === 'Expired')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700">Expired</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-100 text-rose-800">Disabled</span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button" 
                                            onclick='openEditPromoModal(@json($promo))'
                                            class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit Promo">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('promotions.destroy', $promo) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete coupon {{ $promo->code }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Delete Promo">
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
                                No promotions found matching your search.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-slate-100 flex items-center justify-between">
            <div class="text-xs text-slate-500">
                Showing {{ $promotions->firstItem() ?? 0 }} to {{ $promotions->lastItem() ?? 0 }} of {{ $promotions->total() }} coupons
            </div>
            <div>
                {{ $promotions->links() }}
            </div>
        </div>
    </div>

</div>

<!-- Create / Edit Promotion Modal -->
<div id="promoModal" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl border border-slate-100 relative animate-fade-in">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <h3 id="promoModalTitle" class="text-base font-bold text-slate-900">Create New Coupon Code</h3>
            <button type="button" onclick="closePromoModal()" class="text-slate-400 hover:text-slate-600">
                &times;
            </button>
        </div>

        <form id="promoForm" method="POST" action="{{ route('promotions.store') }}" class="space-y-4 pt-4">
            @csrf
            <div id="promoMethodSpoof"></div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Coupon Code *</label>
                    <input type="text" name="code" id="promoCode" required placeholder="SUMMER25" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm font-mono uppercase focus:bg-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Discount Type *</label>
                    <select name="discount_type" id="promoType" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm">
                        <option value="percentage">Percentage (%)</option>
                        <option value="fixed">Fixed Flat ($)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Campaign Title / Description *</label>
                <input type="text" name="title" id="promoTitle" required placeholder="Exclusive Weekend 25% Off" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:bg-white focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Discount Value *</label>
                    <input type="number" step="0.01" min="0.01" name="discount_value" id="promoValue" required placeholder="25.00" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:bg-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Minimum Order Spend ($)</label>
                    <input type="number" step="0.01" min="0" name="min_spend" id="promoMinSpend" value="0.00" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:bg-white focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Total Usage Limit</label>
                    <input type="number" min="1" name="usage_limit" id="promoLimit" placeholder="e.g. 500" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:bg-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status *</label>
                    <select name="status" id="promoStatus" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm">
                        <option value="Active">Active</option>
                        <option value="Expired">Expired</option>
                        <option value="Disabled">Disabled</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Start Date</label>
                    <input type="date" name="starts_at" id="promoStartsAt" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:bg-white">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Expiration Date</label>
                    <input type="date" name="expires_at" id="promoExpiresAt" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:bg-white">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <button type="button" onclick="closePromoModal()" class="px-4 py-2 border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs sm:text-sm font-semibold rounded-xl">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-bold rounded-xl shadow-xs">Save Coupon</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openCreatePromoModal() {
        document.getElementById('promoModalTitle').innerText = 'Create New Coupon Code';
        document.getElementById('promoForm').action = "{{ route('promotions.store') }}";
        document.getElementById('promoMethodSpoof').innerHTML = '';
        document.getElementById('promoCode').value = '';
        document.getElementById('promoType').value = 'percentage';
        document.getElementById('promoTitle').value = '';
        document.getElementById('promoValue').value = '';
        document.getElementById('promoMinSpend').value = '0.00';
        document.getElementById('promoLimit').value = '';
        document.getElementById('promoStatus').value = 'Active';
        document.getElementById('promoStartsAt').value = '';
        document.getElementById('promoExpiresAt').value = '';
        document.getElementById('promoModal').classList.remove('hidden');
    }

    function openEditPromoModal(p) {
        document.getElementById('promoModalTitle').innerText = `Edit Coupon '${p.code}'`;
        document.getElementById('promoForm').action = `/promotions/${p.id}`;
        document.getElementById('promoMethodSpoof').innerHTML = '@method("PUT")';
        document.getElementById('promoCode').value = p.code;
        document.getElementById('promoType').value = p.discount_type;
        document.getElementById('promoTitle').value = p.title;
        document.getElementById('promoValue').value = p.discount_value;
        document.getElementById('promoMinSpend').value = p.min_spend;
        document.getElementById('promoLimit').value = p.usage_limit || '';
        document.getElementById('promoStatus').value = p.status;
        document.getElementById('promoStartsAt').value = p.starts_at ? p.starts_at.substring(0, 10) : '';
        document.getElementById('promoExpiresAt').value = p.expires_at ? p.expires_at.substring(0, 10) : '';
        document.getElementById('promoModal').classList.remove('hidden');
    }

    function closePromoModal() {
        document.getElementById('promoModal').classList.add('hidden');
    }
</script>
@endpush
@endsection
