@extends('layouts.app')

@section('title', 'POS Cashier Terminal')

@section('breadcrumbs')
    <span class="text-slate-400 font-medium">Enterprise</span>
    <span class="text-slate-300">/</span>
    <h1 class="text-slate-900 font-bold text-base tracking-tight">Point of Sale (POS) Terminal</h1>
@endsection

@section('content')
<div class="h-[calc(100vh-8.5rem)] flex flex-col lg:flex-row gap-6">

    <!-- Left: Catalog & Product Browser (65%) -->
    <div class="flex-1 bg-white rounded-2xl border border-slate-200/80 shadow-xs flex flex-col overflow-hidden">
        
        <!-- Header & Search Toolbar -->
        <div class="p-4 sm:p-5 border-b border-slate-100 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
            <!-- Search Filter -->
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" 
                       id="posSearchInput" 
                       oninput="filterProducts()" 
                       placeholder="Scan barcode, SKU or search product..." 
                       class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
            </div>

            <div class="flex items-center gap-2">
                <span class="text-xs font-semibold text-slate-500">Terminal: #01-NYC</span>
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            </div>
        </div>

        <!-- Categories Filter Row -->
        <div class="px-4 py-2.5 bg-slate-50/70 border-b border-slate-100 flex items-center gap-2 overflow-x-auto text-xs no-scrollbar">
            <button type="button" 
                    onclick="filterCategory('All', this)" 
                    class="category-pill active px-3.5 py-1.5 rounded-xl font-bold bg-blue-600 text-white shadow-xs transition-colors shrink-0">
                All Products
            </button>
            @foreach ($categories as $cat)
                <button type="button" 
                        onclick="filterCategory('{{ $cat }}', this)" 
                        class="category-pill px-3.5 py-1.5 rounded-xl font-medium bg-white text-slate-600 border border-slate-200 hover:border-slate-300 hover:text-slate-900 transition-colors shrink-0">
                    {{ $cat }}
                </button>
            @endforeach
        </div>

        <!-- Products Grid Container -->
        <div class="flex-1 p-4 sm:p-5 overflow-y-auto">
            <div id="productGrid" class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
                @forelse ($products as $prod)
                    <div class="product-card bg-white border border-slate-200/90 rounded-2xl p-3 flex flex-col justify-between hover:border-blue-500/80 hover:shadow-md transition-all cursor-pointer group"
                         data-id="{{ $prod->id }}"
                         data-name="{{ $prod->name }}"
                         data-sku="{{ $prod->sku }}"
                         data-price="{{ $prod->price }}"
                         data-category="{{ $prod->category }}"
                         data-stock="{{ $prod->stock_quantity }}"
                         onclick="addToCart({{ $prod->id }})">
                        
                        <!-- Thumbnail -->
                        <div class="w-full h-28 bg-slate-50 rounded-xl mb-3 flex items-center justify-center overflow-hidden border border-slate-100 group-hover:bg-blue-50/30 transition-colors">
                            @if ($prod->image_path)
                                <img src="{{ asset('storage/' . $prod->image_path) }}" alt="{{ $prod->name }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-8 h-8 text-slate-300 group-hover:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            @endif
                        </div>

                        <!-- Info -->
                        <div>
                            <span class="text-[10px] font-mono text-slate-400 block uppercase tracking-wider">{{ $prod->sku }}</span>
                            <h4 class="text-xs sm:text-sm font-bold text-slate-900 line-clamp-1 group-hover:text-blue-600 transition-colors">
                                {{ $prod->name }}
                            </h4>
                        </div>

                        <!-- Price & Stock -->
                        <div class="mt-3 pt-2 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-sm font-extrabold text-slate-900">${{ number_format($prod->price, 2) }}</span>
                            <span class="stock-badge text-[10px] font-bold px-2 py-0.5 rounded-md {{ $prod->stock_quantity <= 10 ? 'bg-rose-50 text-rose-600 border border-rose-100' : 'bg-slate-100 text-slate-600' }}">
                                {{ $prod->stock_quantity }} in stock
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center text-slate-400">
                        No active in-stock products available.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- Right: POS Live Cart & Checkout (35%) -->
    <div class="w-full lg:w-96 bg-white rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between shrink-0 overflow-hidden">
        
        <!-- Cart Header -->
        <div class="p-4 border-b border-slate-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-extrabold text-slate-900">Current Order</h3>
                </div>
                <button type="button" onclick="clearCart()" class="text-xs text-rose-600 hover:text-rose-700 font-semibold">
                    Clear Cart
                </button>
            </div>

            <!-- Customer Name Input -->
            <div class="mt-3">
                <input type="text" 
                       id="customerNameInput" 
                       placeholder="Customer Name (e.g. Walk-in Customer)" 
                       class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
            </div>
        </div>

        <!-- Cart Items List (Scrollable) -->
        <div id="cartItemsContainer" class="flex-1 p-4 overflow-y-auto space-y-3 min-h-[160px]">
            <!-- Dynamic Cart Items via JS -->
            <div id="emptyCartMessage" class="h-full flex flex-col items-center justify-center text-center py-10 text-slate-400">
                <svg class="w-10 h-10 text-slate-200 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <p class="text-xs font-medium">Cart is currently empty</p>
                <span class="text-[10px] text-slate-400 mt-0.5">Click any product to add to sale</span>
            </div>
        </div>

        <!-- Cart Footer & Checkout Controls -->
        <div class="p-4 border-t border-slate-100 bg-slate-50/50 space-y-3">
            
            <!-- Coupon Input -->
            <div class="flex items-center gap-2">
                <input type="text" 
                       id="couponCodeInput" 
                       placeholder="Promo / Coupon (e.g. WELCOME15)" 
                       class="flex-1 px-3 py-1.5 bg-white border border-slate-200 rounded-xl text-xs uppercase font-mono focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="button" 
                        onclick="applyCoupon()" 
                        class="px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl shadow-xs transition-colors">
                    Apply
                </button>
            </div>
            <div id="appliedPromoBadge" class="hidden text-[11px] font-semibold text-emerald-600 flex items-center justify-between px-1">
                <span id="promoLabel">Promo Applied</span>
                <button type="button" onclick="removeCoupon()" class="text-rose-500 hover:text-rose-700">&times; Remove</button>
            </div>

            <!-- Price Calculations -->
            <div class="space-y-1.5 text-xs">
                <div class="flex justify-between text-slate-500">
                    <span>Subtotal</span>
                    <span id="posSubtotal" class="font-semibold text-slate-800">$0.00</span>
                </div>
                <div class="flex justify-between text-slate-500">
                    <span>Sales Tax (8%)</span>
                    <span id="posTax" class="font-semibold text-slate-800">$0.00</span>
                </div>
                <div id="discountRow" class="hidden flex justify-between text-emerald-600 font-semibold">
                    <span>Coupon Discount</span>
                    <span id="posDiscount">-$0.00</span>
                </div>
                <div class="flex justify-between text-base font-extrabold text-slate-900 pt-2 border-t border-slate-200">
                    <span>Total Due</span>
                    <span id="posTotal" class="text-blue-600">$0.00</span>
                </div>
            </div>

            <!-- Payment Method Tabs -->
            <div class="pt-2">
                <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Payment Method</label>
                <div class="grid grid-cols-3 gap-2">
                    <button type="button" onclick="setPaymentMethod('Cash', this)" class="payment-method-btn active py-2 rounded-xl text-xs font-bold bg-blue-600 text-white shadow-xs text-center transition-colors">
                        Cash
                    </button>
                    <button type="button" onclick="setPaymentMethod('Credit Card', this)" class="payment-method-btn py-2 rounded-xl text-xs font-medium bg-white text-slate-700 border border-slate-200 hover:bg-slate-50 text-center transition-colors">
                        Card
                    </button>
                    <button type="button" onclick="setPaymentMethod('UPI', this)" class="payment-method-btn py-2 rounded-xl text-xs font-medium bg-white text-slate-700 border border-slate-200 hover:bg-slate-50 text-center transition-colors">
                        UPI / QR
                    </button>
                </div>
            </div>

            <!-- Cash Tendered Field (Shown when Cash selected) -->
            <div id="cashTenderedGroup" class="pt-1">
                <div class="flex items-center gap-2">
                    <input type="number" 
                           step="0.01" 
                           min="0" 
                           id="amountTenderedInput" 
                           oninput="calculateChange()" 
                           placeholder="Cash Received ($)" 
                           class="flex-1 px-3 py-1.5 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <div class="text-right text-xs">
                        <span class="text-slate-400 block text-[10px]">Change</span>
                        <span id="posChangeDue" class="font-extrabold text-emerald-600">$0.00</span>
                    </div>
                </div>
            </div>

            <!-- Checkout Action Button -->
            <button type="button" 
                    id="checkoutBtn" 
                    onclick="processCheckout()" 
                    disabled 
                    class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 disabled:opacity-40 disabled:cursor-not-allowed text-white font-extrabold text-sm rounded-xl shadow-xs transition-colors flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>Charge & Complete Sale</span>
            </button>
        </div>

    </div>

