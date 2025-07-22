<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice Preview - United Airport Pickup</title>
    
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
                    <a href="/" class="text-gray-500 hover:text-gray-900 whitespace-nowrap">Invoice Generator</a>
                    <a href="/dashboard" class="text-gray-500 hover:text-gray-900 whitespace-nowrap">Dashboard</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Page Title -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Invoice Preview</h2>
            <p class="text-gray-600">Preview your invoice before generating</p>
        </div>

        <!-- Invoice Preview -->
        <div class="bg-white overflow-hidden">
            <!-- Invoice Header -->
            <div class="px-8 py-6 border-b border-gray-200">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="flex items-center mb-4">
                            <img src="{{ asset('images/uap-logo.png') }}" alt="United Airport Pickup Logo" style="height:70px; width:auto; object-fit:contain; margin-right:1rem;">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">United Airport Pickup</h1>
                                <p class="text-gray-600">Professional Airport Transportation</p>
                            </div>
                        </div>
                        <div class="text-sm text-gray-600">
                            <p>Stockley Park, London</p>
                            <p>United Kingdom</p>
                            <p>Phone: +44 7947 150607</p>
                            <p>Email: info@unitedairportpickup.co.uk</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">INVOICE</h2>
                        <div class="text-sm text-gray-600">
                            <p><strong>Invoice #:</strong> {{ $invoice->invoice_number }}</p>
                            <p><strong>Date:</strong> {{ $invoice->formatted_date }}</p>
                            <p><strong>Due Date:</strong> {{ $invoice->formatted_date }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="px-8 py-6 border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Bill To:</h3>
                        <div class="text-gray-700">
                            <p class="font-medium">{{ $invoice->customer_name }}</p>
                            <p>{{ $invoice->customer_phone }}</p>
                            @if($invoice->customer_email)
                                <p>{{ $invoice->customer_email }}</p>
                            @endif
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Trip Details:</h3>
                        <div class="text-gray-700">
                            <p><strong>From:</strong> {{ $invoice->pickup_location }}</p>
                            <p><strong>To:</strong> {{ $invoice->dropoff_location }}</p>
                            <p><strong>Date:</strong> {{ $invoice->formatted_date }}</p>
                            <p><strong>Time:</strong> {{ $invoice->formatted_time }}</p>
                            <p><strong>Vehicle:</strong> {{ ucfirst($invoice->vehicle_type) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoice Items -->
            <div class="px-8 py-6">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-3 text-sm font-semibold text-gray-900">Description</th>
                            <th class="text-right py-3 text-sm font-semibold text-gray-900">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-100">
                            <td class="py-4">
                                <div>
                                    <p class="font-medium text-gray-900">Airport Transfer Service</p>
                                    <p class="text-sm text-gray-600">{{ ucfirst($invoice->vehicle_type) }} • {{ $invoice->pickup_location }} → {{ $invoice->dropoff_location }}</p>
                                    <p class="text-sm text-gray-600">Date: {{ $invoice->formatted_date }} at {{ $invoice->formatted_time }}</p>
                                </div>
                            </td>
                            <td class="py-4 text-right">
                                <p class="font-semibold text-gray-900">{{ $invoice->formatted_total }}</p>
                            </td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <td class="py-4">
                                <div>
                                    <p class="font-medium text-gray-900">Base Fare</p>
                                    <p class="text-sm text-gray-600">Standard pickup and drop-off service</p>
                                </div>
                            </td>
                            <td class="py-4 text-right">
                                <p class="font-semibold text-gray-900">£{{ number_format($invoice->base_fare, 2) }}</p>
                            </td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <td class="py-4">
                                <div>
                                    <p class="font-medium text-gray-900">Distance Fare</p>
                                    <p class="text-sm text-gray-600">Additional charge for distance traveled</p>
                                </div>
                            </td>
                            <td class="py-4 text-right">
                                <p class="font-semibold text-gray-900">£{{ number_format($invoice->distance_fare, 2) }}</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Invoice Summary -->
            <div class="px-8 py-6 bg-gray-100">
                <div class="flex justify-end">
                    <div class="w-64">
                        <div class="flex justify-between py-2">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="font-semibold">{{ $invoice->formatted_total }}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-gray-600">Tax (0%):</span>
                            <span class="font-semibold">£0.00</span>
                        </div>
                        <div class="flex justify-between py-2 border-t border-gray-200 pt-2">
                            <span class="text-lg font-semibold text-gray-900">Total:</span>
                            <span class="text-lg font-bold text-gray-900">{{ $invoice->formatted_total }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="px-8 py-6 border-t border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Payment Information:</h3>
                        <div class="text-sm text-gray-600">
                            <p><strong>Payment Method:</strong> {{ ucfirst($invoice->payment_method) }}</p>
                            <p><strong>Status:</strong> 
                                @if($invoice->status === 'paid')
                                    <span class="text-green-600 font-semibold">Paid</span>
                                @elseif($invoice->status === 'pending')
                                    <span class="text-yellow-600 font-semibold">Pending</span>
                                @else
                                    <span class="text-red-600 font-semibold">Cancelled</span>
                                @endif
                            </p>
                            @if($invoice->paid_at)
                                <p><strong>Payment Date:</strong> {{ $invoice->paid_at->format('M d, Y') }}</p>
                            @endif
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Notes:</h3>
                        <div class="text-sm text-gray-600">
                            <p>Thank you for choosing United Airport Pickup!</p>
                            <p>For any questions, please contact us at (555) 123-4567</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex flex-col sm:flex-row gap-4">
            <a href="{{ route('invoices.download', $invoice) }}" class="flex-1 bg-black text-white px-6 py-3 rounded-xl font-semibold hover:bg-gray-800 transition-all duration-200 text-center">
                Download PDF
            </a>
            <a href="{{ route('invoices.share', $invoice) }}" class="flex-1 bg-green-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-green-700 transition-all duration-200 text-center">
                Share via WhatsApp
            </a>
            <a href="{{ route('home') }}" class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-200 transition-all duration-200 text-center">
                Back to Generator
            </a>
        </div>
    </main>

    <script>
        // Add interactivity for the invoice preview
        document.addEventListener('DOMContentLoaded', function() {
            // Download PDF functionality
            const downloadBtn = document.querySelector('button:contains("Download PDF")');
            if (downloadBtn) {
                downloadBtn.addEventListener('click', function() {
                    // PDF generation logic would be implemented here
                    alert('PDF download feature will be implemented in the backend');
                });
            }

            // WhatsApp sharing functionality
            const whatsappBtn = document.querySelector('button:contains("Share via WhatsApp")');
            if (whatsappBtn) {
                whatsappBtn.addEventListener('click', function() {
                    // WhatsApp sharing logic would be implemented here
                    alert('WhatsApp sharing feature will be implemented in the backend');
                });
            }
        });
    </script>
</body>
</html> 