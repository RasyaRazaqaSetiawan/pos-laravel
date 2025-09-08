<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-lg sm:rounded-lg">

                <!-- Header -->
                <div class="bg-gray-800 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-white">Edit Customer</h2>
                            <p class="text-sm text-gray-300">Update customer information</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="h-10 w-10 flex-shrink-0">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-500">
                                    <span class="text-lg font-medium text-white">
                                        {{ strtoupper(substr($customer->full_name, 0, 1)) }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-white">
                                <div class="text-sm font-medium">{{ $customer->full_name }}</div>
                                <div class="text-xs text-gray-300">ID: {{ $customer->id }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transaction Alert -->
                @if ($customer->transactions_count > 0)
                    <div class="border-l-4 border-yellow-400 bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    This customer has <strong>{{ $customer->transactions_count }}</strong>
                                    {{ Str::plural('transaction', $customer->transactions_count) }}.
                                    Be careful when modifying their information as it may affect transaction records.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Form -->
                <div class="p-6">
                    <form action="{{ route('customers.update', $customer->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Full Name -->
                        <div>
                            <label for="full_name" class="mb-2 block text-sm font-medium text-gray-700">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="full_name" id="full_name"
                                value="{{ old('full_name', $customer->full_name) }}" required
                                class="@error('full_name') border-red-500 @enderror w-full rounded-lg border border-gray-300 px-4 py-3 outline-none transition duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter customer full name">
                            @error('full_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="mb-2 block text-sm font-medium text-gray-700">
                                Email Address (Optional) <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" id="email"
                                value="{{ old('email', $customer->email) }}"
                                class="@error('email') border-red-500 @enderror w-full rounded-lg border border-gray-300 px-4 py-3 outline-none transition duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                placeholder="customer@example.com">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @if ($customer->email != old('email', $customer->email))
                                <p class="mt-1 text-xs text-orange-600">
                                    <strong>Original:</strong> {{ $customer->email }}
                                </p>
                            @endif
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="mb-2 block text-sm font-medium text-gray-700">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-2">
                                <input type="tel" name="phone" id="phone"
                                    value="{{ old('phone', $customer->phone) }}" required
                                    class="@error('phone') border-red-500 @enderror flex-1 rounded-lg border border-gray-300 px-4 py-3 outline-none transition duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                    placeholder="08xxxxxxxxxx" oninput="formatPhoneNumber(this)">
                            </div>
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @if ($customer->phone != old('phone', $customer->phone))
                                <p class="mt-1 text-xs text-orange-600">
                                    <strong>Original:</strong> {{ $customer->phone }}
                                </p>
                            @endif
                            <p class="mt-1 text-xs text-gray-500">Format: 08xxxxxxxxxx</p>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex gap-4 pt-4">
                            <button type="submit"
                                class="flex-1 rounded-lg bg-blue-500 px-6 py-3 font-medium text-white transition duration-200 hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Update Customer
                            </button>
                            <a href="{{ route('customers.index') }}"
                                class="flex-1 rounded-lg bg-gray-500 px-6 py-3 text-center font-medium text-white transition duration-200 hover:bg-gray-600">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Info Box -->
                <div class="px-6 pb-6">
                    <div class="rounded-lg border border-blue-200 bg-blue-50 p-4">
                        <h4 class="mb-2 text-sm font-medium text-blue-800">Important Notes:</h4>
                        <ul class="space-y-1 text-sm text-blue-700">
                            <li>• Changes to email may affect customer login credentials</li>
                            <li>• Phone number changes may impact communication</li>
                            <li>• Customer with transaction history cannot be deleted</li>
                            <li>• All changes will be logged for audit purposes</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function formatPhoneNumber(input) {
            // Remove all non-numeric characters except +
            let value = input.value.replace(/[^\d+]/g, '');

            // If starts with 0, keep it
            if (value.startsWith('0')) {
                input.value = value;
            }
            // If starts with +62, format it
            else if (value.startsWith('+62')) {
                input.value = value;
            }
            // If starts with 62, add +
            else if (value.startsWith('62')) {
                input.value = '+' + value;
            }
            // Otherwise, assume it's Indonesian number starting with 8
            else if (value.startsWith('8')) {
                input.value = '0' + value;
            } else {
                input.value = value;
            }
        }

        function clearPhone() {
            document.getElementById('phone').value = '';
        }

        // Show original values comparison
        function showOriginalValues() {
            const originalData = {
                full_name: '{{ $customer->full_name }}',
                email: '{{ $customer->email }}',
                phone: '{{ $customer->phone }}'
            };

            return originalData;
        }

        // Validate form before submission
        document.querySelector('form').addEventListener('submit', function(e) {
            const phone = document.getElementById('phone').value;
            const email = document.getElementById('email').value;

            // Basic phone validation
            if (phone && !phone.match(/^(\+62|0)[0-9]{8,12}$/)) {
                e.preventDefault();
                alert('Please enter a valid Indonesian phone number');
                return false;
            }

            // Confirm changes if customer has transactions
            @if ($customer->transactions_count > 0)
                if (!confirm(
                        'This customer has transaction history. Are you sure you want to update their information?'
                    )) {
                    e.preventDefault();
                    return false;
                }
            @endif
        });

        // Auto-focus on first input if there are validation errors
        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                const firstErrorInput = document.querySelector('.border-red-500');
                if (firstErrorInput) {
                    firstErrorInput.focus();
                }
            });
        @endif
    </script>
</x-app-layout>