</div>

<!-- Printable Receipt Modal -->
<div id="receiptModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-2xl border border-slate-100 relative animate-fade-in font-mono text-xs">
        
        <!-- Receipt Content -->
        <div id="printableReceiptArea" class="space-y-4">
            <div class="text-center pb-3 border-b border-dashed border-slate-300">
                <h2 class="text-base font-extrabold text-slate-900 font-sans tracking-tight">Ace360degree Store #01</h2>
                <p class="text-[11px] text-slate-500 mt-0.5">742 Broadway Ave, New York, NY</p>
                <p class="text-[10px] text-slate-400">Tel: +1 (212) 555-0198</p>
                <div class="mt-2 text-[10px] text-slate-600">
                    <span id="receiptOrderNum" class="font-bold">POS-20261029-XXXX</span> • <span id="receiptDate">Oct 29, 2026</span>
                </div>
            </div>

            <!-- Receipt Line Items -->
            <div class="space-y-2 border-b border-dashed border-slate-300 pb-3">
                <div id="receiptItemsList" class="space-y-1.5">
                    <!-- Populated via JS -->
                </div>
            </div>

            <!-- Financials Breakdown -->
            <div class="space-y-1 text-[11px] border-b border-dashed border-slate-300 pb-3">
                <div class="flex justify-between">
                    <span>Subtotal:</span>
                    <span id="receiptSubtotal">$0.00</span>
                </div>
                <div class="flex justify-between">
                    <span>Sales Tax (8%):</span>
                    <span id="receiptTax">$0.00</span>
                </div>
                <div class="flex justify-between text-emerald-700">
                    <span>Discount:</span>
                    <span id="receiptDiscount">-$0.00</span>
                </div>
                <div class="flex justify-between font-bold text-sm text-slate-900 pt-1">
                    <span>TOTAL PAID:</span>
                    <span id="receiptTotal">$0.00</span>
                </div>
            </div>

            <!-- Tender & Change -->
            <div class="space-y-1 text-[11px] pb-2">
                <div class="flex justify-between">
                    <span>Method:</span>
                    <span id="receiptMethod" class="font-bold">Cash</span>
                </div>
                <div class="flex justify-between">
                    <span>Tendered:</span>
                    <span id="receiptTendered">$0.00</span>
                </div>
                <div class="flex justify-between font-bold text-emerald-600">
                    <span>Change:</span>
                    <span id="receiptChange">$0.00</span>
                </div>
            </div>

            <div class="text-center text-[10px] text-slate-400 pt-2">
                Thank you for shopping with Ace360degree!<br>
                Retain receipt for returns within 30 days.
            </div>
        </div>

        <!-- Receipt Action Buttons -->
        <div class="pt-4 border-t border-slate-100 flex items-center gap-2">
            <button type="button" onclick="printReceipt()" class="flex-1 py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl shadow-xs transition-colors flex items-center justify-center gap-1.5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Print</span>
            </button>
            <button type="button" onclick="closeReceiptModal()" class="flex-1 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-xs transition-colors">
                New Sale
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>


