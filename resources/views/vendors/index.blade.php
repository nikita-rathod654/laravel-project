@extends('layouts.app')

@section('title', 'Vendor Management')

@section('breadcrumbs')
    <span class="text-slate-400 font-medium">Enterprise</span>
    <span class="text-slate-300">/</span>
    <h1 class="text-slate-900 font-bold text-base tracking-tight">Suppliers & Vendor Registry</h1>
@endsection

@section('content')
<div class="space-y-6">

    <!-- KPI Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Suppliers</span>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">{{ $totalVendors }}</h3>
            <span class="text-xs text-slate-500 mt-2 block">Wholesale & manufacturing partners</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Active Suppliers</span>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-emerald-600 mt-1">{{ $activeVendors }}</h3>
            <span class="text-xs text-emerald-600 font-semibold mt-2 block">Authorized for purchase orders</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Review / On-Hold</span>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-amber-600 mt-1">{{ $onHoldVendors }}</h3>
            <span class="text-xs text-amber-600 font-semibold mt-2 block">Pending quality / compliance review</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Category Coverage</span>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-blue-600 mt-1">{{ $categories->count() }}</h3>
            <span class="text-xs text-blue-600 font-semibold mt-2 block">Apparel, Tech, Home & more</span>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        
        <!-- Toolbar -->
        <div class="p-5 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <form action="{{ route('vendors.index') }}" method="GET" class="flex flex-wrap items-center gap-3 flex-1">
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
                           placeholder="Search company, contact, email..." 
                           class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                </div>

                <!-- Category Filter -->
                <select name="category" onchange="this.form.submit()" class="py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="All" {{ request('category') === 'All' ? 'selected' : '' }}>All Categories</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>

                <!-- Status Filter -->
                <select name="status" onchange="this.form.submit()" class="py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="All" {{ request('status') === 'All' ? 'selected' : '' }}>All Statuses</option>
                    <option value="Active" {{ request('status') === 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="On-Hold" {{ request('status') === 'On-Hold' ? 'selected' : '' }}>On-Hold</option>
                    <option value="Inactive" {{ request('status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>

                @if (request()->hasAny(['search', 'category', 'status']))
                    <a href="{{ route('vendors.index') }}" class="text-xs text-rose-600 hover:text-rose-700 font-semibold px-2 py-1">Reset</a>
                @endif
            </form>

            <button type="button" 
                    onclick="openCreateVendorModal()" 
                    class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs sm:text-sm rounded-xl shadow-xs transition-colors flex items-center justify-center gap-2 shrink-0">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span>Add New Vendor</span>
            </button>
        </div>

        <!-- Table View -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/50 text-slate-400 uppercase text-[10px] tracking-wider font-bold">
                        <th class="py-3 px-5">Vendor Company</th>
                        <th class="py-3 px-5">Contact Person</th>
                        <th class="py-3 px-5">Category</th>
                        <th class="py-3 px-5">Payment Terms</th>
                        <th class="py-3 px-5">Rating</th>
                        <th class="py-3 px-5">Status</th>
                        <th class="py-3 px-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($vendors as $vendor)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="py-4 px-5">
                                <div class="font-bold text-slate-900">{{ $vendor->company_name }}</div>
                                <div class="text-xs text-slate-400">{{ $vendor->address ?? 'Location not provided' }}</div>
                            </td>
                            <td class="py-4 px-5">
                                <div class="font-medium text-slate-900">{{ $vendor->name }}</div>
                                <div class="text-xs text-slate-400">{{ $vendor->email }} • {{ $vendor->phone }}</div>
                            </td>
                            <td class="py-4 px-5">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                    {{ $vendor->category }}
                                </span>
                            </td>
                            <td class="py-4 px-5 font-medium text-slate-800">
                                {{ $vendor->payment_terms }}
                            </td>
                            <td class="py-4 px-5">
                                <div class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 border border-amber-200/60 font-bold text-xs">
                                    <span>★</span>
                                    <span>{{ number_format($vendor->rating, 1) }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-5">
                                @if ($vendor->status === 'Active')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">Active</span>
                                @elseif ($vendor->status === 'On-Hold')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800">On-Hold</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-100 text-rose-800">Inactive</span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button" 
                                            onclick='openEditVendorModal(@json($vendor))'
                                            class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit Vendor">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('vendors.destroy', $vendor) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove {{ $vendor->company_name }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Delete Vendor">
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
                            <td colspan="7" class="py-10 text-center text-slate-400">
                                No vendors found matching your search.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-slate-100 flex items-center justify-between">
            <div class="text-xs text-slate-500">
                Showing {{ $vendors->firstItem() ?? 0 }} to {{ $vendors->lastItem() ?? 0 }} of {{ $vendors->total() }} suppliers
            </div>
            <div>
                {{ $vendors->links() }}
            </div>
        </div>
    </div>

</div>

<!-- Create / Edit Vendor Modal -->
<div id="vendorModal" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl border border-slate-100 relative animate-fade-in">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <h3 id="vendorModalTitle" class="text-base font-bold text-slate-900">Add New Supplier Vendor</h3>
            <button type="button" onclick="closeVendorModal()" class="text-slate-400 hover:text-slate-600">
                &times;
            </button>
        </div>

        <form id="vendorForm" method="POST" action="{{ route('vendors.store') }}" class="space-y-4 pt-4">
            @csrf
            <div id="vendorMethodSpoof"></div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Company Name *</label>
                    <input type="text" name="company_name" id="vendorCompany" required placeholder="Apex Tech Inc" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:bg-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Representative Name *</label>
                    <input type="text" name="name" id="vendorName" required placeholder="Johnathan Doe" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:bg-white focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Email Address *</label>
                    <input type="email" name="email" id="vendorEmail" required placeholder="orders@supplier.com" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:bg-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Phone Number</label>
                    <input type="text" name="phone" id="vendorPhone" placeholder="+1 (555) 019-2831" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:bg-white focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Primary Category *</label>
                    <input type="text" name="category" id="vendorCategory" required placeholder="Electronics, Apparel, etc." class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:bg-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Payment Terms *</label>
                    <select name="payment_terms" id="vendorTerms" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm">
                        <option value="Net 30">Net 30</option>
                        <option value="Net 15">Net 15</option>
                        <option value="COD">Cash On Delivery (COD)</option>
                        <option value="Prepaid">Prepaid</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status *</label>
                    <select name="status" id="vendorStatus" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm">
                        <option value="Active">Active</option>
                        <option value="On-Hold">On-Hold</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Rating (1.0 to 5.0)</label>
                    <input type="number" step="0.1" min="1" max="5" name="rating" id="vendorRating" value="4.5" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:bg-white focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Headquarters / Warehouse Address</label>
                <input type="text" name="address" id="vendorAddress" placeholder="100 Technology Dr, Austin, TX" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:bg-white focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <button type="button" onclick="closeVendorModal()" class="px-4 py-2 border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs sm:text-sm font-semibold rounded-xl">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-bold rounded-xl shadow-xs">Save Vendor</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openCreateVendorModal() {
        document.getElementById('vendorModalTitle').innerText = 'Add New Supplier Vendor';
        document.getElementById('vendorForm').action = "{{ route('vendors.store') }}";
        document.getElementById('vendorMethodSpoof').innerHTML = '';
        document.getElementById('vendorCompany').value = '';
        document.getElementById('vendorName').value = '';
        document.getElementById('vendorEmail').value = '';
        document.getElementById('vendorPhone').value = '';
        document.getElementById('vendorCategory').value = 'General';
        document.getElementById('vendorTerms').value = 'Net 30';
        document.getElementById('vendorStatus').value = 'Active';
        document.getElementById('vendorRating').value = '4.5';
        document.getElementById('vendorAddress').value = '';
        document.getElementById('vendorModal').classList.remove('hidden');
    }

    function openEditVendorModal(v) {
        document.getElementById('vendorModalTitle').innerText = `Edit '${v.company_name}'`;
        document.getElementById('vendorForm').action = `/vendors/${v.id}`;
        document.getElementById('vendorMethodSpoof').innerHTML = '@method("PUT")';
        document.getElementById('vendorCompany').value = v.company_name;
        document.getElementById('vendorName').value = v.name;
        document.getElementById('vendorEmail').value = v.email;
        document.getElementById('vendorPhone').value = v.phone || '';
        document.getElementById('vendorCategory').value = v.category;
        document.getElementById('vendorTerms').value = v.payment_terms;
        document.getElementById('vendorStatus').value = v.status;
        document.getElementById('vendorRating').value = v.rating || '4.5';
        document.getElementById('vendorAddress').value = v.address || '';
        document.getElementById('vendorModal').classList.remove('hidden');
    }

    function closeVendorModal() {
        document.getElementById('vendorModal').classList.add('hidden');
    }
</script>
@endpush
@endsection
