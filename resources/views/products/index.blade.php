@extends('layouts.app')

@section('content')
<div class="space-y-8" id="productManagementApp">

    <!-- 1. KPI Metrics Cards Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Total Products -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex flex-col justify-between transition-all hover:shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Products</span>
                    <h3 class="text-3xl font-extrabold text-slate-900 mt-1 tracking-tight">{{ number_format($totalProducts) }}</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1.5 text-xs font-semibold text-emerald-600">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
                <span>+3.2% from last month</span>
            </div>
        </div>

        <!-- Active Products -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex flex-col justify-between transition-all hover:shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Active Products</span>
                    <h3 class="text-3xl font-extrabold text-slate-900 mt-1 tracking-tight">{{ number_format($activeProducts) }}</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1.5 text-xs font-semibold text-emerald-600">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                <span>{{ $coveragePercentage }}% listing coverage</span>
            </div>
        </div>

        <!-- Low Stock Alert -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex flex-col justify-between transition-all hover:shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Low Stock Alert</span>
                    <h3 class="text-3xl font-extrabold text-rose-600 mt-1 tracking-tight">{{ number_format($lowStockProducts) }}</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1.5 text-xs font-semibold text-rose-600">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>Needs urgent restock</span>
            </div>
        </div>

        <!-- Out of Stock -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex flex-col justify-between transition-all hover:shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Out of Stock</span>
                    <h3 class="text-3xl font-extrabold text-slate-700 mt-1 tracking-tight">{{ number_format($outOfStockProducts) }}</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1.5 text-xs font-semibold text-slate-500">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243" />
                </svg>
                <span>Hidden from storefront</span>
            </div>
        </div>
    </div>

    <!-- 2. Main Table & Toolbar Card -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        
        <!-- Filter & Search Toolbar -->
        <div class="p-5 border-b border-slate-100">
            <form id="filterForm" action="{{ route('products.index') }}" method="GET" class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                
                <!-- Left: Search & Filter Selectors -->
                <div class="flex flex-wrap items-center gap-3 flex-1">
                    <!-- Search Input -->
                    <div class="relative min-w-[260px] flex-1 max-w-sm">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Filter by SKU or title..." 
                               class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white focus:border-transparent transition-all">
                    </div>

                    <!-- Category Filter -->
                    <div class="relative">
                        <select name="category" onchange="this.form.submit()" class="appearance-none pl-3.5 pr-8 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-100/70 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all cursor-pointer">
                            <option value="">All Categories</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-2.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div class="relative">
                        <select name="status" onchange="this.form.submit()" class="appearance-none pl-3.5 pr-8 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-100/70 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all cursor-pointer">
                            <option value="">All Status</option>
                            <option value="Active" {{ request('status') === 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Draft" {{ request('status') === 'Draft' ? 'selected' : '' }}>Draft</option>
                            <option value="Inactive" {{ request('status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-2.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    <!-- Sorting Dropdown -->
                    <div class="relative">
                        <select name="sort_by" onchange="this.form.submit()" class="appearance-none pl-3.5 pr-8 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-100/70 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all cursor-pointer">
                            <option value="latest" {{ request('sort_by', 'latest') === 'latest' ? 'selected' : '' }}>Sort by: Latest</option>
                            <option value="oldest" {{ request('sort_by') === 'oldest' ? 'selected' : '' }}>Sort by: Oldest</option>
                            <option value="price_asc" {{ request('sort_by') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort_by') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="stock_asc" {{ request('sort_by') === 'stock_asc' ? 'selected' : '' }}>Stock: Low to High</option>
                            <option value="stock_desc" {{ request('sort_by') === 'stock_desc' ? 'selected' : '' }}>Stock: High to Low</option>
                            <option value="name_asc" {{ request('sort_by') === 'name_asc' ? 'selected' : '' }}>Name: A-Z</option>
                            <option value="name_desc" {{ request('sort_by') === 'name_desc' ? 'selected' : '' }}>Name: Z-A</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-2.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    <!-- Reset Filters Button (visible when any filter or search is active) -->
                    @if (request()->hasAny(['search', 'category', 'status', 'sort_by']) && (request('search') || request('category') || request('status') || request('sort_by') !== 'latest'))
                        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-slate-500 hover:text-slate-800 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Reset Filters
                        </a>
                    @endif
                </div>

                <!-- Right: Bulk Actions, Export & Add Product Button -->
                <div class="flex items-center gap-3">
                    <!-- Bulk Actions Dropdown -->
                    <div class="relative">
                        <button type="button" id="bulkActionsBtn" onclick="toggleBulkMenu()" class="inline-flex items-center gap-2 px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-100 transition-all cursor-pointer">
                            <span>Bulk Actions</span>
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="bulkMenu" class="hidden absolute right-0 mt-1.5 w-44 bg-white border border-slate-200 rounded-xl shadow-lg py-1.5 z-20">
                            <button type="button" onclick="submitBulkAction('delete')" class="w-full text-left px-4 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 flex items-center gap-2">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                Delete Selected
                            </button>
                            <button type="button" onclick="submitBulkAction('mark_active')" class="w-full text-left px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                Mark as Active
                            </button>
                            <button type="button" onclick="submitBulkAction('mark_inactive')" class="w-full text-left px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                                Mark as Inactive
                            </button>
                        </div>
                    </div>

                    <!-- Export CSV Link -->
                    <a href="{{ route('products.export', request()->query()) }}" title="Export filtered products as CSV" class="p-2 border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 transition-colors">
                        <svg class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                    </a>

                    <!-- Add Product Button (Opens Modal) -->
                    <button type="button" onclick="openCreateModal()" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold shadow-sm shadow-blue-500/20 transition-all hover:shadow-md cursor-pointer">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Add Product</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Products Table -->
        <form id="bulkForm" action="{{ route('products.bulk') }}" method="POST">
            @csrf
            <input type="hidden" name="bulk_action" id="bulkActionInput" value="">

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/70 border-b border-slate-100 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                            <th class="py-3.5 pl-6 pr-3 w-12">
                                <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 w-4 h-4 cursor-pointer">
                            </th>
                            <th class="py-3.5 px-3">Thumbnail</th>
                            <th class="py-3.5 px-4">Product Name & SKU</th>
                            <th class="py-3.5 px-4">Category</th>
                            <th class="py-3.5 px-4">Price</th>
                            <th class="py-3.5 px-4">Inventory / Stock</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 pr-6 pl-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse ($products as $product)
                            <tr class="hover:bg-slate-50/70 transition-colors group">
                                <!-- Checkbox -->
                                <td class="py-4 pl-6 pr-3">
                                    <input type="checkbox" name="selected_ids[]" value="{{ $product->id }}" class="row-checkbox rounded border-slate-300 text-blue-600 focus:ring-blue-500 w-4 h-4 cursor-pointer">
                                </td>

                                <!-- Thumbnail -->
                                <td class="py-4 px-3">
                                    <div class="w-12 h-12 rounded-xl border border-slate-200/80 bg-slate-50 overflow-hidden flex items-center justify-center flex-shrink-0">
                                        @if ($product->image_path)
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                        @else
                                            <!-- Themed Icon Thumbnail based on category -->
                                            <div class="text-slate-400">
                                                @if ($product->category === 'Apparel')
                                                    <svg class="w-6 h-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                                @elseif ($product->category === 'Electronics')
                                                    <svg class="w-6 h-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                                @else
                                                    <svg class="w-6 h-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Product Name & SKU -->
                                <td class="py-4 px-4 max-w-xs">
                                    <div class="flex flex-col">
                                        <button type="button" onclick="openShowModal({{ $product->id }})" class="text-left font-semibold text-slate-900 hover:text-blue-600 transition-colors line-clamp-1">
                                            {{ $product->name }}
                                        </button>
                                        <span class="text-xs font-mono font-medium text-slate-400 mt-0.5">
                                            SKU: {{ $product->sku }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Category Badge -->
                                <td class="py-4 px-4 whitespace-nowrap">
                                    @php
                                        $badgeClasses = match($product->category) {
                                            'Apparel' => 'bg-blue-50 text-blue-700 border-blue-200/60',
                                            'Electronics' => 'bg-indigo-50 text-indigo-700 border-indigo-200/60',
                                            'Home & Living' => 'bg-slate-100 text-slate-700 border-slate-200/80',
                                            'Accessories' => 'bg-purple-50 text-purple-700 border-purple-200/60',
                                            default => 'bg-emerald-50 text-emerald-700 border-emerald-200/60',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold border {{ $badgeClasses }}">
                                        {{ $product->category }}
                                    </span>
                                </td>

                                <!-- Price -->
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-900 text-sm">
                                            ${{ number_format($product->price, 2) }}
                                        </span>
                                        @if ($product->sale_price)
                                            <span class="text-[11px] font-medium text-emerald-600">
                                                Sale: ${{ number_format($product->sale_price, 2) }}
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Inventory / Stock with dynamic progress indicator -->
                                <td class="py-4 px-4 whitespace-nowrap min-w-[160px]">
                                    @php
                                        $stock = $product->stock_quantity;
                                        $threshold = $product->low_stock_threshold ?? 10;
                                        $percent = min(100, max(0, round(($stock / max(50, $threshold * 2)) * 100)));
                                        
                                        if ($stock <= 0) {
                                            $stockColor = 'text-slate-400';
                                            $barColor = 'bg-slate-200';
                                        } elseif ($stock <= $threshold) {
                                            $stockColor = 'text-rose-600 font-bold';
                                            $barColor = 'bg-rose-500';
                                        } else {
                                            $stockColor = 'text-slate-700 font-medium';
                                            $barColor = 'bg-emerald-500';
                                        }
                                    @endphp
                                    <div class="space-y-1.5">
                                        <div class="flex items-center justify-between text-xs">
                                            <span class="{{ $stockColor }}">
                                                {{ $stock > 0 ? $stock . ' in stock' : '0 in stock' }}
                                            </span>
                                        </div>
                                        <div class="w-28 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full {{ $barColor }}" style="width: {{ $percent }}%"></div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Status Badge -->
                                <td class="py-4 px-4 whitespace-nowrap">
                                    @php
                                        $statusConfig = match($product->status) {
                                            'Active' => ['bg' => 'bg-emerald-50 text-emerald-700 border-emerald-200/80', 'dot' => 'bg-emerald-500'],
                                            'Draft' => ['bg' => 'bg-amber-50 text-amber-700 border-amber-200/80', 'dot' => 'bg-amber-500'],
                                            default => ['bg' => 'bg-slate-100 text-slate-600 border-slate-200', 'dot' => 'bg-slate-400'],
                                        };
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold border {{ $statusConfig['bg'] }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>
                                        <span>{{ $product->status }}</span>
                                    </span>
                                </td>

                                <!-- Row Actions -->
                                <td class="py-4 pr-6 pl-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1">
                                        <!-- View -->
                                        <button type="button" 
                                                onclick="openShowModal({{ $product->id }})" 
                                                title="View Details"
                                                class="p-1.5 text-slate-400 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>

                                        <!-- Edit -->
                                        <button type="button" 
                                                onclick="openEditModal({{ $product->id }})" 
                                                title="Edit Product"
                                                class="p-1.5 text-slate-400 hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <!-- Delete (Triggers Destructive Action Modal) -->
                                        <button type="button" 
                                                onclick='openDeleteModal({{ json_encode([
                                                    "id" => $product->id,
                                                    "name" => $product->name,
                                                    "sku" => $product->sku,
                                                    "price" => number_format($product->price, 2),
                                                    "category" => $product->category,
                                                    "stock" => $product->stock_quantity,
                                                    "image_url" => $product->image_url,
                                                    "destroy_url" => route("products.destroy", $product)
                                                ]) }})'
                                                title="Delete Product"
                                                class="p-1.5 text-slate-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <!-- Clean Empty State -->
                            <tr>
                                <td colspan="8" class="py-14 text-center">
                                    <div class="max-w-sm mx-auto flex flex-col items-center">
                                        <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 mb-4">
                                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                            </svg>
                                        </div>
                                        <h4 class="text-base font-bold text-slate-900">No products found</h4>
                                        <p class="text-xs text-slate-500 mt-1">
                                            @if(request()->hasAny(['search', 'category', 'status']))
                                                No products match your current search and filter criteria.
                                            @else
                                                Your product catalog is empty. Click below to add your first product.
                                            @endif
                                        </p>
                                        <div class="mt-4 flex gap-2">
                                            @if(request()->hasAny(['search', 'category', 'status']))
                                                <a href="{{ route('products.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-colors">
                                                    Reset All Filters
                                                </a>
                                            @endif
                                            <button type="button" onclick="openCreateModal()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl shadow-xs transition-colors">
                                                + Add New Product
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <!-- Table Footer / Server-side Pagination & Rows Per Page -->
        <div class="px-6 py-4 bg-white border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            
            <!-- Result count -->
            <div class="flex items-center gap-4 text-xs font-medium text-slate-500">
                <span>
                    Showing <span class="font-bold text-slate-800">{{ $products->firstItem() ?? 0 }}</span> 
                    to <span class="font-bold text-slate-800">{{ $products->lastItem() ?? 0 }}</span> 
                    of <span class="font-bold text-slate-800">{{ $products->total() }}</span> products
                </span>

                <!-- Rows per page selector -->
                <div class="flex items-center gap-2 border-l border-slate-200 pl-4">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Rows per page:</span>
                    <select onchange="updatePerPage(this.value)" class="text-xs font-semibold bg-slate-50 border border-slate-200 rounded-lg px-2 py-1 focus:ring-1 focus:ring-blue-500">
                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </div>
            </div>

            <!-- Pagination buttons -->
            <div>
                {{ $products->onEachSide(1)->links('vendor.pagination.tailwind-custom') }}
            </div>
        </div>
    </div>

    <!-- 3. Bottom Dashboard Widgets (Matching Mockup Reference Image 1) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Widget 1: Critical Stock Replenishment -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <h4 class="text-sm font-bold text-slate-900 tracking-tight">Critical Stock Replenishment</h4>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-200/60">
                        Action Required
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">
                    {{ count($criticalReplenishment) }} SKUs have hit safety buffers and require purchase order dispatch to primary vendors.
                </p>

                <!-- Replenishment Item Cards -->
                <div class="mt-4 space-y-3">
                    @forelse ($criticalReplenishment as $item)
                        <div class="p-3 bg-slate-50 border border-slate-200/70 rounded-xl flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-rose-100/70 text-rose-600 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-slate-900 line-clamp-1">{{ $item->name }}</span>
                                    <span class="text-[11px] text-slate-400 font-mono">
                                        {{ $item->sku }} • Lead Time: 3 days
                                    </span>
                                </div>
                            </div>
                            <button type="button" onclick="alert('Purchase Order created for {{ $item->name }} (50 units)')" class="px-3 py-1.5 bg-white border border-slate-200 hover:border-blue-500 hover:text-blue-600 text-xs font-bold text-slate-700 rounded-lg shadow-2xs transition-colors flex-shrink-0">
                                Reorder 50
                            </button>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 py-4 text-center">No low stock replenishment needed at this time.</p>
                    @endforelse
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100">
                <a href="#" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                    <span>View supplier order pipeline</span>
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </a>
            </div>
        </div>

        <!-- Widget 2: Catalog SKU Breakdown -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <h4 class="text-sm font-bold text-slate-900 tracking-tight">Catalog SKU Breakdown</h4>
                    <span class="text-xs font-mono font-bold text-slate-400">Total: {{ number_format($totalProducts) }}</span>
                </div>

                <div class="mt-4 space-y-3.5">
                    @php
                        $barColors = ['bg-blue-600', 'bg-sky-500', 'bg-slate-600', 'bg-slate-400', 'bg-purple-500'];
                    @endphp
                    @foreach ($categoryBreakdown as $index => $breakdown)
                        <div>
                            <div class="flex items-center justify-between text-xs font-semibold mb-1">
                                <span class="text-slate-700">{{ $breakdown['category'] }}</span>
                                <span class="text-slate-400 font-mono">{{ $breakdown['count'] }} SKUs ({{ $breakdown['percentage'] }}%)</span>
                            </div>
                            <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full {{ $barColors[$index % count($barColors)] }}" style="width: {{ $breakdown['percentage'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                <span>Synchronized with MySQL replica db</span>
                <span class="inline-flex items-center gap-1 font-semibold text-emerald-600">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Live
                </span>
            </div>
        </div>

        <!-- Widget 3: Store Channel Sync -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <h4 class="text-sm font-bold text-slate-900 tracking-tight">Store Channel Sync</h4>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200/60">
                        All Active
                    </span>
                </div>

                <div class="mt-4 space-y-3">
                    <!-- Shopify -->
                    <div class="p-3 bg-slate-50 border border-slate-200/70 rounded-xl flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-100/70 text-blue-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-slate-900">Shopify Flagship</span>
                                <span class="text-[11px] text-slate-400">Last ping: 2 mins ago</span>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 bg-emerald-100/80 text-emerald-700 text-[10px] font-bold rounded-lg">100% Synced</span>
                    </div>

                    <!-- Amazon -->
                    <div class="p-3 bg-slate-50 border border-slate-200/70 rounded-xl flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-amber-100/70 text-amber-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-slate-900">Amazon Marketplace</span>
                                <span class="text-[11px] text-slate-400">Last ping: 5 mins ago</span>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 bg-emerald-100/80 text-emerald-700 text-[10px] font-bold rounded-lg">100% Synced</span>
                    </div>

                    <!-- POS -->
                    <div class="p-3 bg-slate-50 border border-slate-200/70 rounded-xl flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-purple-100/70 text-purple-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-slate-900">POS Terminal Hub (Austin)</span>
                                <span class="text-[11px] text-slate-400">Last ping: Just now</span>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 bg-emerald-100/80 text-emerald-700 text-[10px] font-bold rounded-lg">Online</span>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100">
                <button type="button" onclick="triggerSyncSimulation(this)" class="w-full py-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-xs font-bold text-slate-700 rounded-xl transition-all flex items-center justify-center gap-2">
                    <svg class="w-3.5 h-3.5 text-slate-500 sync-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>Trigger Full Sync</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->

<div id="productModal" class="hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-2xl shadow-2xl border border-slate-100 overflow-hidden"
         style="display:flex; flex-direction:column; max-height:92vh;">

        <!-- Header (always visible) -->
        <div class="px-6 py-4 border-b border-slate-100 flex items-start justify-between" style="flex-shrink:0;">
            <div>
                <div class="flex items-center gap-2.5">
                    <h3 id="modalTitle" class="text-base font-bold text-slate-900">Add New Product</h3>
                </div>
                <p class="text-xs text-slate-500 mt-1">Fields marked <span class="text-rose-500">*</span> are required.</p>
            </div>
            <button type="button" onclick="closeProductModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-100 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form id="productForm" method="POST" enctype="multipart/form-data" action="{{ route('products.store') }}"
              style="display:flex; flex-direction:column; flex:1 1 auto; min-height:0;">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="id" id="productId" value="">

            <!-- Scrollable fields (ONLY this part scrolls) -->
            <div class="p-6 space-y-5" style="flex:1 1 auto; min-height:0; overflow-y:auto;">

                <div id="modalErrors" class="hidden p-3.5 bg-rose-50 border border-rose-200 rounded-xl text-xs text-rose-700"></div>

                <!-- Product Name -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Product Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="inputName" required placeholder="e.g. Wireless Noise-Cancelling Headphones"
                           class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- SKU & Category -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div style="min-width:0;">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">SKU <span class="text-rose-500">*</span></label>
                        <div style="display:flex; gap:8px;">
                            <input type="text" name="sku" id="inputSku" required placeholder="e.g. ELE-HPH-2024"
                                   class="px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm font-mono placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   style="flex:1 1 auto; min-width:0; width:100%;">
                            <button type="button" onclick="fetchGeneratedSku()"
                                    class="inline-flex items-center gap-1.5 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition-colors"
                                    style="flex-shrink:0; white-space:nowrap;">
                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                <span>Generate</span>
                            </button>
                        </div>
                        <span class="text-[11px] text-slate-400 mt-1 block">Unique ID used across warehouses.</span>
                    </div>

                    <div style="min-width:0;">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Category <span class="text-rose-500">*</span></label>
                        <select name="category" id="inputCategory" required
                                class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select Category</option>
                            <option value="Electronics">Electronics</option>
                            <option value="Apparel">Apparel</option>
                            <option value="Home & Living">Home & Living</option>
                            <option value="Accessories">Accessories</option>
                            <option value="Footwear">Footwear</option>
                        </select>
                        <span class="text-[11px] text-slate-400 mt-1 block">Used for tax rates and grouping.</span>
                    </div>
                </div>

                <!-- Prices -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div style="min-width:0;">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Regular Price ($) <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 text-sm">$</span>
                            <input type="number" step="0.01" min="0" name="price" id="inputPrice" required placeholder="199.99"
                                   class="w-full pl-8 pr-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div style="min-width:0;">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Sale Price ($) <span class="text-slate-400 font-normal">(Optional)</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 text-sm">$</span>
                            <input type="number" step="0.01" min="0" name="sale_price" id="inputSalePrice" placeholder="149.99"
                                   class="w-full pl-8 pr-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Stock -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div style="min-width:0;">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Stock Quantity <span class="text-rose-500">*</span></label>
                        <input type="number" min="0" name="stock_quantity" id="inputStock" required placeholder="150"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div style="min-width:0;">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Low Stock Alert <span class="text-slate-400 font-normal">(at or below)</span></label>
                        <input type="number" min="0" name="low_stock_threshold" id="inputThreshold" placeholder="15"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Status <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <label class="flex flex-col p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-2">
                                <input type="radio" name="status" value="Active" checked class="text-blue-600 focus:ring-blue-500 h-4 w-4">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                <span class="text-xs font-bold text-slate-900">Active</span>
                            </div>
                            <span class="text-[10px] text-slate-400 mt-1 pl-6">Visible in storefront & POS</span>
                        </label>
                        <label class="flex flex-col p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-2">
                                <input type="radio" name="status" value="Draft" class="text-blue-600 focus:ring-blue-500 h-4 w-4">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                <span class="text-xs font-bold text-slate-900">Draft</span>
                            </div>
                            <span class="text-[10px] text-slate-400 mt-1 pl-6">Hidden from customers</span>
                        </label>
                        <label class="flex flex-col p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-2">
                                <input type="radio" name="status" value="Inactive" class="text-blue-600 focus:ring-blue-500 h-4 w-4">
                                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                <span class="text-xs font-bold text-slate-900">Inactive</span>
                            </div>
                            <span class="text-[10px] text-slate-400 mt-1 pl-6">Archived SKU record</span>
                        </label>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Description</label>
                    <div class="border border-slate-300 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-blue-500">
                        <div class="bg-slate-50 px-3 py-1.5 border-b border-slate-200 flex items-center justify-between text-slate-500">
                            <div class="flex items-center gap-2 text-xs">
                                <button type="button" onclick="formatText('**', '**')" class="p-1 hover:text-slate-900 font-bold rounded">B</button>
                                <button type="button" onclick="formatText('*', '*')" class="p-1 hover:text-slate-900 italic rounded">I</button>
                                <button type="button" onclick="formatText('\n- ')" class="p-1 hover:text-slate-900 rounded">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                                </button>
                            </div>
                            <span id="charCounter" class="text-[10px] font-mono text-slate-400">0 / 2000 chars</span>
                        </div>
                        <textarea name="description" id="inputDescription" rows="3" maxlength="2000" oninput="updateCharCount(this)"
                                  placeholder="Specifications, materials and highlights..."
                                  class="w-full p-3 text-xs text-slate-800 placeholder-slate-400 border-none focus:outline-none"></textarea>
                    </div>
                </div>

                <!-- Image -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Product Image</label>
                    <div class="flex items-center gap-4">
                        <div onclick="document.getElementById('imageFileInput').click()" id="dropzoneArea"
                             class="flex-1 border-2 border-dashed border-slate-300 hover:border-blue-400 bg-slate-50 hover:bg-blue-50/30 rounded-xl p-4 text-center cursor-pointer transition-all"
                             style="min-width:0;">
                            <input type="file" name="image" id="imageFileInput" accept="image/*" class="hidden" onchange="previewSelectedImage(this)">
                            <p class="text-xs font-bold text-slate-700">Drag & drop or <span class="text-blue-600 underline">browse file</span></p>
                            <span class="text-[10px] text-slate-400">Square or 4:3 recommended (max 3MB)</span>
                        </div>
                        <div id="imagePreviewContainer" class="hidden relative w-20 h-20 rounded-xl border border-slate-200 overflow-hidden bg-slate-100" style="flex-shrink:0;">
                            <img id="imagePreviewImg" src="" alt="Thumbnail preview" class="w-full h-full object-cover">
                            <button type="button" onclick="clearSelectedImage()" class="absolute top-1 right-1 bg-slate-900/70 hover:bg-slate-900 text-white rounded-full p-1">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer (always visible) -->
            <div class="px-6 py-4 border-t border-slate-100 bg-white flex flex-wrap items-center justify-end gap-2" style="flex-shrink:0;">
                <button type="button" onclick="closeProductModal()" class="px-4 py-2 text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                    Cancel
                </button>
                <button type="button" onclick="submitAsDraft()" class="px-4 py-2 text-xs font-bold text-slate-700 hover:bg-slate-100 border border-slate-200 rounded-xl transition-colors">
                    Save as Draft
                </button>
                <button type="submit" id="modalSubmitBtn" class="px-5 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-all flex items-center gap-1.5">
                    <span id="modalSubmitText">Save & Publish Product</span>
                </button>
            </div>
        </form>
    </div>
</div>
<!-- (Exact match to Reference Images 3 & 4)    -->
<!-- ========================================== -->
<div id="deleteModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full shadow-2xl border border-slate-100 overflow-hidden animate-scale-up">
        
        <!-- Destructive Action Warning Header -->
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-2 text-rose-600">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span class="text-xs font-black tracking-wider uppercase">Destructive Action</span>
            </div>
            <button type="button" onclick="closeDeleteModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form id="deleteForm" method="POST" action="">
            @csrf
            @method('DELETE')

            <div class="p-6 space-y-5">
                <!-- Delete prompt title & warning text -->
                <div class="flex items-start gap-4">
                    <div class="w-11 h-11 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-base font-bold text-slate-900" id="deleteModalTitle">
                            Delete Product?
                        </h4>
                        <p class="text-xs text-slate-500 mt-1.5 leading-relaxed" id="deleteModalDescription">
                            Are you sure you want to delete this product? This action will permanently remove the item from your MySQL database catalog and cancel any pending store links. This action cannot be undone.
                        </p>
                    </div>
                </div>

                <!-- Product Summary Card inside Modal -->
                <div class="p-3.5 bg-slate-50 border border-slate-200/80 rounded-xl flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div id="deleteModalThumb" class="w-12 h-12 rounded-lg border border-slate-200 bg-white overflow-hidden flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <div class="flex flex-col">
                            <span id="deleteModalName" class="text-xs font-bold text-slate-900">Product Name</span>
                            <span id="deleteModalMeta" class="text-[11px] text-slate-500">Category: Electronics • Current Stock: 19 units</span>
                            <span id="deleteModalDbId" class="text-[10px] font-mono text-slate-400 mt-0.5">Database ID: #88920-MYSQL</span>
                        </div>
                    </div>
                    <span id="deleteModalPrice" class="text-sm font-bold text-slate-900 flex-shrink-0">$39.99</span>
                </div>

                <!-- Irreversible Acknowledgement Checkbox -->
                <div class="p-3 bg-slate-50/70 border border-slate-200 rounded-xl">
                    <label class="flex items-start gap-2.5 cursor-pointer">
                        <input type="checkbox" id="deleteConfirmCheckbox" onchange="toggleDeleteButton(this.checked)" class="mt-0.5 rounded border-slate-300 text-rose-600 focus:ring-rose-500 w-4 h-4 cursor-pointer">
                        <span class="text-xs text-slate-700 leading-snug">
                            <strong class="font-bold">I understand that this action is irreversible.</strong> Catalog sync across Amazon, Shopify, and in-store POS will be stopped immediately.
                        </span>
                    </label>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 bg-slate-50/60 border-t border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-1.5 text-xs text-slate-400">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <span>Requires Merchandiser Admin Role</span>
                </div>

                <div class="flex items-center gap-2">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-xs font-bold text-slate-600 hover:text-slate-800 bg-white border border-slate-200 rounded-xl transition-colors">
                        Cancel
                    </button>
                    <button type="submit" id="confirmDeleteBtn" disabled class="px-4 py-2 text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-xs transition-all flex items-center gap-1.5 opacity-40 cursor-not-allowed">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>Yes, Delete Product</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL 3: QUICK VIEW PRODUCT DETAILS MODAL  -->
<!-- ========================================== -->
<div id="showModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full shadow-2xl border border-slate-100 overflow-hidden animate-scale-up">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h4 class="text-sm font-bold text-slate-900">Product Specifications</h4>
            <button type="button" onclick="closeShowModal()" class="text-slate-400 hover:text-slate-600 p-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <div class="p-6 space-y-4" id="showModalBody">
            <!-- Dynamic content loaded via AJAX -->
        </div>
        <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-100 flex justify-end">
            <button type="button" onclick="closeShowModal()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-xs font-bold text-slate-700 rounded-xl transition-colors">
                Close
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // --- Bulk Action Menu & Checkbox handling ---
    function toggleBulkMenu() {
        const menu = document.getElementById('bulkMenu');
        menu.classList.toggle('hidden');
    }

    document.addEventListener('click', function(e) {
        const btn = document.getElementById('bulkActionsBtn');
        const menu = document.getElementById('bulkMenu');
        if (btn && menu && !btn.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.add('hidden');
        }
    });

    function toggleSelectAll(masterCheckbox) {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(cb => cb.checked = masterCheckbox.checked);
    }

    function submitBulkAction(action) {
        const checked = document.querySelectorAll('.row-checkbox:checked');
        if (checked.length === 0) {
            alert('Please select at least one product using the checkboxes.');
            return;
        }

        if (action === 'delete') {
            if (!confirm(`Are you sure you want to permanently delete the ${checked.length} selected product(s)?`)) {
                return;
            }
        }

        document.getElementById('bulkActionInput').value = action;
        document.getElementById('bulkForm').submit();
    }

    // --- Per Page Handler ---
    function updatePerPage(perPage) {
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', perPage);
        url.searchParams.set('page', '1');
        window.location.href = url.toString();
    }

    // --- Add / Edit Product Modal Management ---
    function openCreateModal() {
        document.getElementById('productForm').reset();
        document.getElementById('productForm').action = "{{ route('products.store') }}";
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('productId').value = '';
        document.getElementById('modalTitle').innerText = 'Add New Product';
        document.getElementById('modalSubmitText').innerText = 'Save & Publish Product';
        document.getElementById('modalErrors').classList.add('hidden');
        document.getElementById('modalErrors').innerHTML = '';
        document.getElementById('imagePreviewContainer').classList.add('hidden');
        document.getElementById('charCounter').innerText = '0 / 2000 chars';

        // Auto-generate SKU on open if empty
        fetchGeneratedSku();

        document.getElementById('productModal').classList.remove('hidden');
    }

    function openEditModal(productId) {
        document.getElementById('productForm').reset();
        document.getElementById('modalTitle').innerText = 'Edit Product';
        document.getElementById('modalSubmitText').innerText = 'Save Changes';
        document.getElementById('modalErrors').classList.add('hidden');

        fetch(`/products/${productId}/edit`, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if (!data.success) return;
            const p = data.product;

            document.getElementById('productForm').action = `/products/${p.id}`;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('productId').value = p.id;
            document.getElementById('inputName').value = p.name;
            document.getElementById('inputSku').value = p.sku;
            document.getElementById('inputCategory').value = p.category;
            document.getElementById('inputPrice').value = p.price;
            document.getElementById('inputSalePrice').value = p.sale_price || '';
            document.getElementById('inputStock').value = p.stock_quantity;
            document.getElementById('inputThreshold').value = p.low_stock_threshold || 10;
            document.getElementById('inputDescription').value = p.description || '';
            updateCharCount(document.getElementById('inputDescription'));

            // Status radio
            const statusRadios = document.querySelectorAll('input[name="status"]');
            statusRadios.forEach(radio => {
                radio.checked = (radio.value === p.status);
            });

            // Image preview
            if (p.image_path) {
                document.getElementById('imagePreviewImg').src = data.image_url;
                document.getElementById('imagePreviewContainer').classList.remove('hidden');
            } else {
                document.getElementById('imagePreviewContainer').classList.add('hidden');
            }

            document.getElementById('productModal').classList.remove('hidden');
        })
        .catch(err => {
            alert('Failed to load product for editing: ' + err);
        });
    }

    function closeProductModal() {
        document.getElementById('productModal').classList.add('hidden');
    }

    function submitAsDraft() {
        const draftRadio = document.querySelector('input[name="status"][value="Draft"]');
        if (draftRadio) draftRadio.checked = true;
        document.getElementById('productForm').submit();
    }

    // --- SKU Generator via AJAX ---
    function fetchGeneratedSku() {
        const category = document.getElementById('inputCategory').value || 'PRD';
        fetch("{{ route('products.generate-sku') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ category: category })
        })
        .then(res => res.json())
        .then(data => {
            if (data.sku) {
                document.getElementById('inputSku').value = data.sku;
            }
        });
    }

    // --- Image Preview Handler ---
    function previewSelectedImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreviewImg').src = e.target.result;
                document.getElementById('imagePreviewContainer').classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function clearSelectedImage() {
        document.getElementById('imageFileInput').value = '';
        document.getElementById('imagePreviewContainer').classList.add('hidden');
    }

    // --- Text Formatting & Counter ---
    function updateCharCount(textarea) {
        document.getElementById('charCounter').innerText = `${textarea.value.length} / 2000 chars`;
    }

    function formatText(prefix, suffix = '') {
        const textarea = document.getElementById('inputDescription');
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const text = textarea.value;
        const selected = text.substring(start, end);
        textarea.value = text.substring(0, start) + prefix + selected + suffix + text.substring(end);
        textarea.focus();
        textarea.setSelectionRange(start + prefix.length, end + prefix.length);
        updateCharCount(textarea);
    }

    // --- Destructive Action Delete Modal ---
    function openDeleteModal(data) {
        document.getElementById('deleteForm').action = data.destroy_url;
        document.getElementById('deleteModalTitle').innerText = `Delete '${data.name}'?`;
        document.getElementById('deleteModalDescription').innerText = `Are you sure you want to delete this product? SKU: ${data.sku}. This action will permanently remove the item from your MySQL database catalog and cancel any pending store links. This action cannot be undone.`;
        document.getElementById('deleteModalName').innerText = data.name;
        document.getElementById('deleteModalPrice').innerText = `$${data.price}`;
        document.getElementById('deleteModalMeta').innerText = `Category: ${data.category} • Current Stock: ${data.stock} units`;
        document.getElementById('deleteModalDbId').innerText = `Database ID: #${data.id}-MYSQL`;

        // Reset confirmation checkbox & disable delete button
        const confirmCheckbox = document.getElementById('deleteConfirmCheckbox');
        confirmCheckbox.checked = false;
        toggleDeleteButton(false);

        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    function toggleDeleteButton(isChecked) {
        const btn = document.getElementById('confirmDeleteBtn');
        if (isChecked) {
            btn.disabled = false;
            btn.classList.remove('opacity-40', 'cursor-not-allowed');
            btn.classList.add('hover:bg-rose-700', 'cursor-pointer');
        } else {
            btn.disabled = true;
            btn.classList.add('opacity-40', 'cursor-not-allowed');
            btn.classList.remove('hover:bg-rose-700', 'cursor-pointer');
        }
    }

    // --- Quick View Modal ---
    function openShowModal(productId) {
        fetch(`/products/${productId}`, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if (!data.success) return;
            const p = data.product;
            const html = `
                <div class="flex items-start gap-4">
                    <div class="w-20 h-20 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center overflow-hidden flex-shrink-0">
                        ${data.image_url ? `<img src="${data.image_url}" class="w-full h-full object-cover">` : `<svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>`}
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">${p.name}</h3>
                        <p class="text-xs font-mono text-slate-400 mt-0.5">SKU: ${p.sku}</p>
                        <div class="mt-2 flex items-center gap-2">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">${p.category}</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">${p.status}</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 pt-3 border-t border-slate-100 text-xs">
                    <div class="p-2.5 bg-slate-50 rounded-xl">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Regular Price</span>
                        <span class="text-sm font-bold text-slate-900">$${parseFloat(p.price).toFixed(2)}</span>
                    </div>
                    <div class="p-2.5 bg-slate-50 rounded-xl">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Current Stock</span>
                        <span class="text-sm font-bold ${p.stock_quantity <= (p.low_stock_threshold || 10) ? 'text-rose-600' : 'text-slate-900'}">${p.stock_quantity} units</span>
                    </div>
                </div>

                <div class="pt-2">
                    <span class="text-[10px] font-bold uppercase text-slate-400 block mb-1">Description</span>
                    <p class="text-xs text-slate-600 leading-relaxed bg-slate-50 p-3 rounded-xl border border-slate-200/60">
                        ${p.description ? p.description.replace(/\n/g, '<br>') : 'No detailed description provided.'}
                    </p>
                </div>
            `;
            document.getElementById('showModalBody').innerHTML = html;
            document.getElementById('showModal').classList.remove('hidden');
        });
    }

    function closeShowModal() {
        document.getElementById('showModal').classList.add('hidden');
    }

    // --- Trigger Sync Simulation ---
    function triggerSyncSimulation(btn) {
        const icon = btn.querySelector('.sync-icon');
        icon.classList.add('animate-spin');
        btn.querySelector('span').innerText = 'Syncing Channels...';
        setTimeout(() => {
            icon.classList.remove('animate-spin');
            btn.querySelector('span').innerText = 'Trigger Full Sync';
            alert('All channels (Shopify, Amazon, POS Terminal) successfully synchronized with MySQL catalog!');
        }, 1200);
    }
</script>
@endpush
