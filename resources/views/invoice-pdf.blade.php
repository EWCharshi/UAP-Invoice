<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice {{ $invoice->invoice_number }} - United Airport Pickup</title>
    
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9fafb;
            color: #111827;
        }
        .bg-gray-50 { background-color: #f9fafb; }
        .bg-white { background-color: #ffffff; }
        .bg-gray-300 { background-color: #d1d5db; }
        .bg-gray-100 { background-color: #f3f4f6; }
        .text-gray-900 { color: #111827; }
        .text-gray-600 { color: #4b5563; }
        .text-gray-700 { color: #374151; }
        .text-green-600 { color: #059669; }
        .text-yellow-600 { color: #d97706; }
        .text-red-600 { color: #dc2626; }
        .border-gray-200 { border-color: #e5e7eb; }
        .border-gray-100 { border-color: #f3f4f6; }
        .rounded-2xl { border-radius: 1rem; }
        .shadow-sm { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
        .overflow-hidden { overflow: hidden; }
        .px-8 { padding-left: 2rem; padding-right: 2rem; }
        .py-6 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
        .py-4 { padding-top: 1rem; padding-bottom: 1rem; }
        .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
        .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mb-3 { margin-bottom: 0.75rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mr-4 { margin-right: 1rem; }
        .w-full { width: 100%; }
        .w-64 { width: 16rem; }
        .w-32 { width: 8rem; }
        .h-28 { height: 7rem; }
        .text-2xl { font-size: 1.5rem; line-height: 2rem; }
        .text-3xl { font-size: 1.875rem; line-height: 2.25rem; }
        .text-lg { font-size: 1.125rem; line-height: 1.75rem; }
        .text-sm { font-size: 0.875rem; line-height: 1.25rem; }
        .font-bold { font-weight: 700; }
        .font-semibold { font-weight: 600; }
        .font-medium { font-weight: 500; }
        .flex { display: flex; }
        .grid { display: grid; }
        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .gap-8 { gap: 2rem; }
        .items-center { align-items: center; }
        .items-start { align-items: flex-start; }
        .justify-between { justify-content: space-between; }
        .justify-end { justify-content: flex-end; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .border-b { border-bottom-width: 1px; }
        .border-t { border-top-width: 1px; }
        .border { border-width: 1px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 0.75rem 0; }
        .object-contain { object-fit: contain; }
        .rounded-xl { border-radius: 0.75rem; }
        .bg-gray-200 { background-color: #e5e7eb; }
        .flex { display: flex; }
        .items-center { align-items: center; }
        .justify-center { justify-content: center; }
        .text-gray-600 { color: #4b5563; }
        .font-bold { font-weight: 700; }
        .text-lg { font-size: 1.125rem; line-height: 1.75rem; }
        
        @media print {
            body { margin: 0; }
            .page-break { page-break-before: always; }
        }
        
        /* Responsive grid for PDF */
        @media (max-width: 768px) {
            .grid-cols-2 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div style="max-width: 64rem; margin: 0 auto; padding: 2rem 1rem;">
        <!-- Invoice Preview -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Invoice Header -->
            <div class="px-8 py-6 border-b border-gray-200 bg-gray-300">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="flex items-center mb-4">
                            <img src="{{ public_path('images/uap-logo.png') }}" alt="United Airport Pickup Logo" class="w-32 h-28 object-contain mr-4">
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
                            <p>For any questions, please contact us at +44 7947 150607</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 