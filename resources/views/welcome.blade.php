<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>United Airport Pickup - Invoice Generator</title>
    
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="bg-gray-300 shadow-sm border-b border-gray-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <img src="{{ asset('images/uap-logo.png') }}" alt="United Airport Pickup Logo" class="w-40 h-40 object-contain">
                    <h1 class="ml-3 text-xl font-semibold text-gray-900">United Airport Pickup</h1>
                </div>
                <nav class="flex items-center space-x-8">
                    <a href="/" class="text-gray-900 font-medium whitespace-nowrap">Invoice Generator</a>
                    <a href="/dashboard" class="text-gray-500 hover:text-gray-900 whitespace-nowrap">Dashboard</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Page Title -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Generate Invoice</h2>
            <p class="text-gray-600">Create professional invoices for completed trips</p>
        </div>

        <!-- Invoice Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-8">
                <form action="{{ route('invoices.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Excel Import Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Import Data from Excel</h3>
                        <div class="bg-gray-50 rounded-xl p-6 border-2 border-dashed border-gray-300">
                            <div class="text-center">
                                <div class="mb-4">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <div class="mb-4">
                                    <label for="excel_file" class="cursor-pointer bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors duration-200">
                                        Choose Excel File
                                    </label>
                                    <input type="file" id="excel_file" name="excel_file" accept=".xlsx,.xls,.csv" class="hidden">
                                </div>
                                <p class="text-sm text-gray-600 mb-4">
                                    Upload an Excel file with customer and location data. Supported formats: .xlsx, .xls, .csv
                                </p>
                                <div id="file-info" class="hidden text-sm text-gray-600 mb-4"></div>
                                <button type="button" id="import-btn" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors duration-200 hidden">
                                    Import Data
                                </button>
                                <div id="import-status" class="mt-4"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Trip Details Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Trip Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="pickup_location" class="block text-sm font-medium text-gray-700 mb-2">
                                    Pickup Location
                                </label>
                                <div class="relative">
                                    <input type="text" id="pickup_location" name="pickup_location" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent transition-all duration-200 focus:outline-none"
                                        placeholder="e.g., Airport Terminal 1" list="pickup_locations_list" autocomplete="off">
                                    <datalist id="pickup_locations_list">
                                        <!-- Options will be populated by JavaScript -->
                                    </datalist>
                                </div>
                            </div>
                            <div>
                                <label for="dropoff_location" class="block text-sm font-medium text-gray-700 mb-2">
                                    Drop-off Location
                                </label>
                                <input type="text" id="dropoff_location" name="dropoff_location" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent transition-all duration-200 focus:outline-none"
                                    placeholder="e.g., Downtown Hotel">
                            </div>
                        </div>
                    </div>

                    <!-- Customer Details Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Customer Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Customer Name
                                </label>
                                <div class="relative">
                                    <input type="text" id="customer_name" name="customer_name" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent transition-all duration-200 focus:outline-none"
                                        placeholder="Full name" list="customer_names_list" autocomplete="off">
                                    <datalist id="customer_names_list">
                                        <!-- Options will be populated by JavaScript -->
                                    </datalist>
                                </div>
                            </div>
                            <div>
                                <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Phone Number
                                </label>
                                <input type="tel" id="customer_phone" name="customer_phone" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent transition-all duration-200 focus:outline-none"
                                    placeholder="+44 7947 150607">
                            </div>
                        </div>
                        <div class="mt-6">
                            <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email (Optional)
                            </label>
                            <input type="email" id="customer_email" name="customer_email"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent focus:outline-none transition-all duration-200"
                                placeholder="customer@email.com">
                        </div>
                    </div>

                    <!-- Trip Information Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Trip Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="trip_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    Trip Date
                                </label>
                                <input type="date" id="trip_date" name="trip_date" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent transition-all duration-200 focus:outline-none">
                            </div>
                            <div>
                                <label for="trip_time" class="block text-sm font-medium text-gray-700 mb-2">
                                    Trip Time
                                </label>
                                <input type="time" id="trip_time" name="trip_time" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent focus:outline-none transition-all duration-200">
                            </div>
                            <div>
                                <label for="vehicle_type" class="block text-sm font-medium text-gray-700 mb-2">
                                    Vehicle Type
                                </label>
                                <select id="vehicle_type" name="vehicle_type" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent focus:outline-none transition-all duration-200">
                                    <option value="">Select vehicle</option>
                                    <option value="sedan">Sedan</option>
                                    <option value="suv">SUV</option>
                                    <option value="van">Van</option>
                                    <option value="luxury">Luxury</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Pricing</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="base_fare" class="block text-sm font-medium text-gray-700 mb-2">
                                    Base Fare (£)
                                </label>
                                <input type="number" id="base_fare" name="base_fare" step="0.01" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent focus:outline-none transition-all duration-200"
                                    placeholder="0.00">
                            </div>
                            <div>
                                <label for="distance_fare" class="block text-sm font-medium text-gray-700 mb-2">
                                    Distance Fare (£)
                                </label>
                                <input type="number" id="distance_fare" name="distance_fare" step="0.01" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent focus:outline-none transition-all duration-200"
                                    placeholder="0.00">
                            </div>
                            <div>
                                <label for="total_amount" class="block text-sm font-medium text-gray-700 mb-2">
                                    Total Amount (£)
                                </label>
                                <input type="number" id="total_amount" name="total_amount" step="0.01" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent focus:outline-none transition-all duration-200 bg-gray-50"
                                    placeholder="0.00" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Status -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                                    Payment Method
                                </label>
                                <select id="payment_method" name="payment_method" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent focus:outline-none transition-all duration-200">
                                    <option value="cash">Cash</option>
                                    <option value="card">Card</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="paypal">PayPal</option>
                                </select>
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                    Payment Status
                                </label>
                                <select id="status" name="status" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent focus:outline-none transition-all duration-200">
                                    <option value="pending">Pending</option>
                                    <option value="paid">Paid</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Additional Notes
                        </label>
                        <textarea id="notes" name="notes" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-transparent focus:outline-none transition-all duration-200"
                            placeholder="Any additional information about the trip..."></textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6">
                        <button type="submit" 
                            class="flex-1 bg-black text-white px-6 py-3 rounded-xl font-semibold hover:bg-gray-800 transition-all duration-200 focus:ring-2 focus:ring-black focus:ring-offset-2">
                            Generate Invoice
                        </button>
                        <a href="/invoice-preview" 
                            class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-200 transition-all duration-200 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 text-center">
                            Preview Invoice
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        // Global variables
        let locations = [];
        let customers = [];

        // Auto-calculate total amount
        document.getElementById('base_fare').addEventListener('input', calculateTotal);
        document.getElementById('distance_fare').addEventListener('input', calculateTotal);

        function calculateTotal() {
            const baseFare = parseFloat(document.getElementById('base_fare').value) || 0;
            const distanceFare = parseFloat(document.getElementById('distance_fare').value) || 0;
            const total = baseFare + distanceFare;
            document.getElementById('total_amount').value = total.toFixed(2);
        }

        // Excel file handling
        document.getElementById('excel_file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                document.getElementById('file-info').textContent = `Selected: ${file.name} (${(file.size / 1024).toFixed(1)} KB)`;
                document.getElementById('file-info').classList.remove('hidden');
                document.getElementById('import-btn').classList.remove('hidden');
            }
        });

        // Import button click handler
        document.getElementById('import-btn').addEventListener('click', function() {
            const fileInput = document.getElementById('excel_file');
            const file = fileInput.files[0];
            
            if (!file) {
                showImportStatus('Please select a file first.', 'error');
                return;
            }

            const formData = new FormData();
            formData.append('excel_file', file);
            formData.append('_token', document.querySelector('input[name="_token"]').value);

            // Show loading state
            showImportStatus('Importing data...', 'loading');
            document.getElementById('import-btn').disabled = true;

            fetch('{{ route("excel.import") }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showImportStatus(data.message, 'success');
                    
                    // Store the imported data
                    locations = data.locations || [];
                    customers = data.customers || [];
                    
                    // Populate dropdowns
                    populateLocationDropdown();
                    populateCustomerDropdown();
                    
                    // Clear file input
                    fileInput.value = '';
                    document.getElementById('file-info').classList.add('hidden');
                    document.getElementById('import-btn').classList.add('hidden');
                } else {
                    showImportStatus(data.message, 'error');
                }
            })
            .catch(error => {
                showImportStatus('Error importing file: ' + error.message, 'error');
            })
            .finally(() => {
                document.getElementById('import-btn').disabled = false;
            });
        });



        // Populate location dropdown
        function populateLocationDropdown() {
            const datalist = document.getElementById('pickup_locations_list');
            datalist.innerHTML = '';
            
            locations.forEach(location => {
                const option = document.createElement('option');
                option.value = location.name;
                option.textContent = location.name + (location.city ? ` (${location.city})` : '');
                datalist.appendChild(option);
            });
        }

        // Populate customer dropdown
        function populateCustomerDropdown() {
            const datalist = document.getElementById('customer_names_list');
            datalist.innerHTML = '';
            
            customers.forEach(customer => {
                const option = document.createElement('option');
                option.value = customer.name;
                option.textContent = customer.name + (customer.company ? ` - ${customer.company}` : '');
                datalist.appendChild(option);
            });
        }

        // Show import status
        function showImportStatus(message, type) {
            const statusDiv = document.getElementById('import-status');
            const colors = {
                success: 'text-green-600',
                error: 'text-red-600',
                loading: 'text-blue-600'
            };
            
            statusDiv.innerHTML = `<p class="${colors[type]} font-medium">${message}</p>`;
            statusDiv.classList.remove('hidden');
        }

        // Auto-fill customer details when customer name is selected
        document.getElementById('customer_name').addEventListener('input', function(e) {
            const selectedCustomer = customers.find(customer => customer.name === e.target.value);
            if (selectedCustomer) {
                document.getElementById('customer_phone').value = selectedCustomer.phone || '';
                document.getElementById('customer_email').value = selectedCustomer.email || '';
            }
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Page is ready, Excel import functionality is available
        });
    </script>
</body>
</html>
