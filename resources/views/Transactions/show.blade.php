<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="mx-auto max-w-4xl px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Transaction Details</h1>
                    <p class="mt-1 text-gray-600">Transaction ID: #{{ $transaction->id }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('transactions.edit', $transaction) }}"
                        class="flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 font-medium text-white transition duration-200 hover:bg-blue-700">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        Edit Transaction
                    </a>
                    <a href="{{ route('transactions.index') }}"
                        class="flex items-center gap-2 rounded-lg bg-gray-500 px-4 py-2 font-medium text-white transition duration-200 hover:bg-gray-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                        Back to Transactions
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                <!-- Left Column - Transaction Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Transaction Info Card -->
                    <div class="rounded-xl bg-white p-6 shadow-lg">
                        <div class="mb-4 flex items-center gap-2">
                            <svg class="h-5 w-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <h2 class="text-xl font-bold text-gray-900">Transaction Information</h2>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Transaction ID</label>
                                <p class="mt-1 text-gray-900 font-medium">#{{ $transaction->id }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Date & Time</label>
                                <p class="mt-1 text-gray-900">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Cashier</label>
                                <p class="mt-1 text-gray-900">{{ $transaction->user->name }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Status</label>
                                <span class="mt-1 inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                    Completed
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Info Card -->
                    <div class="rounded-xl bg-white p-6 shadow-lg">
                        <div class="mb-4 flex items-center gap-2">
                            <svg class="h-5 w-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                </path>
                            </svg>
                            <h2 class="text-xl font-bold text-gray-900">Customer Information</h2>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Full Name</label>
                                <p class="mt-1 text-gray-900 font-medium">{{ $transaction->customer->full_name }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Phone Number</label>
                                <p class="mt-1 text-gray-900">{{ $transaction->customer->phone }}</p>
                            </div>
                            @if($transaction->customer->email)
                            <div>
                                <label class="text-sm font-medium text-gray-500">Email</label>
                                <p class="mt-1 text-gray-900">{{ $transaction->customer->email }}</p>
                            </div>
                            @endif
                            @if($transaction->customer->address)
                            <div class="sm:col-span-2">
                                <label class="text-sm font-medium text-gray-500">Address</label>
                                <p class="mt-1 text-gray-900">{{ $transaction->customer->address }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Items Card -->
                    <div class="rounded-xl bg-white p-6 shadow-lg">
                        <div class="mb-6 flex items-center gap-2">
                            <svg class="h-5 w-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6.1">
                                </path>
                            </svg>
                            <h2 class="text-xl font-bold text-gray-900">Items ({{ $transaction->items->count() }})</h2>
                        </div>

                        <div class="overflow-hidden rounded-lg border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Product
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Price
                                        </th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Qty
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Subtotal
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($transaction->items as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-gray-900">{{ $item->product->name }}</div>
                                            @if($item->product->description)
                                            <div class="text-sm text-gray-500">{{ Str::limit($item->product->description, 50) }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right text-gray-900">
                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                                                {{ $item->quantity }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right font-medium text-gray-900">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Summary -->
                <div class="lg:col-span-1">
                    <div class="sticky top-8 rounded-xl bg-white p-6 shadow-lg">
                        <h2 class="mb-6 text-xl font-bold text-gray-900">Transaction Summary</h2>

                        <div class="space-y-4">
                            <div class="flex justify-between text-gray-600">
                                <span>Total Items:</span>
                                <span>{{ $transaction->items->sum('quantity') }}</span>
                            </div>

                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal:</span>
                                <span>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
                            </div>

                            @if($transaction->discount > 0)
                            <div class="flex justify-between text-red-600">
                                <span>Discount
                                    @if($transaction->subtotal > 1000000)
                                        (15%)
                                    @elseif($transaction->subtotal > 500000)
                                        (10%)
                                    @endif
                                    :
                                </span>
                                <span>-Rp {{ number_format($transaction->discount, 0, ',', '.') }}</span>
                            </div>
                            @endif

                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-between text-xl font-bold">
                                    <span class="text-gray-900">Total:</span>
                                    <span class="text-green-600">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Discount Info -->
                        <div class="mt-6 rounded-lg bg-blue-50 p-4">
                            <div class="flex items-start gap-2">
                                <svg class="mt-0.5 h-4 w-4 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                                <div class="text-xs text-blue-800">
                                    <p class="font-medium mb-1">Discount Policy:</p>
                                    <p>• 10% for purchases above Rp 500,000</p>
                                    <p>• 15% for purchases above Rp 1,000,000</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
