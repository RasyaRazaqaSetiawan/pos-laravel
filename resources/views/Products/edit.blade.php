<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-lg sm:rounded-lg">

                <!-- Header -->
                <div class="bg-gray-800 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-white">Edit Product</h2>
                            <p class="text-sm text-gray-300">Update product information</p>
                        </div>
                    </div>
                </div>

                <!-- Current Product Info -->
                <div class="border-b bg-gray-50 p-6">
                    <div class="flex items-center gap-4">
                        <div class="rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-800">
                            {{ $product->product_code }}
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-500">
                                Current Price: Rp {{ number_format($product->price, 0, ',', '.') }} |
                                Stock: {{ $product->stock }} units
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <div class="p-6">
                    <form action="{{ route('products.update', $product) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Product Code -->
                        <div>
                            <label for="product_code" class="mb-2 block text-sm font-medium text-gray-700">
                                Product Code <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center gap-2">
                                <input type="text" name="product_code" id="product_code"
                                    value="{{ old('product_code', $product->product_code) }}" required
                                    class="@error('product_code') border-red-500 @enderror flex-1 rounded-lg border border-gray-300 px-3 py-2 outline-none transition duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                    placeholder="e.g., PRD001">

                                <button type="button" onclick="generateProductCode()"
                                    class="flex items-center justify-center rounded-lg bg-blue-500 p-2 text-white transition hover:bg-blue-600">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -5v5h5" />
                                        <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 5v-5h-5" />
                                    </svg>
                                </button>
                            </div>
                            @error('product_code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Product Name -->
                        <div>
                            <label for="name" class="mb-2 block text-sm font-medium text-gray-700">
                                Product Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name"
                                value="{{ old('name', $product->name) }}" required
                                class="@error('name') border-red-500 @enderror w-full rounded-lg border border-gray-300 px-4 py-3 outline-none transition duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter product name">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="price" class="mb-2 block text-sm font-medium text-gray-700">
                                Price (Rp) <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="price_display" id="price_display" inputmode="numeric"
                                value="{{ old('price') ? number_format(old('price'), 0, ',', '.') : number_format($product->price, 0, ',', '.') }}"
                                class="@error('price') border-red-500 @enderror w-full rounded-lg border border-gray-300 px-4 py-3 outline-none transition duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                placeholder="0" oninput="formatPrice(this)">
                            <input type="hidden" name="price" id="price"
                                value="{{ old('price', $product->price) }}" required>
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stock -->
                        <div>
                            <label for="stock" class="mb-2 block text-sm font-medium text-gray-700">
                                Stock <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="stock" id="stock"
                                value="{{ old('stock', $product->stock) }}" required min="0"
                                class="@error('stock') border-red-500 @enderror w-full rounded-lg border border-gray-300 px-4 py-3 outline-none transition duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                placeholder="0">
                            @error('stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex gap-4 pt-4">
                            <button type="submit"
                                class="flex-1 rounded-lg bg-blue-500 px-6 py-3 font-medium text-white transition duration-200 hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Update Product
                            </button>
                            <a href="{{ route('products.index') }}"
                                class="flex-1 rounded-lg bg-gray-500 px-6 py-3 text-center font-medium text-white transition duration-200 hover:bg-gray-600">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Warning Box for Protected Products -->
                @if ($product->transaction_items_count > 0)
                    <div class="px-6 pb-6">
                        <div class="rounded-lg border border-yellow-200 bg-yellow-50 p-4">
                            <h4 class="mb-2 text-sm font-medium text-yellow-800">⚠️ Protected Product</h4>
                            <p class="text-sm text-yellow-700">
                                This product has been used in {{ $product->transaction_items_count }} transaction(s).
                                Be careful when updating the price as it might affect your reports.
                            </p>
                        </div>
                    </div>
                @else
                    <div class="px-6 pb-6">
                        <div class="rounded-lg border border-blue-200 bg-blue-50 p-4">
                            <h4 class="mb-2 text-sm font-medium text-blue-800">Tips:</h4>
                            <ul class="space-y-1 text-sm text-blue-700">
                                <li>• Product code must remain unique</li>
                                <li>• Price changes won't affect past transactions</li>
                                <li>• Stock adjustments will be reflected immediately</li>
                            </ul>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <script>
        function formatPrice(input) {
            let value = input.value.replace(/[^\d]/g, '');
            input.value = value ? parseInt(value).toLocaleString('id-ID') : '';
            document.getElementById('price').value = value;
        }

        function formatStock(input) {
            let value = input.value.replace(/[^\d]/g, '');
            input.value = value ? parseInt(value).toLocaleString('id-ID') : '';
            document.getElementById('stock').value = value;
        }

        function generateProductCode() {
            const timestamp = Date.now();
            const randomNum = Math.floor(Math.random() * 1000);
            const codeNumber = String(timestamp).slice(-2) + String(randomNum).slice(-1);
            const productCode = 'PRD' + codeNumber.padStart(2, '0');
            document.getElementById('product_code').value = productCode;
        }

        // Confirm before leaving if form has changes
        let formChanged = false;
        const form = document.querySelector('form');
        const inputs = form.querySelectorAll('input[type="text"], input[type="hidden"]');

        // Store original values
        const originalValues = {};
        inputs.forEach(input => {
            originalValues[input.name] = input.value;
        });

        // Track changes
        inputs.forEach(input => {
            input.addEventListener('input', () => {
                formChanged = input.value !== originalValues[input.name];
            });
        });

        // Warn before leaving if changes made
        window.addEventListener('beforeunload', (e) => {
            if (formChanged) {
                e.preventDefault();
                e.returnValue = '';
            }
        });

        // Don't warn when submitting form
        form.addEventListener('submit', () => {
            formChanged = false;
        });
    </script>
</x-app-layout>