const EMPTY_CART_HTML = `
    <div id="emptyCartMessage" class="h-full flex flex-col items-center justify-center text-center py-10 text-slate-400">
        <svg class="w-10 h-10 text-slate-200 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
        </svg>
        <p class="text-xs font-medium">Cart is currently empty</p>
        <span class="text-[10px] text-slate-400 mt-0.5">Click any product to add to sale</span>
    </div>`;

    // In-memory catalog & cart state
    const productsData = @json($products);
    const promotionsData = @json($promotions);
    let cart = [];
    let activeCategory = 'All';
    let appliedCoupon = null;
    let selectedPaymentMethod = 'Cash';

    function filterCategory(cat, btn) {
        activeCategory = cat;
        document.querySelectorAll('.category-pill').forEach(el => {
            el.classList.remove('bg-blue-600', 'text-white', 'shadow-xs', 'font-bold');
            el.classList.add('bg-white', 'text-slate-600');
        });
        btn.classList.add('bg-blue-600', 'text-white', 'shadow-xs', 'font-bold');
        btn.classList.remove('bg-white', 'text-slate-600');
        filterProducts();
    }

    function filterProducts() {
        const query = document.getElementById('posSearchInput').value.toLowerCase().trim();
        const cards = document.querySelectorAll('.product-card');

        cards.forEach(card => {
            const name = card.getAttribute('data-name').toLowerCase();
            const sku = card.getAttribute('data-sku').toLowerCase();
            const category = card.getAttribute('data-category');

            const matchesCategory = (activeCategory === 'All' || category === activeCategory);
            const matchesQuery = (!query || name.includes(query) || sku.includes(query));

            if (matchesCategory && matchesQuery) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
    }

    function addToCart(productId) {
        const product = productsData.find(p => p.id === productId);
        if (!product) return;

        const existing = cart.find(item => item.product_id === productId);
        if (existing) {
            if (existing.quantity >= product.stock_quantity) {
                alert(`Cannot add more. Only ${product.stock_quantity} units available in inventory.`);
                return;
            }
            existing.quantity++;
        } else {
            if (product.stock_quantity <= 0) {
                alert('Product is out of stock.');
                return;
            }
            cart.push({
                product_id: product.id,
                name: product.name,
                sku: product.sku,
                price: parseFloat(product.price),
                stock: product.stock_quantity,
                quantity: 1,
            });
        }
        renderCart();
    }

    function updateCartQty(productId, delta) {
        const item = cart.find(i => i.product_id === productId);
        if (!item) return;

        item.quantity += delta;
        if (item.quantity <= 0) {
            cart = cart.filter(i => i.product_id !== productId);
        } else if (item.quantity > item.stock) {
            alert(`Only ${item.stock} units available in inventory.`);
            item.quantity = item.stock;
        }
        renderCart();
    }

    function removeCartItem(productId) {
        cart = cart.filter(i => i.product_id !== productId);
        renderCart();
    }

    function clearCart() {
        cart = [];
        appliedCoupon = null;
        document.getElementById('couponCodeInput').value = '';
        document.getElementById('appliedPromoBadge').classList.add('hidden');
        renderCart();
    }

    function applyCoupon() {
        const code = document.getElementById('couponCodeInput').value.trim().toUpperCase();
        if (!code) return;

        const promo = promotionsData.find(p => p.code.toUpperCase() === code && p.status === 'Active');
        if (!promo) {
            alert('Invalid or expired promotional code.');
            return;
        }

        appliedCoupon = promo;
        document.getElementById('appliedPromoBadge').classList.remove('hidden');
        document.getElementById('promoLabel').innerText = `Applied: ${promo.code} (${promo.discount_type === 'percentage' ? promo.discount_value + '%' : '$' + promo.discount_value} OFF)`;
        renderCart();
    }

    function removeCoupon() {
        appliedCoupon = null;
        document.getElementById('couponCodeInput').value = '';
        document.getElementById('appliedPromoBadge').classList.add('hidden');
        renderCart();
    }

    function setPaymentMethod(method, btn) {
        selectedPaymentMethod = method;
        document.querySelectorAll('.payment-method-btn').forEach(el => {
            el.classList.remove('bg-blue-600', 'text-white', 'shadow-xs', 'font-bold');
            el.classList.add('bg-white', 'text-slate-700');
        });
        btn.classList.add('bg-blue-600', 'text-white', 'shadow-xs', 'font-bold');
        btn.classList.remove('bg-white', 'text-slate-700');

        const tenderGroup = document.getElementById('cashTenderedGroup');
        if (method === 'Cash') {
            tenderGroup.classList.remove('hidden');
        } else {
            tenderGroup.classList.add('hidden');
        }
    }

   function renderCart() {
    const container = document.getElementById('cartItemsContainer');
    const checkoutBtn = document.getElementById('checkoutBtn');

    if (cart.length === 0) {
        container.innerHTML = EMPTY_CART_HTML;
        checkoutBtn.disabled = true;

        document.getElementById('posSubtotal').innerText = '$0.00';
        document.getElementById('posTax').innerText = '$0.00';
        document.getElementById('posTotal').innerText = '$0.00';
        document.getElementById('discountRow').classList.add('hidden');
        document.getElementById('posChangeDue').innerText = '$0.00';
        return;
    }

    checkoutBtn.disabled = false;
   

        let subtotal = 0;
        let html = '';

        cart.forEach(item => {
            const lineSubtotal = item.price * item.quantity;
            subtotal += lineSubtotal;

            html += `
                <div class="p-2.5 bg-slate-50 border border-slate-100 rounded-xl flex items-center justify-between gap-3 text-xs">
                    <div class="flex-1">
                        <span class="font-bold text-slate-900 block truncate max-w-[140px]">${item.name}</span>
                        <span class="text-[10px] text-slate-400 font-mono">$${item.price.toFixed(2)} each</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <button type="button" onclick="updateCartQty(${item.product_id}, -1)" class="w-6 h-6 rounded-lg bg-white border border-slate-200 text-slate-600 hover:bg-slate-100 font-bold flex items-center justify-center">-</button>
                        <span class="w-5 text-center font-bold text-slate-900">${item.quantity}</span>
                        <button type="button" onclick="updateCartQty(${item.product_id}, 1)" class="w-6 h-6 rounded-lg bg-white border border-slate-200 text-slate-600 hover:bg-slate-100 font-bold flex items-center justify-center">+</button>
                    </div>
                    <div class="text-right flex items-center gap-2">
                        <span class="font-bold text-slate-900 min-w-[50px]">$${lineSubtotal.toFixed(2)}</span>
                        <button type="button" onclick="removeCartItem(${item.product_id})" class="text-slate-400 hover:text-rose-600 p-1">
                            &times;
                        </button>
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;

        // Calculations
        let discount = 0;
        if (appliedCoupon) {
            if (subtotal >= parseFloat(appliedCoupon.min_spend || 0)) {
                if (appliedCoupon.discount_type === 'percentage') {
                    discount = (subtotal * parseFloat(appliedCoupon.discount_value)) / 100;
                } else {
                    discount = Math.min(subtotal, parseFloat(appliedCoupon.discount_value));
                }
            }
        }

        const tax = (subtotal - discount) * 0.08;
        const total = Math.max(0, subtotal - discount + tax);

        document.getElementById('posSubtotal').innerText = `$${subtotal.toFixed(2)}`;
        document.getElementById('posTax').innerText = `$${tax.toFixed(2)}`;
        document.getElementById('posTotal').innerText = `$${total.toFixed(2)}`;

        if (discount > 0) {
            document.getElementById('discountRow').classList.remove('hidden');
            document.getElementById('posDiscount').innerText = `-$${discount.toFixed(2)}`;
        } else {
            document.getElementById('discountRow').classList.add('hidden');
        }

        calculateChange();
    }

    function calculateChange() {
        const totalText = document.getElementById('posTotal').innerText.replace('$', '');
        const total = parseFloat(totalText) || 0;
        const tendered = parseFloat(document.getElementById('amountTenderedInput').value) || 0;
        const change = Math.max(0, tendered - total);
        document.getElementById('posChangeDue').innerText = `$${change.toFixed(2)}`;
    }

    function processCheckout() {
        if (cart.length === 0) return;

        const customerName = document.getElementById('customerNameInput').value.trim() || 'Walk-in Customer';
        const total = parseFloat(document.getElementById('posTotal').innerText.replace('$', '')) || 0;
        const tendered = parseFloat(document.getElementById('amountTenderedInput').value) || total;

        if (selectedPaymentMethod === 'Cash' && tendered < total) {
            alert(`Amount tendered ($${tendered.toFixed(2)}) is less than total due ($${total.toFixed(2)}).`);
            return;
        }

        const payload = {
            items: cart.map(i => ({ product_id: i.product_id, quantity: i.quantity })),
            payment_method: selectedPaymentMethod,
            customer_name: customerName,
            coupon_code: appliedCoupon ? appliedCoupon.code : null,
            amount_tendered: tendered,
        };

        const checkoutBtn = document.getElementById('checkoutBtn');
        checkoutBtn.disabled = true;
        checkoutBtn.innerText = 'Synchronizing with MySQL...';

        fetch("{{ route('pos.checkout') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            checkoutBtn.disabled = false;
            checkoutBtn.innerHTML = `
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>Charge & Complete Sale</span>
            `;

            if (!data.success) {
                alert(data.message || 'Checkout failed.');
                return;
            }

            // Deduct local product card stock levels
            cart.forEach(cartItem => {
                const prod = productsData.find(p => p.id === cartItem.product_id);
                if (prod) {
                    prod.stock_quantity -= cartItem.quantity;
                    const card = document.querySelector(`.product-card[data-id="${prod.id}"]`);
                    if (card) {
                        card.setAttribute('data-stock', prod.stock_quantity);
                        const badge = card.querySelector('.stock-badge');
                        if (badge) badge.innerText = `${prod.stock_quantity} in stock`;
                    }
                }
            });

            // Display Receipt Modal
            showReceipt(data.order);
        })
        .catch(err => {
            checkoutBtn.disabled = false;
            checkoutBtn.innerText = 'Charge & Complete Sale';
            alert('Error processing POS transaction.');
        });
    }

    function showReceipt(order) {
        document.getElementById('receiptOrderNum').innerText = order.order_number;
        document.getElementById('receiptDate').innerText = order.date;
        document.getElementById('receiptSubtotal').innerText = `$${order.subtotal}`;
        document.getElementById('receiptTax').innerText = `$${order.tax}`;
        document.getElementById('receiptDiscount').innerText = `-$${order.discount}`;
        document.getElementById('receiptTotal').innerText = `$${order.total}`;
        document.getElementById('receiptMethod').innerText = order.payment_method;
        document.getElementById('receiptTendered').innerText = `$${order.tendered}`;
        document.getElementById('receiptChange').innerText = `$${order.change}`;

        let itemsHtml = '';
        order.items.forEach(item => {
            itemsHtml += `
                <div class="flex justify-between">
                    <span>${item.quantity}x ${item.product_name}</span>
                    <span>$${parseFloat(item.subtotal).toFixed(2)}</span>
                </div>
            `;
        });
        document.getElementById('receiptItemsList').innerHTML = itemsHtml;

        document.getElementById('receiptModal').classList.remove('hidden');
    }

    function printReceipt() {
        window.print();
    }

    function closeReceiptModal() {
        document.getElementById('receiptModal').classList.add('hidden');
        clearCart();
    }
</script>
@endpush
@endsection
