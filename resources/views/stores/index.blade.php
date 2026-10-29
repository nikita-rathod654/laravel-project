@extends('layouts.app')

@section('title', 'Store Management')

@section('breadcrumbs')
    <span class="text-slate-400 font-medium">Enterprise</span>
    <span class="text-slate-300">/</span>
    <h1 class="text-slate-900 font-bold text-base tracking-tight">Store & Outlet Management</h1>
@endsection

@section('content')
<div class="space-y-6">

    <!-- KPI Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Stores</span>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">{{ $totalStores }}</h3>
            <span class="text-xs text-slate-500 mt-2 block">Physical and regional branches</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Operational</span>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-emerald-600 mt-1">{{ $activeStores }}</h3>
            <span class="text-xs text-emerald-600 font-semibold mt-2 block">Active and accepting orders</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Maintenance</span>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-amber-600 mt-1">{{ $maintenanceStores }}</h3>
            <span class="text-xs text-amber-600 font-semibold mt-2 block">Temporary remodel / inspection</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Cities Covered</span>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-blue-600 mt-1">{{ $citiesCount }}</h3>
            <span class="text-xs text-blue-600 font-semibold mt-2 block">Metropolitan areas</span>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        
        <!-- Action Toolbar -->
        <div class="p-5 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <!-- Filter & Search Form -->
            <form action="{{ route('stores.index') }}" method="GET" class="flex flex-wrap items-center gap-3 flex-1">
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
                           placeholder="Search store, code or city..." 
                           class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                </div>

                <!-- Status Filter -->
                <select name="status" onchange="this.form.submit()" class="py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="All" {{ request('status') === 'All' ? 'selected' : '' }}>All Statuses</option>
                    <option value="Active" {{ request('status') === 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Maintenance" {{ request('status') === 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="Closed" {{ request('status') === 'Closed' ? 'selected' : '' }}>Closed</option>
                </select>

                <!-- Type Filter -->
                <select name="type" onchange="this.form.submit()" class="py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="All" {{ request('type') === 'All' ? 'selected' : '' }}>All Types</option>
                    <option value="Flagship Store" {{ request('type') === 'Flagship Store' ? 'selected' : '' }}>Flagship Store</option>
                    <option value="Retail Outlet" {{ request('type') === 'Retail Outlet' ? 'selected' : '' }}>Retail Outlet</option>
                    <option value="Fulfillment Center" {{ request('type') === 'Fulfillment Center' ? 'selected' : '' }}>Fulfillment Center</option>
                    <option value="Express Kiosk" {{ request('type') === 'Express Kiosk' ? 'selected' : '' }}>Express Kiosk</option>
                </select>

                @if (request()->hasAny(['search', 'status', 'type']))
                    <a href="{{ route('stores.index') }}" class="text-xs text-rose-600 hover:text-rose-700 font-semibold px-2 py-1">Reset</a>
                @endif
            </form>

            <!-- Add Store Button -->
            <button type="button" 
                    onclick="openCreateStoreModal()" 
                    class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs sm:text-sm rounded-xl shadow-xs transition-colors flex items-center justify-center gap-2 shrink-0">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span>Add New Store</span>
            </button>
        </div>

        <!-- Table View -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/50 text-slate-400 uppercase text-[10px] tracking-wider font-bold">
                        <th class="py-3 px-5">Code</th>
                        <th class="py-3 px-5">Store Name</th>
                        <th class="py-3 px-5">Type</th>
                        <th class="py-3 px-5">Location</th>
                        <th class="py-3 px-5">Manager & Contact</th>
                        <th class="py-3 px-5">Status</th>
                        <th class="py-3 px-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($stores as $store)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="py-4 px-5 font-mono font-bold text-slate-900">
                                {{ $store->code }}
                            </td>
                            <td class="py-4 px-5">
                                <span class="font-bold text-slate-900">{{ $store->name }}</span>
                            </td>
                            <td class="py-4 px-5">
                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                    {{ $store->type }}
                                </span>
                            </td>
                            <td class="py-4 px-5">
                                <div class="text-slate-900 font-medium">{{ $store->address }}</div>
                                <div class="text-xs text-slate-400">{{ $store->city }}</div>
                            </td>
                            <td class="py-4 px-5">
                                <div class="font-medium text-slate-900">{{ $store->manager_name ?? 'Unassigned' }}</div>
                                <div class="text-xs text-slate-400">{{ $store->phone ?? 'N/A' }}</div>
                            </td>
                            <td class="py-4 px-5">
                                @if ($store->status === 'Active')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">Active</span>
                                @elseif ($store->status === 'Maintenance')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800">Maintenance</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-100 text-rose-800">Closed</span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button" 
                                            onclick='openEditStoreModal(@json($store))'
                                            class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit Store">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('stores.destroy', $store) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove {{ $store->name }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Delete Store">
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
                                No stores found matching your query.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-slate-100 flex items-center justify-between">
            <div class="text-xs text-slate-500">
                Showing {{ $stores->firstItem() ?? 0 }} to {{ $stores->lastItem() ?? 0 }} of {{ $stores->total() }} stores
            </div>
            <div>
                {{ $stores->links() }}
            </div>
        </div>
    </div>

</div>

<!-- Create / Edit Store Modal -->
<div id="storeModal" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl border border-slate-100 relative animate-fade-in">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <h3 id="storeModalTitle" class="text-base font-bold text-slate-900">Add New Store Location</h3>
            <button type="button" onclick="closeStoreModal()" class="text-slate-400 hover:text-slate-600">
                &times;
            </button>
        </div>

        <form id="storeForm" method="POST" action="{{ route('stores.store') }}" class="space-y-4 pt-4">
            @csrf
            <div id="storeMethodSpoof"></div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Store Name *</label>
                    <input type="text" name="name" id="storeName" required placeholder="Downtown Flagship" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:bg-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Store Code *</label>
                    <input type="text" name="code" id="storeCode" required placeholder="STR-NYC-01" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm font-mono focus:bg-white focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Store Type *</label>
                    <select name="type" id="storeType" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm">
                        <option value="Flagship Store">Flagship Store</option>
                        <option value="Retail Outlet">Retail Outlet</option>
                        <option value="Fulfillment Center">Fulfillment Center</option>
                        <option value="Express Kiosk">Express Kiosk</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status *</label>
                    <select name="status" id="storeStatus" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm">
                        <option value="Active">Active</option>
                        <option value="Maintenance">Maintenance</option>
                        <option value="Closed">Closed</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Physical Address *</label>
                <input type="text" name="address" id="storeAddress" required placeholder="742 Broadway Ave, Suite 10" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:bg-white focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">City / Region *</label>
                    <input type="text" name="city" id="storeCity" required placeholder="New York, NY" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:bg-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Phone Number</label>
                    <input type="text" name="phone" id="storePhone" placeholder="+1 (212) 555-0198" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:bg-white focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Store Manager Name</label>
                <input type="text" name="manager_name" id="storeManager" placeholder="Marcus Vance" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:bg-white focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <button type="button" onclick="closeStoreModal()" class="px-4 py-2 border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs sm:text-sm font-semibold rounded-xl">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-bold rounded-xl shadow-xs">Save Store</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openCreateStoreModal() {
        document.getElementById('storeModalTitle').innerText = 'Add New Store Location';
        document.getElementById('storeForm').action = "{{ route('stores.store') }}";
        document.getElementById('storeMethodSpoof').innerHTML = '';
        document.getElementById('storeName').value = '';
        document.getElementById('storeCode').value = '';
        document.getElementById('storeType').value = 'Retail Outlet';
        document.getElementById('storeStatus').value = 'Active';
        document.getElementById('storeAddress').value = '';
        document.getElementById('storeCity').value = '';
        document.getElementById('storePhone').value = '';
        document.getElementById('storeManager').value = '';
        document.getElementById('storeModal').classList.remove('hidden');
    }

    function openEditStoreModal(store) {
        document.getElementById('storeModalTitle').innerText = `Edit '${store.name}'`;
        document.getElementById('storeForm').action = `/stores/${store.id}`;
        document.getElementById('storeMethodSpoof').innerHTML = '@method("PUT")';
        document.getElementById('storeName').value = store.name;
        document.getElementById('storeCode').value = store.code;
        document.getElementById('storeType').value = store.type;
        document.getElementById('storeStatus').value = store.status;
        document.getElementById('storeAddress').value = store.address;
        document.getElementById('storeCity').value = store.city;
        document.getElementById('storePhone').value = store.phone || '';
        document.getElementById('storeManager').value = store.manager_name || '';
        document.getElementById('storeModal').classList.remove('hidden');
    }

    function closeStoreModal() {
        document.getElementById('storeModal').classList.add('hidden');
    }
</script>
@endpush
@endsection
