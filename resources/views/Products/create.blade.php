<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-lg sm:rounded-lg">

                <!-- Header -->
                <div class="bg-gray-800 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-white">Add New Product</h2>
                            <p class="text-sm text-gray-300">Create a new product for your inventory</p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <div class="p-6">
                    <form action="{{ route('products.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Product Code -->
                        <div>
                            <label for="product_code" class="mb-2 block text-sm font-medium text-gray-700">
                                Product Code <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-2">
                                <input type="text" name="product_code" id="product_code"
                                    value="{{ old('product_code') }}" required
                                    class="@error('product_code') border-red-500 @enderror flex-1 rounded-lg border px-4 py-3 outline-none transition duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                    placeholder="e.g., PRD001">
                                <button type="button" onclick="generateProductCode()"
                                    class="rounded-lg bg-blue-500 px-4 py-2 text-white transition hover:bg-blue-600">
                                    <svg class="h-8 w-8 text-neutral-50" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
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
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="@error('name') border-red-500 @enderror w-full rounded-lg border px-4 py-3 outline-none transition duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
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
                                value="{{ old('price') ? number_format(old('price'), 0, ',', '.') : '' }}"
                                class="@error('price') border-red-500 @enderror w-full rounded-lg border px-4 py-3 outline-none transition duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                placeholder="0" oninput="formatPrice(this)">
                            <input type="hidden" name="price" id="price" value="{{ old('price') }}" required>
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stock -->
                        <div>
                            <label for="stock" class="mb-2 block text-sm font-medium text-gray-700">
                                Stock <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="stock_display" id="stock_display" inputmode="numeric"
                                value="{{ old('stock') ? number_format(old('stock'), 0, ',', '.') : '' }}"
                                class="@error('stock') border-red-500 @enderror w-full rounded-lg border px-4 py-3 outline-none transition duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                placeholder="0" oninput="formatStock(this)">
                            <input type="hidden" name="stock" id="stock" value="{{ old('stock') }}" required>
                            @error('stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex gap-4 pt-4">
                            <button type="submit"
                                class="flex-1 rounded-lg bg-green-500 px-6 py-3 font-medium text-white transition duration-200 hover:bg-green-600 focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                Create Product
                            </button>
                            <a href="{{ route('products.index') }}"
                                class="flex-1 rounded-lg bg-gray-500 px-6 py-3 text-center font-medium text-white transition duration-200 hover:bg-gray-600">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Info Box -->
                <div class="px-6 pb-6">
                    <div class="rounded-lg border border-blue-200 bg-blue-50 p-4">
                        <h4 class="mb-2 text-sm font-medium text-blue-800">Tips:</h4>
                        <ul class="space-y-1 text-sm text-blue-700">
                            <li>• Product code must be unique</li>
                            <li>• Use descriptive names for better inventory management</li>
                            <li>• Set accurate stock levels for proper tracking</li>
                        </ul>
                    </div>
                </div>

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
    </script>
</x-app-layout>
