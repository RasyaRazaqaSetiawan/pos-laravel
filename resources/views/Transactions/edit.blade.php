<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 flex items-center justify-between">
                <h1 class="text-3xl font-bold text-gray-900">Edit Transaction #{{ $transaction->id }}</h1>
                <a href="{{ route('transactions.index') }}"
                    class="flex items-center gap-2 rounded-lg bg-gray-500 px-4 py-2 font-medium text-white transition duration-200 hover:bg-gray-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                    Back to Transactions
                </a>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                <!-- Left Column - Form -->
                <div class="lg:col-span-2">
                    <form action="{{ route('transactions.update', $transaction) }}" method="POST" id="transactionForm">
                        @csrf
                        @method('PUT')

                        <!-- Wrapper Card -->
                        <div class="space-y-8 rounded-xl bg-white p-6 shadow-lg">

                            <!-- Customer Section -->
                            <div>
                                <div class="mb-4 flex items-center gap-2">
                                    <svg class="h-5 w-5 text-gray-700" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                    <h2 class="text-xl font-bold text-gray-900">Customer</h2>
                                </div>
                                <div class="relative">
                                    <input type="text" id="customer-search" placeholder="Search customer..."
                                        value="{{ $transaction->customer->full_name }}"
                                        class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 placeholder-gray-500 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <select name="customer_id" id="customer_id" class="hidden">
                                        <option value="">Select Customer</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}"
                                                {{ old('customer_id', $transaction->customer_id) == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->full_name }} - {{ $customer->phone }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror

                                    <!-- Customer Dropdown -->
                                    <div id="customer-dropdown"
                                        class="absolute left-0 right-0 top-full z-10 mt-1 hidden max-h-60 overflow-y-auto rounded-lg border border-gray-200 bg-white shadow-xl">
                                        <div class="border-b border-gray-100 p-2">
                                            <div class="flex cursor-pointer items-center gap-2 rounded p-2 text-gray-600 hover:bg-gray-50"
                                                onclick="selectCustomer('', 'Select Customer')">
                                                <span>Select Customer</span>
                                            </div>
                                        </div>
                                        @foreach ($customers as $customer)
                                            <div class="p-2">
                                                <div class="flex cursor-pointer items-center gap-2 rounded p-2 text-gray-900 hover:bg-gray-50"
                                                    onclick="selectCustomer('{{ $customer->id }}', '{{ $customer->full_name }}')">
                                                    <span>{{ $customer->full_name }}</span>
                                                    <span class="text-sm text-gray-500">{{ $customer->phone }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Add Products Section -->
                            <div>
                                <div class="mb-4 flex items-center gap-2">
                                    <svg class="h-5 w-5 text-gray-700" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    <h2 class="text-xl font-bold text-gray-900">Add Products</h2>
                                </div>

                                <div class="relative">
                                    <input type="text" id="product-search" placeholder="Search products to add..."
                                        class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 placeholder-gray-500 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>

                                    <!-- Product Dropdown -->
                                    <div id="product-dropdown"
                                        class="absolute left-0 right-0 top-full z-10 mt-1 hidden max-h-60 overflow-y-auto rounded-lg border border-gray-200 bg-white shadow-xl">
                                        @if ($products->count() > 0)
                                            @foreach ($products as $product)
                                                <div class="p-2">
                                                    <div class="flex cursor-pointer items-center justify-between rounded p-3 text-gray-900 hover:bg-gray-50"
                                                        onclick="addProduct({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, {{ $product->stock }})">
                                                        <div>
                                                            <div class="font-medium">{{ $product->name }}</div>
                                                            <div class="text-sm text-gray-500">
                                                                Rp {{ number_format($product->price, 0, ',', '.') }} •
                                                                Stock: {{ $product->stock }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="p-4 text-center text-gray-500">No products available</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Selected Items Section -->
                            <div>
                                <div class="mb-4 flex items-center gap-2">
                                    <svg class="h-5 w-5 text-gray-700" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6.1">
                                        </path>
                                    </svg>
                                    <h2 class="text-xl font-bold text-gray-900">Selected Items (<span
                                            id="item-count">{{ $transaction->items->count() }}</span>)</h2>
                                </div>
                                <div id="selected-items" class="space-y-4">
                                    <!-- Existing items will be loaded here by JavaScript -->
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

                <!-- Right Column - Summary -->
                <div class="lg:col-span-1">
                    <div class="sticky top-8 rounded-xl bg-white p-6 shadow-lg">
                        <h2 class="mb-6 text-xl font-bold text-gray-900">Transaction Summary</h2>

                        <div class="mb-6 space-y-4">
                            <div class="flex justify-between text-gray-600">
                                <span>Items:</span>
                                <span id="summary-items">{{ $transaction->items->sum('quantity') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal:</span>
                                <span id="summary-subtotal">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-red-600">
                                <span>Discount (<span id="discount-percentage">{{ $transaction->subtotal > 0 ? round(($transaction->discount / $transaction->subtotal) * 100) : 0 }}</span>%):</span>
                                <span id="summary-discount">-Rp {{ number_format($transaction->discount, 0, ',', '.') }}</span>
                            </div>
                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-between text-xl font-bold">
                                    <span class="text-gray-900">Total:</span>
                                    <span class="text-green-600" id="summary-total">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <button type="submit" form="transactionForm"
                                class="flex w-full items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-3 font-medium text-white transition duration-200 hover:bg-blue-700 disabled:cursor-not-allowed disabled:bg-gray-400"
                                id="update-btn">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Update Transaction
                            </button>
                            <button type="button" onclick="window.location.href='{{ route('transactions.index') }}'"
                                class="w-full rounded-lg bg-gray-500 px-4 py-3 font-medium text-white transition duration-200 hover:bg-gray-600">
                                Cancel
                            </button>
                        </div>

                        <div class="mt-4 text-xs text-gray-500">
                            * Discount: 10% for purchases above Rp 500,000, 15% for purchases above Rp 1,000,000
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const products = @json($products);
        const customers = @json($customers);
        const existingTransaction = @json($transaction->load('items.product'));
        let selectedItems = [];
        let itemCounter = 0;

        // Initialize with existing transaction items
        function initializeExistingItems() {
            existingTransaction.items.forEach(item => {
                const newItem = {
                    id: item.product.id,
                    name: item.product.name,
                    price: item.product.price,
                    stock: item.product.stock + item.quantity, // Add back the quantity that was already used
                    quantity: item.quantity,
                    index: itemCounter++
                };
                selectedItems.push(newItem);
                addItemToDisplay(newItem);
            });
            updateSummary();
        }

        // Customer search functionality
        const customerSearch = document.getElementById('customer-search');
        const customerDropdown = document.getElementById('customer-dropdown');

        customerSearch.addEventListener('focus', () => {
            customerDropdown.classList.remove('hidden');
        });

        customerSearch.addEventListener('blur', (e) => {
            setTimeout(() => {
                customerDropdown.classList.add('hidden');
            }, 200);
        });

        customerSearch.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const customerOptions = customerDropdown.querySelectorAll('[onclick^="selectCustomer"]');

            customerOptions.forEach(option => {
                const text = option.textContent.toLowerCase();
                const parentDiv = option.closest('.p-2');
                if (parentDiv) {
                    parentDiv.style.display = text.includes(searchTerm) ? 'block' : 'none';
                }
            });
        });

        function selectCustomer(id, name) {
            customerSearch.value = name;
            document.getElementById('customer_id').value = id;
            customerDropdown.classList.add('hidden');
        }

        // Product search functionality
        const productSearch = document.getElementById('product-search');
        const productDropdown = document.getElementById('product-dropdown');

        productSearch.addEventListener('focus', () => {
            productDropdown.classList.remove('hidden');
        });

        productSearch.addEventListener('blur', (e) => {
            setTimeout(() => {
                productDropdown.classList.add('hidden');
            }, 200);
        });

        productSearch.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const productOptions = productDropdown.querySelectorAll('[onclick^="addProduct"]');

            productOptions.forEach(option => {
                const text = option.textContent.toLowerCase();
                const parentDiv = option.closest('.p-2');
                if (parentDiv) {
                    parentDiv.style.display = text.includes(searchTerm) ? 'block' : 'none';
                }
            });
        });

        function addProduct(id, name, price, stock) {
            // Check if product already selected
            const existingItem = selectedItems.find(item => item.id === id);
            if (existingItem) {
                if (existingItem.quantity < stock) {
                    existingItem.quantity++;
                    updateItemDisplay(existingItem);
                } else {
                    alert('Cannot add more items. Stock limit reached.');
                    return;
                }
            } else {
                const newItem = {
                    id: id,
                    name: name,
                    price: price,
                    stock: stock,
                    quantity: 1,
                    index: itemCounter++
                };
                selectedItems.push(newItem);
                addItemToDisplay(newItem);
            }

            productSearch.value = '';
            productDropdown.classList.add('hidden');
            updateSummary();
        }

        function addItemToDisplay(item) {
            const container = document.getElementById('selected-items');

            const itemDiv = document.createElement('div');
            itemDiv.className = 'rounded-lg bg-gray-50 border border-gray-200 p-4';
            itemDiv.id = `item-${item.index}`;
            itemDiv.innerHTML = `
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <h3 class="font-medium text-gray-900">${escapeHtml(item.name)}</h3>
                        <p class="text-sm text-gray-500">Rp ${formatNumber(item.price)} each • Stock: ${item.stock}</p>
                    </div>
                    <button type="button" onclick="removeItem(${item.index})"
                        class="ml-4 text-red-500 hover:text-red-600 transition duration-200">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
                <div class="mt-3 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="decreaseQuantity(${item.index})"
                            class="flex h-8 w-8 items-center justify-center rounded bg-gray-200 text-gray-700 hover:bg-gray-300 transition duration-200">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                            </svg>
                        </button>
                        <input type="text" value="${item.quantity}" readonly
                            class="w-12 text-center bg-white border border-gray-200 text-gray-900 rounded px-2 py-1 text-sm">
                        <button type="button" onclick="increaseQuantity(${item.index})"
                            class="flex h-8 w-8 items-center justify-center rounded bg-gray-200 text-gray-700 hover:bg-gray-300 transition duration-200">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="text-gray-900 font-medium" id="item-total-${item.index}">
                        Rp ${formatNumber(item.price * item.quantity)}
                    </div>
                </div>
                <input type="hidden" name="items[${item.index}][product_id]" value="${item.id}">
                <input type="hidden" name="items[${item.index}][quantity]" value="${item.quantity}">
            `;

            container.appendChild(itemDiv);
        }

        function updateItemDisplay(item) {
            const itemDiv = document.getElementById(`item-${item.index}`);
            const quantityInput = itemDiv.querySelector('input[type="text"]');
            const totalSpan = document.getElementById(`item-total-${item.index}`);
            const hiddenQuantity = itemDiv.querySelector('input[name$="[quantity]"]');

            quantityInput.value = item.quantity;
            hiddenQuantity.value = item.quantity;
            totalSpan.textContent = `Rp ${formatNumber(item.price * item.quantity)}`;
        }

        function increaseQuantity(index) {
            const item = selectedItems.find(item => item.index === index);
            if (item && item.quantity < item.stock) {
                item.quantity++;
                updateItemDisplay(item);
                updateSummary();
            } else if (item) {
                alert('Cannot add more items. Stock limit reached.');
            }
        }

        function decreaseQuantity(index) {
            const item = selectedItems.find(item => item.index === index);
            if (item && item.quantity > 1) {
                item.quantity--;
                updateItemDisplay(item);
                updateSummary();
            }
        }

        function removeItem(index) {
            selectedItems = selectedItems.filter(item => item.index !== index);
            const itemElement = document.getElementById(`item-${index}`);
            if (itemElement) {
                itemElement.remove();
            }

            // Show empty state if no items
            if (selectedItems.length === 0) {
                const container = document.getElementById('selected-items');
                container.innerHTML = `
                    <div class="text-center py-8 text-gray-500" id="empty-state">
                        <svg class="mx-auto h-12 w-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6.1"></path>
                        </svg>
                        <p>No products selected yet</p>
                    </div>
                `;
            }

            updateSummary();
        }

        function updateSummary() {
            let subtotal = 0;
            let totalItems = 0;

            selectedItems.forEach(item => {
                subtotal += item.price * item.quantity;
                totalItems += item.quantity;
            });

            let discount = 0;
            let discountPercentage = 0;
            if (subtotal > 1000000) {
                discount = subtotal * 0.15;
                discountPercentage = 15;
            } else if (subtotal > 500000) {
                discount = subtotal * 0.10;
                discountPercentage = 10;
            }

            const total = subtotal - discount;

            document.getElementById('item-count').textContent = selectedItems.length;
            document.getElementById('summary-items').textContent = totalItems;
            document.getElementById('summary-subtotal').textContent = `Rp ${formatNumber(subtotal)}`;
            document.getElementById('summary-discount').textContent = `-Rp ${formatNumber(discount)}`;
            document.getElementById('discount-percentage').textContent = discountPercentage;
            document.getElementById('summary-total').textContent = `Rp ${formatNumber(total)}`;

            // Enable/disable update button
            const updateBtn = document.getElementById('update-btn');
            updateBtn.disabled = selectedItems.length === 0;
        }

        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function(m) {
                return map[m];
            });
        }

        // Form validation
        document.getElementById('transactionForm').addEventListener('submit', function(e) {
            if (selectedItems.length === 0) {
                e.preventDefault();
                alert('Please add at least one item to the transaction.');
                return false;
            }

            // Validate stock for all items
            let hasStockError = false;
            selectedItems.forEach(item => {
                if (item.quantity > item.stock) {
                    hasStockError = true;
                    alert(`${item.name} quantity exceeds available stock (${item.stock})`);
                }
            });

            if (hasStockError) {
                e.preventDefault();
                return false;
            }
        });

        // Initialize the page with existing transaction data
        window.addEventListener('DOMContentLoaded', function() {
            initializeExistingItems();
        });
    </script>
</x-app-layout>
