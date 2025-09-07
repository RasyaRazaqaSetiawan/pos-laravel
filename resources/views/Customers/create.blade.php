<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-lg sm:rounded-lg">

                <!-- Header -->
                <div class="bg-gray-800 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-white">Add New Customer</h2>
                            <p class="text-sm text-gray-300">Create a new customer for your database</p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <div class="p-6">
                    <form action="{{ route('customers.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Full Name -->
                        <div>
                            <label for="full_name" class="mb-2 block text-sm font-medium text-gray-700">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" required
                                class="@error('full_name') border-red-500 @enderror w-full rounded-lg border border-gray-300 px-4 py-3 outline-none transition duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter customer full name">
                            @error('full_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="mb-2 block text-sm font-medium text-gray-700">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                class="@error('email') border-red-500 @enderror w-full rounded-lg border border-gray-300 px-4 py-3 outline-none transition duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                placeholder="customer@example.com">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="mb-2 block text-sm font-medium text-gray-700">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-2">
                                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                                    class="@error('phone') border-red-500 @enderror flex-1 rounded-lg border border-gray-300 px-4 py-3 outline-none transition duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                    placeholder="08xxxxxxxxxx" oninput="formatPhoneNumber(this)">
                            </div>
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Format: 08xxxxxxxxxx</p>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex gap-4 pt-4">
                            <button type="submit"
                                class="flex-1 rounded-lg bg-green-500 px-6 py-3 font-medium text-white transition duration-200 hover:bg-green-600 focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                Create Customer
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
                        <h4 class="mb-2 text-sm font-medium text-blue-800">Tips:</h4>
                        <ul class="space-y-1 text-sm text-blue-700">
                            <li>• Email address must be unique for each customer</li>
                            <li>• Use complete names for better customer identification</li>
                            <li>• Ensure phone numbers are active for communication</li>
                            <li>• Double-check email format before saving</li>
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
            }
            else {
                input.value = value;
            }
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

            // Basic email validation
            if (email && !email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                e.preventDefault();
                alert('Please enter a valid email address');
                return false;
            }
        });
    </script>
</x-app-layout>
