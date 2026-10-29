@extends('layouts.app')

@section('title', 'Executive Overview')

@section('breadcrumbs')
    <span class="text-slate-400 font-medium">Enterprise</span>
    <span class="text-slate-300">/</span>
    <h1 class="text-slate-900 font-bold text-base tracking-tight">Dashboard Overview</h1>
@endsection

@section('content')
<div class="space-y-6">

    <!-- Top Welcome Banner -->
    <div class="bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-700 rounded-2xl p-6 sm:p-8 text-white shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-white/15 backdrop-blur-xs text-xs font-semibold text-blue-100 mb-2">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                <span>System Operational • Multi-Store Connected</span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Welcome to Ace360degree Suite</h2>
            <p class="text-blue-100 text-sm mt-1 max-w-xl">
                Unified retail hub managing products, multi-channel orders, point-of-sale terminals, and inventory synchronization across all branch stores.
            </p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('pos.index') }}" class="px-4 py-2.5 bg-white text-blue-700 hover:bg-blue-50 font-bold text-sm rounded-xl shadow-xs transition-colors flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                <span>Launch POS</span>
            </a>
            <a href="{{ route('products.index') }}" class="px-4 py-2.5 bg-blue-800/80 hover:bg-blue-800 text-white font-semibold text-sm rounded-xl border border-white/20 transition-colors">
                Catalog
            </a>
        </div>
    </div>

    <!-- 1. KPI Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Total Revenue -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Sales Revenue</span>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1 tracking-tight">${{ number_format($totalRevenue, 2) }}</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1.5 text-xs font-semibold text-emerald-600">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
                <span>Settled in MySQL Database</span>
            </div>
        </div>

        <!-- Orders -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Orders</span>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1 tracking-tight">{{ number_format($totalOrders) }}</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-xs font-medium text-slate-500">
                <span class="text-emerald-600 font-semibold">{{ $completedOrders }} Completed</span>
                <span>•</span>
                <span class="text-amber-600 font-semibold">{{ $pendingOrders }} Pending</span>
            </div>
        </div>

        <!-- Catalog Products -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Active Inventory</span>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1 tracking-tight">{{ number_format($activeProducts) }}</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1.5 text-xs font-semibold {{ $lowStockProducts > 0 ? 'text-rose-600' : 'text-slate-500' }}">
                <span>{{ $lowStockProducts }} low stock alerts</span>
            </div>
        </div>

        <!-- Stores & Outlets -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Store Branches</span>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1 tracking-tight">{{ number_format($activeStores) }} / {{ $totalStores }}</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-xs font-medium text-slate-500">
                <span class="text-purple-600 font-semibold">{{ $totalVendors }} Vendors</span>
                <span>•</span>
                <span class="text-blue-600 font-semibold">{{ $activePromotions }} Promos</span>
            </div>
        </div>
    </div>

    <!-- 2. Charts & Performance Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Weekly Sales Trend Chart (Tailwind + CSS Bars) -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Weekly Revenue Trajectory</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Aggregated retail and POS store performance</p>
                </div>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600">Past 7 Days</span>
            </div>

            <!-- Visual Bar Chart -->
            <div class="pt-6 pb-2">
                <div class="h-48 flex items-end gap-3 sm:gap-6 justify-between px-2">
                    @foreach ($weeklySales as $bar)
                        @php
                            $maxAmount = 4500;
                            $heightPercent = min(100, max(15, ($bar['amount'] / $maxAmount) * 100));
                        @endphp
                        <div class="flex-1 flex flex-col items-center gap-2 group cursor-pointer">
                            <div class="text-[11px] font-bold text-slate-700 opacity-0 group-hover:opacity-100 transition-opacity">
                                ${{ number_format($bar['amount']) }}
                            </div>
                            <div class="w-full bg-slate-100 rounded-t-xl relative overflow-hidden flex items-end justify-center" style="height: 150px;">
                                <div class="w-full bg-blue-600 group-hover:bg-blue-500 rounded-t-xl transition-all duration-300" 
                                     style="height: {{ $heightPercent }}%;"></div>
                            </div>
                            <span class="text-xs font-semibold text-slate-500 group-hover:text-blue-600 transition-colors">{{ $bar['day'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-md bg-blue-600"></span>
                    <span>Completed In-Store & Online Gross Volume</span>
                </div>
                <span class="font-bold text-slate-900">Target: $20,000 / wk</span>
            </div>
        </div>

        <!-- Quick Module Launchpad -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs flex flex-col justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900">Module Shortcuts</h3>
                <p class="text-xs text-slate-500 mt-0.5">Direct actions across Ace360degree</p>

                <div class="mt-4 space-y-2.5">
                    <a href="{{ route('pos.index') }}" class="p-3 rounded-xl border border-slate-100 hover:border-emerald-200 bg-slate-50/50 hover:bg-emerald-50/40 flex items-center justify-between transition-all group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="text-left">
                                <h4 class="text-xs font-bold text-slate-900 group-hover:text-emerald-700">Point of Sale (POS)</h4>
                                <span class="text-[10px] text-slate-400">Process instant cashier sales</span>
                            </div>
                        </div>
                        <span class="text-slate-400 group-hover:text-emerald-600 font-bold">&rarr;</span>
                    </a>

                    <a href="{{ route('products.index') }}" class="p-3 rounded-xl border border-slate-100 hover:border-blue-200 bg-slate-50/50 hover:bg-blue-50/40 flex items-center justify-between transition-all group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <div class="text-left">
                                <h4 class="text-xs font-bold text-slate-900 group-hover:text-blue-700">Products Catalog</h4>
                                <span class="text-[10px] text-slate-400">Create, edit, and filter items</span>
                            </div>
                        </div>
                        <span class="text-slate-400 group-hover:text-blue-600 font-bold">&rarr;</span>
                    </a>

                    <a href="{{ route('orders.index') }}" class="p-3 rounded-xl border border-slate-100 hover:border-purple-200 bg-slate-50/50 hover:bg-purple-50/40 flex items-center justify-between transition-all group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <div class="text-left">
                                <h4 class="text-xs font-bold text-slate-900 group-hover:text-purple-700">Order Dispatch</h4>
                                <span class="text-[10px] text-slate-400">Track and fulfill client orders</span>
                            </div>
                        </div>
                        <span class="text-slate-400 group-hover:text-purple-600 font-bold">&rarr;</span>
                    </a>

                    <a href="{{ route('promotions.index') }}" class="p-3 rounded-xl border border-slate-100 hover:border-amber-200 bg-slate-50/50 hover:bg-amber-50/40 flex items-center justify-between transition-all group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                            <div class="text-left">
                                <h4 class="text-xs font-bold text-slate-900 group-hover:text-amber-700">Promo Engine</h4>
                                <span class="text-[10px] text-slate-400">Coupon codes & flash discounts</span>
                            </div>
                        </div>
                        <span class="text-slate-400 group-hover:text-amber-600 font-bold">&rarr;</span>
                    </a>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                <span>Active Channels</span>
                <span class="font-semibold text-emerald-600">POS • Web • Store</span>
            </div>
        </div>
    </div>

    <!-- 3. Recent Orders & Inventory Alerts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Recent Orders (2 cols) -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 shadow-xs overflow-hidden">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Recent Customer Orders</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Live feed of transactions recorded across all channels</p>
                </div>
                <a href="{{ route('orders.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">View All Orders &rarr;</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 uppercase text-[10px] tracking-wider">
                            <th class="py-2.5 px-3">Order</th>
                            <th class="py-2.5 px-3">Customer</th>
                            <th class="py-2.5 px-3">Channel</th>
                            <th class="py-2.5 px-3">Total</th>
                            <th class="py-2.5 px-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse ($recentOrders as $ord)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-3 px-3 font-mono font-bold text-slate-900">
                                    {{ $ord->order_number }}
                                </td>
                                <td class="py-3 px-3">
                                    <div class="font-semibold text-slate-900">{{ $ord->customer_name }}</div>
                                    <span class="text-[10px] text-slate-400">{{ $ord->created_at->diffForHumans() }}</span>
                                </td>
                                <td class="py-3 px-3">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $ord->source === 'In-Store / POS' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-blue-50 text-blue-700 border border-blue-100' }}">
                                        {{ $ord->source }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 font-bold text-slate-900">
                                    ${{ number_format($ord->total_amount, 2) }}
                                </td>
                                <td class="py-3 px-3">
                                    @if ($ord->order_status === 'Completed')
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">Completed</span>
                                    @elseif ($ord->order_status === 'Processing')
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800">Processing</span>
                                    @elseif ($ord->order_status === 'Pending')
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800">Pending</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-rose-800">{{ $ord->order_status }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-slate-400">No orders recorded yet. Process a sale via POS to see it here!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Critical Low Stock Alerts (1 col) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-base font-bold text-slate-900">Inventory Alerts</h3>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-100">Restock Priority</span>
                </div>
                <p class="text-xs text-slate-500 mb-4">Items with stock at or below alert thresholds</p>

                <div class="space-y-3">
                    @forelse ($criticalInventory as $crit)
                        <div class="p-3 rounded-xl border border-slate-100 bg-slate-50/40 flex items-center justify-between">
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-slate-900 truncate max-w-[150px]">{{ $crit->name }}</span>
                                <span class="text-[10px] font-mono text-slate-400">{{ $crit->sku }} • {{ $crit->category }}</span>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-bold {{ $crit->stock_quantity == 0 ? 'text-rose-600' : 'text-amber-600' }}">
                                    {{ $crit->stock_quantity }} units left
                                </span>
                                <span class="block text-[10px] text-slate-400">${{ number_format($crit->price, 2) }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="py-8 text-center text-xs text-slate-400">All product inventories are well-stocked.</div>
                    @endforelse
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 mt-4">
                <a href="{{ route('products.index', ['status' => 'Active']) }}" class="w-full py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-colors block text-center">
                    Manage Full Inventory
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
