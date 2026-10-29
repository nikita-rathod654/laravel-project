@extends('layouts.app')

@section('title', 'Orders Management')

@section('breadcrumbs')
    <span class="text-slate-400 font-medium">Enterprise</span>
    <span class="text-slate-300">/</span>
    <h1 class="text-slate-900 font-bold text-base tracking-tight">Order Fulfillment & Records</h1>
@endsection

@section('content')
<div class="space-y-6">

    <!-- KPI Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Orders</span>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">{{ number_format($totalOrders) }}</h3>
            <span class="text-xs text-slate-500 mt-2 block">All recorded transactions</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Gross Settled Sales</span>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-emerald-600 mt-1">${{ number_format($totalSales, 2) }}</h3>
            <span class="text-xs text-emerald-600 font-semibold mt-2 block">Paid volume across all channels</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Processing</span>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-blue-600 mt-1">{{ number_format($processingOrders) }}</h3>
            <span class="text-xs text-blue-600 font-semibold mt-2 block">Warehouse packaging & dispatch</span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pending Attention</span>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-amber-600 mt-1">{{ number_format($pendingOrders) }}</h3>
            <span class="text-xs text-amber-600 font-semibold mt-2 block">Awaiting payment or verification</span>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        
        <!-- Filters Toolbar -->
        <div class="p-5 border-b border-slate-100 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <form action="{{ route('orders.index') }}" method="GET" class="flex flex-wrap items-center gap-3 flex-1">
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
                           placeholder="Search order #, customer, email..." 
                           class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                </div>

                <!-- Order Status -->
                <select name="status" onchange="this.form.submit()" class="py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="All" {{ request('status') === 'All' ? 'selected' : '' }}>All Order Statuses</option>
                    <option value="Completed" {{ request('status') === 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="Processing" {{ request('status') === 'Processing' ? 'selected' : '' }}>Processing</option>
                    <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Cancelled" {{ request('status') === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>

                <!-- Source Channel -->
                <select name="source" onchange="this.form.submit()" class="py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="All" {{ request('source') === 'All' ? 'selected' : '' }}>All Channels</option>
                    <option value="Online" {{ request('source') === 'Online' ? 'selected' : '' }}>Online Store</option>
                    <option value="In-Store / POS" {{ request('source') === 'In-Store / POS' ? 'selected' : '' }}>In-Store / POS</option>
                    <option value="Marketplace" {{ request('source') === 'Marketplace' ? 'selected' : '' }}>Marketplace</option>
                </select>

                <!-- Payment Status -->
                <select name="payment_status" onchange="this.form.submit()" class="py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="All" {{ request('payment_status') === 'All' ? 'selected' : '' }}>All Payments</option>
                    <option value="Paid" {{ request('payment_status') === 'Paid' ? 'selected' : '' }}>Paid</option>
                    <option value="Pending" {{ request('payment_status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Refunded" {{ request('payment_status') === 'Refunded' ? 'selected' : '' }}>Refunded</option>
                </select>

                @if (request()->hasAny(['search', 'status', 'source', 'payment_status']))
                    <a href="{{ route('orders.index') }}" class="text-xs text-rose-600 hover:text-rose-700 font-semibold px-2 py-1">Reset</a>
                @endif
            </form>

            <a href="{{ route('pos.index') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs sm:text-sm rounded-xl shadow-xs transition-colors flex items-center justify-center gap-2 shrink-0">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span>New POS Sale</span>
            </a>
        </div>

        <!-- Table View -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/50 text-slate-400 uppercase text-[10px] tracking-wider font-bold">
                        <th class="py-3 px-5">Order #</th>
                        <th class="py-3 px-5">Customer</th>
                        <th class="py-3 px-5">Channel</th>
                        <th class="py-3 px-5">Payment</th>
                        <th class="py-3 px-5">Amount</th>
                        <th class="py-3 px-5">Status</th>
                        <th class="py-3 px-5">Date</th>
                        <th class="py-3 px-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($orders as $order)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="py-4 px-5 font-mono font-bold text-slate-900">
                                {{ $order->order_number }}
                            </td>
                            <td class="py-4 px-5">
                                <div class="font-bold text-slate-900">{{ $order->customer_name }}</div>
                                <div class="text-xs text-slate-400">{{ $order->customer_email ?? 'No email' }}</div>
                            </td>
                            <td class="py-4 px-5">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $order->source === 'In-Store / POS' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-blue-50 text-blue-700 border border-blue-100' }}">
                                    {{ $order->source }}
                                </span>
                            </td>
                            <td class="py-4 px-5">
                                <div class="font-medium text-slate-900">{{ $order->payment_method }}</div>
                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold {{ $order->payment_status === 'Paid' ? 'bg-emerald-100 text-emerald-800' : ($order->payment_status === 'Pending' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800') }}">
                                    {{ $order->payment_status }}
                                </span>
                            </td>
                            <td class="py-4 px-5 font-bold text-slate-900">
                                ${{ number_format($order->total_amount, 2) }}
                                <div class="text-[10px] text-slate-400 font-normal">{{ $order->items->count() }} items</div>
                            </td>
                            <td class="py-4 px-5">
                                @if ($order->order_status === 'Completed')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">Completed</span>
                                @elseif ($order->order_status === 'Processing')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-blue-100 text-blue-800">Processing</span>
                                @elseif ($order->order_status === 'Pending')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800">Pending</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-100 text-rose-800">Cancelled</span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-xs text-slate-500 whitespace-nowrap">
                                {{ $order->created_at->format('M d, Y') }}
                                <div class="text-[10px] text-slate-400">{{ $order->created_at->format('h:i A') }}</div>
                            </td>
                            <td class="py-4 px-5 text-right whitespace-nowrap">
                                <button type="button" 
                                        onclick='openOrderDetailsModal(@json($order))'
                                        class="px-3 py-1.5 bg-slate-100 hover:bg-blue-50 hover:text-blue-600 font-semibold rounded-lg text-xs transition-colors">
                                    View Details
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-10 text-center text-slate-400">
                                No customer orders found matching your filter criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-slate-100 flex items-center justify-between">
            <div class="text-xs text-slate-500">
                Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} orders
            </div>
            <div>
                {{ $orders->links() }}
            </div>
        </div>
    </div>

</div>

<!-- Order Details Modal -->
<div id="orderDetailsModal" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl max-w-2xl w-full p-6 shadow-xl border border-slate-100 relative animate-fade-in max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div>
                <h3 id="modalOrderNum" class="text-lg font-bold text-slate-900 font-mono">ORD-2026-0000</h3>
                <p id="modalOrderDate" class="text-xs text-slate-500 mt-0.5">Order placed on ...</p>
            </div>
            <button type="button" onclick="closeOrderModal()" class="text-slate-400 hover:text-slate-600 text-lg">
                &times;
            </button>
        </div>

        <!-- Customer & Payment Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 py-4 text-xs">
            <div class="p-3 bg-slate-50 rounded-xl">
                <span class="text-slate-400 uppercase font-bold text-[10px] block">Customer</span>
                <span id="modalCustomerName" class="font-bold text-slate-900 block mt-0.5">-</span>
                <span id="modalCustomerEmail" class="text-slate-500 block truncate">-</span>
            </div>
            <div class="p-3 bg-slate-50 rounded-xl">
                <span class="text-slate-400 uppercase font-bold text-[10px] block">Sales Channel</span>
                <span id="modalOrderSource" class="font-bold text-slate-900 block mt-0.5">-</span>
                <span id="modalPaymentMethod" class="text-slate-500 block">-</span>
            </div>
            <div class="p-3 bg-slate-50 rounded-xl col-span-2 sm:col-span-1">
                <span class="text-slate-400 uppercase font-bold text-[10px] block">Order Status</span>
                <span id="modalOrderStatusBadge" class="inline-block mt-1 font-bold text-xs">-</span>
            </div>
        </div>

        <!-- Line Items Table -->
        <div class="border border-slate-100 rounded-xl overflow-hidden mb-4">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-100 text-slate-400 uppercase text-[10px]">
                    <tr>
                        <th class="py-2.5 px-3">Item Description</th>
                        <th class="py-2.5 px-3">Price</th>
                        <th class="py-2.5 px-3">Qty</th>
                        <th class="py-2.5 px-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody id="modalLineItems" class="divide-y divide-slate-100 text-slate-700">
                    <!-- Populated dynamically via JS -->
                </tbody>
            </table>
        </div>

        <!-- Financial Summary -->
        <div class="space-y-1.5 text-xs text-right pr-2 pb-4 border-b border-slate-100">
            <div class="text-slate-500">Subtotal: <span id="modalSubtotal" class="font-semibold text-slate-800">$0.00</span></div>
            <div class="text-slate-500">Sales Tax (8%): <span id="modalTax" class="font-semibold text-slate-800">$0.00</span></div>
            <div class="text-slate-500">Discount: <span id="modalDiscount" class="font-semibold text-emerald-600">-$0.00</span></div>
            <div class="text-sm font-extrabold text-slate-900 pt-1">Total Paid: <span id="modalTotalAmount">$0.00</span></div>
        </div>

        <!-- Status Update Form -->
        <form id="orderStatusForm" method="POST" class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-3">
            @csrf
            @method('PATCH')
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <label class="text-xs font-bold text-slate-700">Update Status:</label>
                <select name="order_status" id="selectOrderStatus" class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold">
                    <option value="Pending">Pending</option>
                    <option value="Processing">Processing</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
                <button type="submit" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-xs transition-colors">
                    Update
                </button>
            </div>

            <button type="button" onclick="closeOrderModal()" class="w-full sm:w-auto px-4 py-2 border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-xl">
                Close
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openOrderDetailsModal(order) {
        document.getElementById('modalOrderNum').innerText = order.order_number;
        document.getElementById('modalOrderDate').innerText = `Placed on ${new Date(order.created_at).toLocaleString()}`;
        document.getElementById('modalCustomerName').innerText = order.customer_name;
        document.getElementById('modalCustomerEmail').innerText = order.customer_email || 'No email registered';
        document.getElementById('modalOrderSource').innerText = order.source;
        document.getElementById('modalPaymentMethod').innerText = `${order.payment_method} (${order.payment_status})`;
        
        const badge = document.getElementById('modalOrderStatusBadge');
        badge.innerText = order.order_status;
        badge.className = 'inline-block mt-1 px-2.5 py-0.5 rounded text-[11px] font-bold ' + 
            (order.order_status === 'Completed' ? 'bg-emerald-100 text-emerald-800' : 
            (order.order_status === 'Processing' ? 'bg-blue-100 text-blue-800' : 
            (order.order_status === 'Pending' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800')));

        let itemsHtml = '';
        if (order.items && order.items.length > 0) {
            order.items.forEach(item => {
                itemsHtml += `
                    <tr>
                        <td class="py-2.5 px-3">
                            <span class="font-bold text-slate-900">${item.product_name}</span>
                            <span class="block text-[10px] font-mono text-slate-400">${item.product_sku || 'N/A'}</span>
                        </td>
                        <td class="py-2.5 px-3">$${parseFloat(item.unit_price).toFixed(2)}</td>
                        <td class="py-2.5 px-3 font-semibold">${item.quantity}</td>
                        <td class="py-2.5 px-3 text-right font-bold text-slate-900">$${parseFloat(item.subtotal).toFixed(2)}</td>
                    </tr>
                `;
            });
        } else {
            itemsHtml = '<tr><td colspan="4" class="py-4 text-center text-slate-400">No individual line items stored for this order.</td></tr>';
        }
        document.getElementById('modalLineItems').innerHTML = itemsHtml;

        document.getElementById('modalSubtotal').innerText = `$${parseFloat(order.subtotal).toFixed(2)}`;
        document.getElementById('modalTax').innerText = `$${parseFloat(order.tax_amount).toFixed(2)}`;
        document.getElementById('modalDiscount').innerText = `-$${parseFloat(order.discount_amount).toFixed(2)}`;
        document.getElementById('modalTotalAmount').innerText = `$${parseFloat(order.total_amount).toFixed(2)}`;

        document.getElementById('orderStatusForm').action = `/orders/${order.id}/status`;
        document.getElementById('selectOrderStatus').value = order.order_status;

        document.getElementById('orderDetailsModal').classList.remove('hidden');
    }

    function closeOrderModal() {
        document.getElementById('orderDetailsModal').classList.add('hidden');
    }
</script>
@endpush
@endsection
