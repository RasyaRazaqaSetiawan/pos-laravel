<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-lg sm:rounded-lg">

                <!-- Header -->
                <div class="bg-gray-800 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-white">Transactions</h2>
                            <p class="text-sm text-gray-300">Manage your transactions</p>
                        </div>
                        <a href="{{ route('transactions.create') }}"
                            class="rounded-lg bg-green-500 px-4 py-2 font-medium text-white transition duration-200 hover:bg-green-600">
                            + New Transaction
                        </a>
                    </div>
                </div>

                <!-- Search Form -->
                <div class="border-b bg-gray-50 p-6">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <!-- Search Form -->
                        <form action="{{ route('transactions.index') }}" method="GET"
                            class="flex flex-1 items-center gap-3">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search by transaction ID, customer name, or cashier..."
                                class="flex-1 rounded-lg border border-gray-300 px-4 py-2 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                            <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                            <button type="submit"
                                class="rounded-lg bg-blue-500 px-6 py-2 font-medium text-white transition duration-200 hover:bg-blue-600">
                                Search
                            </button>
                            @if (request('search'))
                                <a href="{{ route('transactions.index', ['per_page' => request('per_page', 10)]) }}"
                                    class="rounded-lg bg-gray-500 px-4 py-2 text-white transition duration-200 hover:bg-gray-600">
                                    Clear
                                </a>
                            @endif
                        </form>
                    </div>
                </div>

                <!-- Alert Messages -->
                @if (session('success') || session('Success'))
                    <div
                        class="mb-4 flex items-center gap-2 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">{{ session('success') ?: session('Success') }}</span>
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

                @if ($errors->any())
                    <div
                        class="mb-4 flex items-center gap-2 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800">
                        <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">{{ $errors->first() }}</span>
                    </div>
                @endif

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="border-b-2 border-gray-200 bg-gray-100">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wide text-gray-700">
                                    ID</th>
                                <th
                                    class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wide text-gray-700">
                                    Date</th>
                                <th
                                    class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wide text-gray-700">
                                    Customer</th>
                                <th
                                    class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wide text-gray-700">
                                    Cashier</th>
                                <th
                                    class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wide text-gray-700">
                                    Items</th>
                                <th
                                    class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wide text-gray-700">
                                    Subtotal</th>
                                <th
                                    class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wide text-gray-700">
                                    Discount</th>
                                <th
                                    class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wide text-gray-700">
                                    Total</th>
                                <th
                                    class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wide text-gray-700">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse ($transactions as $transaction)
                                <tr class="transition duration-150 hover:bg-gray-50">
                                    <!-- ID -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 flex-shrink-0">
                                                <div
                                                    class="flex h-8 w-8 items-center justify-center rounded-full bg-purple-500">
                                                    <span class="text-sm font-medium text-white">
                                                        #{{ $transaction->id }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Date -->
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            {{ $transaction->created_at->format('d/m/Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $transaction->created_at->format('H:i') }}
                                        </div>
                                    </td>

                                    <!-- Customer -->
                                    <td class="px-6 py-4">
                                        <div class="text-sm">
                                            @if ($transaction->customer)
                                                <div class="font-medium text-gray-900">
                                                    {{ $transaction->customer->full_name }}</div>
                                                <div class="text-gray-500">{{ $transaction->customer->phone }}</div>
                                            @else
                                                <span
                                                    class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">
                                                    Walk-in Customer
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Cashier -->
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $transaction->user->name ?? 'N/A' }}
                                        </div>
                                    </td>

                                    <!-- Items -->
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            {{ $transaction->items->count() }} items
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            Total Qty: {{ $transaction->items->sum('quantity') }}
                                        </div>
                                    </td>

                                    <!-- Subtotal -->
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            Rp
                                            {{ number_format($transaction->total + $transaction->discount, 0, ',', '.') }}
                                        </div>
                                    </td>

                                    <!-- Discount -->
                                    <td class="px-6 py-4">
                                        <div class="text-sm">
                                            @if ($transaction->discount > 0)
                                                <div class="font-medium text-red-600">
                                                    -Rp {{ number_format($transaction->discount, 0, ',', '.') }}
                                                </div>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Total -->
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-green-900">
                                            Rp {{ number_format($transaction->total, 0, ',', '.') }}
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('transactions.show', $transaction->id) }}"
                                                class="flex items-center gap-1 rounded bg-blue-500 px-3 py-1 text-sm text-white transition duration-200 hover:bg-blue-600">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                                View
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-12 text-center">
                                        <div class="text-gray-500">
                                            @if (request('search'))
                                                <div class="mx-auto mb-4 h-16 w-16 text-gray-300">
                                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                    </svg>
                                                </div>
                                                <p class="mb-2 text-lg font-medium">No transactions found</p>
                                                <p>No transactions match your search for
                                                    "<strong>{{ request('search') }}</strong>"</p>
                                            @else
                                                <div class="mx-auto mb-4 h-16 w-16 text-gray-300">
                                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <p class="mb-2 text-lg font-medium">No transactions yet</p>
                                                <p class="mb-4">Get started by creating your first transaction</p>
                                                <a href="{{ route('transactions.create') }}"
                                                    class="inline-block rounded-lg bg-blue-500 px-6 py-2 text-white transition duration-200 hover:bg-blue-600">
                                                    Create Transaction
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
                @if ($transactions->hasPages())
                    <div class="flex flex-col items-center justify-between border-t bg-gray-50 px-6 py-4 sm:flex-row">
                        <!-- Results info -->
                        <div class="mb-3 text-sm text-gray-700 sm:mb-0">
                            Showing <span class="font-medium">{{ $transactions->firstItem() }}</span>
                            to <span class="font-medium">{{ $transactions->lastItem() }}</span>
                            of <span class="font-medium">{{ $transactions->total() }}</span> results
                        </div>

                        <!-- Pagination Links -->
                        <div class="flex items-center space-x-2">
                            {{-- Previous Page Link --}}
                            @if ($transactions->onFirstPage())
                                <span
                                    class="cursor-not-allowed rounded-md border border-gray-300 bg-gray-100 px-3 py-2 text-sm text-gray-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $transactions->appends(request()->query())->previousPageUrl() }}"
                                    class="rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </a>
                            @endif

                            {{-- Page Numbers --}}
                            @foreach ($transactions->appends(request()->query())->getUrlRange(1, $transactions->lastPage()) as $page => $url)
                                @if ($page == $transactions->currentPage())
                                    <span
                                        class="rounded-md bg-blue-500 px-3 py-2 text-sm font-medium text-white">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}"
                                        class="rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">{{ $page }}</a>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($transactions->hasMorePages())
                                <a href="{{ $transactions->appends(request()->query())->nextPageUrl() }}"
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
