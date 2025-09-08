<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-lg sm:rounded-lg">

                <!-- Header -->
                <div class="bg-gray-800 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-white">Products</h2>
                            <p class="text-sm text-gray-300">Manage your inventory</p>
                        </div>
                        <a href="{{ route('products.create') }}"
                            class="rounded-lg bg-green-500 px-4 py-2 font-medium text-white transition duration-200 hover:bg-green-600">
                            + Add Product
                        </a>
                    </div>
                </div>

                <!-- Search Form and Per Page Selector -->
                <div class="border-b bg-gray-50 p-6">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <!-- Search Form -->
                        <form action="{{ route('products.index') }}" method="GET"
                            class="flex flex-1 items-center gap-3">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search products..."
                                class="flex-1 rounded-lg border border-gray-300 px-4 py-2 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                            <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                            <button type="submit"
                                class="rounded-lg bg-blue-500 px-6 py-2 font-medium text-white transition duration-200 hover:bg-blue-600">
                                Search
                            </button>
                            @if (request('search'))
                                <a href="{{ route('products.index', ['per_page' => request('per_page', 10)]) }}"
                                    class="rounded-lg bg-gray-500 px-4 py-2 text-white transition duration-200 hover:bg-gray-600">
                                    Clear
                                </a>
                            @endif
                        </form>
                    </div>
                </div>

                <!-- Alert Messages -->
                @if (session('success'))
                    <div
                        class="mb-4 flex items-center gap-2 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div
                        class="mb-4 flex items-center gap-2 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800">
                        <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="border-b-2 border-gray-200 bg-gray-100">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wide text-gray-700">
                                    Code</th>
                                <th
                                    class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wide text-gray-700">
                                    Name</th>
                                <th
                                    class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wide text-gray-700">
                                    Price</th>
                                <th
                                    class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wide text-gray-700">
                                    Stock</th>
                                <th
                                    class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wide text-gray-700">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($products as $product)
                                <tr class="transition duration-150 hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-block rounded bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-800">
                                            {{ $product->product_code }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-semibold text-green-600">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="{{ $product->stock > 10 ? 'bg-green-100 text-green-800' : ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }} inline-flex items-center rounded-full px-3 py-1 text-xs font-medium">
                                            {{ $product->stock }} units
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('products.edit', $product->id) }}"
                                                class="flex items-center gap-1 rounded bg-blue-500 px-3 py-1 text-sm text-white transition duration-200 hover:bg-blue-600">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                                Edit
                                            </a>

                                            @if ($product->transaction_items_count == 0)
                                                <form action="{{ route('products.destroy', $product->id) }}"
                                                    method="POST" onsubmit="return confirm('Are you sure?')"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="flex items-center gap-1 rounded bg-red-500 px-3 py-1 text-sm text-white transition duration-200 hover:bg-red-600">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="text-gray-500">
                                            @if (request('search'))
                                                <div class="mx-auto mb-4 h-16 w-16 text-gray-300">
                                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                    </svg>
                                                </div>
                                                <p class="mb-2 text-lg font-medium">No products found</p>
                                                <p>No products match your search for
                                                    "<strong>{{ request('search') }}</strong>"</p>
                                            @else
                                                <div class="mx-auto mb-4 h-16 w-16 text-gray-300">
                                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <p class="mb-2 text-lg font-medium">No products yet</p>
                                                <p class="mb-4">Get started by adding your first product</p>
                                                <a href="{{ route('products.create') }}"
                                                    class="inline-block rounded-lg bg-blue-500 px-6 py-2 text-white transition duration-200 hover:bg-blue-600">
                                                    Add Product
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Enhanced Pagination -->
                @if ($products->hasPages())
                    <div class="flex flex-col items-center justify-between border-t bg-gray-50 px-6 py-4 sm:flex-row">
                        <!-- Results info -->
                        <div class="mb-3 text-sm text-gray-700 sm:mb-0">
                            Showing <span class="font-medium">{{ $products->firstItem() }}</span>
                            to <span class="font-medium">{{ $products->lastItem() }}</span>
                            of <span class="font-medium">{{ $products->total() }}</span> results
                        </div>

                        <!-- Pagination Links -->
                        <div class="flex items-center space-x-2">
                            {{-- Previous Page Link --}}
                            @if ($products->onFirstPage())
                                <span
                                    class="cursor-not-allowed rounded-md border border-gray-300 bg-gray-100 px-3 py-2 text-sm text-gray-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $products->appends(request()->query())->previousPageUrl() }}"
                                    class="rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </a>
                            @endif

                            {{-- Page Numbers --}}
                            @foreach ($products->appends(request()->query())->getUrlRange(1, $products->lastPage()) as $page => $url)
                                @if ($page == $products->currentPage())
                                    <span
                                        class="rounded-md bg-blue-500 px-3 py-2 text-sm font-medium text-white">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}"
                                        class="rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">{{ $page }}</a>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($products->hasMorePages())
                                <a href="{{ $products->appends(request()->query())->nextPageUrl() }}"
                                    class="rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @else
                                <span
                                    class="cursor-not-allowed rounded-md border border-gray-300 bg-gray-100 px-3 py-2 text-sm text-gray-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </span>
                            @endif
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <!-- JavaScript for Per Page Selector -->
    <script>
        function changePerPage(perPage) {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', perPage);
            url.searchParams.delete('page'); // Reset to first page when changing per_page
            window.location.href = url.toString();
        }
    </script>
</x-app-layout>
