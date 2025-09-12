<x-app-layout>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Alert Messages -->
            @if (session('success'))
                <div class="relative mb-4 rounded border border-green-400 bg-green-100 px-4 py-3 text-green-700"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="relative mb-4 rounded border border-red-400 bg-red-100 px-4 py-3 text-red-700" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <form id="pos-form" action="{{ route('transactions.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-6 p-6 lg:grid-cols-3">

                        <!-- Products Section -->
                        <div class="lg:col-span-2">
                            <div class="mb-4">
                                <h3 class="mb-4 text-lg font-medium text-gray-900">Products</h3>

                                <!-- Search Products -->
                                <div class="mb-4">
                                    <input type="text" id="product-search" placeholder="Search products..."
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <!-- Products Grid -->
                                <div id="products-grid"
                                    class="grid h-[calc(100vh-220px)] grid-cols-2 gap-4 overflow-y-auto md:grid-cols-3 xl:grid-cols-4">
                                    @foreach ($products as $product)
                                        <div id="product-{{ $product->id }}"
                                            class="product-card cursor-pointer rounded-lg border bg-white p-4 shadow-sm transition hover:shadow-md"
                                            data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                            data-price="{{ $product->price }}" data-stock="{{ $product->stock }}"
                                            data-original-stock="{{ $product->stock }}">

                                            <div class="text-center">
                                                <!-- Icon -->
                                                <div
                                                    class="mx-auto mb-3 flex h-20 w-20 items-center justify-center rounded-lg bg-gray-100">
                                                    <svg class="h-10 w-10 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                    </svg>
                                                </div>

                                                <!-- Product Info -->
                                                <h4 class="mb-1 truncate text-sm font-semibold text-gray-800">
                                                    {{ $product->name }}
                                                </h4>
                                                <p class="text-sm font-bold text-blue-600">
                                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                                </p>
                                                <p class="stock-display text-xs text-gray-500">
                                                    Stock: <span class="stock-number">{{ $product->stock }}</span>
                                                </p>
                                                <!-- Out of Stock Overlay -->
                                                <div
                                                    class="out-of-stock-overlay absolute inset-0 hidden items-center justify-center rounded-lg bg-gray-900 bg-opacity-50">
                                                    <span class="text-sm font-bold text-white">OUT OF STOCK</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>

                        <!-- Cart Section -->
                        <div class="lg:col-span-1">
                            <div class="flex h-[calc(100vh-150px)] flex-col rounded-lg bg-white p-4 shadow">
                                <h3 class="mb-4 text-lg font-medium text-gray-900">Order Summary</h3>

                                <!-- Customer Selection -->
                                <div class="mb-4">
                                    <label for="customer_id"
                                        class="mb-2 block text-sm font-medium text-gray-700">Customer</label>
                                    <select name="customer_id" id="customer_id"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        required>
                                        <option value="">Select Customer</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">
                                                {{ $customer->full_name }} - {{ $customer->phone }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Cart Items -->
                                <div class="mb-4 flex-1 overflow-y-auto">
                                    <div id="cart-items" class="space-y-2">
                                        <div id="empty-cart" class="py-8 text-center text-gray-500">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4m3.6 8L9 21m0 0H7m2 0h2m6-8a2 2 0 11-4 0 2 2 0 014 0z">
                                                </path>
                                            </svg>
                                            <p class="mt-2">Cart is empty</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Order Total -->
                                <div class="space-y-2 border-t pt-4">
                                    <div class="flex justify-between text-sm">
                                        <span>Subtotal:</span>
                                        <span id="subtotal">Rp 0</span>
                                    </div>
                                    <div class="flex justify-between text-sm text-green-600">
                                        <span>Discount:</span>
                                        <span id="discount">Rp 0</span>
                                    </div>
                                    <div class="flex justify-between border-t pt-2 text-lg font-bold">
                                        <span>Total:</span>
                                        <span id="total">Rp 0</span>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="mt-6 space-y-2">
                                    <button type="submit" id="checkout-btn"
                                        class="w-full rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:cursor-not-allowed disabled:opacity-50"
                                        disabled>
                                        Process Payment
                                    </button>
                                    <button type="button" id="clear-cart"
                                        class="w-full rounded-md bg-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                        Clear Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let cart = [];
        let itemCounter = 0;

        // Store original stock for each product
        let originalStock = {};

        // Initialize original stock data
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.product-card').forEach(card => {
                const productId = card.dataset.id;
                const stock = parseInt(card.dataset.originalStock);
                originalStock[productId] = stock;
            });
        });

        // Product search functionality
        document.getElementById('product-search').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const productCards = document.querySelectorAll('.product-card');

            productCards.forEach(card => {
                const productName = card.dataset.name.toLowerCase();
                if (productName.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Add product to cart
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('click', function() {
                const productId = this.dataset.id;
                const productName = this.dataset.name;
                const productPrice = parseInt(this.dataset.price);

                const maxStock = originalStock[productId];
                const existingItem = cart.find(item => item.product_id === productId);

                if (existingItem) {
                    if (existingItem.quantity < maxStock) {
                        existingItem.quantity += 1;
                        updateProductStock(productId, maxStock - existingItem.quantity);
                        updateCartDisplay();
                    } else {
                        alert('Insufficient stock!');
                    }
                } else {
                    if (maxStock > 0) {
                        cart.push({
                            product_id: productId,
                            name: productName,
                            price: productPrice,
                            quantity: 1
                        });
                        updateProductStock(productId, maxStock - 1);
                        updateCartDisplay();
                    } else {
                        alert('Product is out of stock!');
                    }
                }
            });
        });

        // Update product stock display
        function updateProductStock(productId, newStock) {
            const productCard = document.getElementById(`product-${productId}`);
            const stockNumberElement = productCard.querySelector('.stock-number');
            const outOfStockOverlay = productCard.querySelector('.out-of-stock-overlay');

            // Update data attribute
            productCard.dataset.stock = newStock;

            // Update display
            stockNumberElement.textContent = newStock;

            // Handle out of stock state
            if (newStock <= 0) {
                productCard.classList.add('opacity-50', 'cursor-not-allowed');
                productCard.classList.remove('hover:shadow-md', 'cursor-pointer');
                stockNumberElement.parentElement.classList.add('text-red-500');
                stockNumberElement.parentElement.classList.remove('text-gray-500');
                if (outOfStockOverlay) {
                    outOfStockOverlay.classList.remove('hidden');
                }
            } else {
                productCard.classList.remove('opacity-50', 'cursor-not-allowed');
                productCard.classList.add('hover:shadow-md', 'cursor-pointer');
                stockNumberElement.parentElement.classList.remove('text-red-500');
                stockNumberElement.parentElement.classList.add('text-gray-500');
                if (outOfStockOverlay) {
                    outOfStockOverlay.classList.add('hidden');
                }
            }

            // Update stock color based on quantity
            if (newStock <= 5 && newStock > 0) {
                stockNumberElement.parentElement.classList.add('text-orange-500');
                stockNumberElement.parentElement.classList.remove('text-gray-500');
            } else if (newStock > 5) {
                stockNumberElement.parentElement.classList.add('text-gray-500');
                stockNumberElement.parentElement.classList.remove('text-orange-500');
            }
        }

        // Restore product stock display
        function restoreProductStock(productId, quantityToRestore) {
            const productCard = document.getElementById(`product-${productId}`);
            const currentStock = parseInt(productCard.dataset.stock);
            const newStock = currentStock + quantityToRestore;

            updateProductStock(productId, newStock);
        }

        // Update cart display
        function updateCartDisplay() {
            const cartContainer = document.getElementById('cart-items');

            if (cart.length === 0) {
                cartContainer.innerHTML = `
            <div id="empty-cart" class="text-center py-8 text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4m3.6 8L9 21m0 0H7m2 0h2
                        m6-8a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
                <p class="mt-2">Cart is empty</p>
            </div>
        `;
            } else {
                let cartHTML = '';
                cart.forEach((item, index) => {
                    cartHTML += `
                <div class="flex items-center justify-between p-2 bg-white rounded border">
                    <div class="flex-1">
                        <h4 class="text-sm font-medium">${item.name}</h4>
                        <p class="text-xs text-gray-500">Rp ${item.price.toLocaleString()}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button type="button" onclick="updateQuantity(${index}, -1)" class="w-6 h-6 bg-gray-200 rounded text-xs hover:bg-gray-300">-</button>
                        <span class="text-sm font-medium w-8 text-center">${item.quantity}</span>
                        <button type="button" onclick="updateQuantity(${index}, 1)" class="w-6 h-6 bg-gray-200 rounded text-xs hover:bg-gray-300">+</button>
                        <button type="button" onclick="removeItem(${index})" class="w-6 h-6 bg-red-500 text-white rounded text-xs hover:bg-red-600">×</button>
                    </div>
                    <input type="hidden" name="items[${index}][product_id]" value="${item.product_id}">
                    <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
                </div>
            `;
                });
                cartContainer.innerHTML = cartHTML;
            }

            updateTotals();
            updateCheckoutButton();
        }

        // Update quantity
        function updateQuantity(index, change) {
            const item = cart[index];
            const newQuantity = item.quantity + change;
            const productCard = document.getElementById(`product-${item.product_id}`);
            const currentStock = parseInt(productCard.dataset.stock);

            if (change > 0) {
                // Increasing quantity - check available stock
                if (currentStock > 0) {
                    item.quantity = newQuantity;
                    updateProductStock(item.product_id, currentStock - 1);
                    updateCartDisplay();
                } else {
                    alert('Insufficient stock!');
                }
            } else if (change < 0) {
                if (newQuantity > 0) {
                    // Decreasing quantity - restore stock
                    item.quantity = newQuantity;
                    restoreProductStock(item.product_id, 1);
                    updateCartDisplay();
                } else {
                    // Remove item completely
                    removeItem(index);
                }
            }
        }

        // Remove item from cart
        function removeItem(index) {
            const item = cart[index];
            // Restore all stock for this item
            restoreProductStock(item.product_id, item.quantity);

            cart.splice(index, 1);
            updateCartDisplay();
        }

        // Update totals
        function updateTotals() {
            let subtotal = 0;
            cart.forEach(item => {
                subtotal += item.price * item.quantity;
            });

            let discount = 0;
            if (subtotal > 1000000) {
                discount = subtotal * 0.15;
            } else if (subtotal > 500000) {
                discount = subtotal * 0.10;
            }

            const total = subtotal - discount;

            document.getElementById('subtotal').textContent = 'Rp ' + subtotal.toLocaleString();
            document.getElementById('discount').textContent = 'Rp ' + discount.toLocaleString();
            document.getElementById('total').textContent = 'Rp ' + total.toLocaleString();
        }

        // Update checkout button
        function updateCheckoutButton() {
            const checkoutBtn = document.getElementById('checkout-btn');
            const customerSelected = document.getElementById('customer_id').value;

            if (cart.length > 0 && customerSelected) {
                checkoutBtn.disabled = false;
            } else {
                checkoutBtn.disabled = true;
            }
        }

        // Clear cart
        document.getElementById('clear-cart').addEventListener('click', function() {
            if (confirm('Are you sure you want to clear the cart?')) {
                // Restore all stock before clearing cart
                cart.forEach(item => {
                    restoreProductStock(item.product_id, item.quantity);
                });

                cart = [];
                updateCartDisplay();
            }
        });

        // Reset all stock to original values
        function resetAllStock() {
            Object.keys(originalStock).forEach(productId => {
                updateProductStock(productId, originalStock[productId]);
            });
        }

        // Customer selection change
        document.getElementById('customer_id').addEventListener('change', updateCheckoutButton);

        // Form submission
        document.getElementById('pos-form').addEventListener('submit', function(e) {
            if (cart.length === 0) {
                e.preventDefault();
                alert('Please add at least one item to cart');
                return;
            }

            if (!document.getElementById('customer_id').value) {
                e.preventDefault();
                alert('Please select a customer');
                return;
            }
        });
    </script>

    <style>
        .product-card {
            position: relative;
        }

        .out-of-stock-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 10;
        }

        /* Animation for stock changes */
        .stock-number {
            transition: color 0.3s ease;
        }

        .product-card {
            transition: opacity 0.3s ease, transform 0.2s ease;
        }

        .product-card:hover:not(.cursor-not-allowed) {
            transform: translateY(-2px);
        }

        /* Low stock warning animation */
        @keyframes pulse-orange {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        .text-orange-500 {
            animation: pulse-orange 2s infinite;
        }
    </style>
</x-app-layout>
