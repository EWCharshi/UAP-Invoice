<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice {{ $invoice->invoice_number }} - United Airport Pickup</title>
    <link href="https://fonts.bunny.net/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        @page { size: A4; margin: 0; }
        body {
            font-family: 'Inter', sans-serif;
            font-size: 10px;
            color: #222;
            margin: 0;
            padding: 0;
            background: #fff;
        }
        .invoice-container {
            width: 700px;
            margin: 30px auto;
            background: #fff;
            /* border: 1px solid #e5e7eb; */
            /* border-radius: 8px; */
            /* box-shadow: 0 2px 8px rgba(0,0,0,0.04); */
            padding: 32px 40px 24px 40px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 18px;
            margin-bottom: 24px;
        }
        .company {
            display: flex;
            align-items: center;
        }
        .company-logo {
            height: 70px;
            width: auto;
            object-fit: contain;
            margin-right: 16px;
        }
        .company-details h1 {
            font-size: 1.2rem;
            font-weight: 700;
            margin: 0 0 2px 0;
        }
        .company-details p {
            margin: 0;
            font-size: 0.85rem;
            color: #555;
        }
        .invoice-details {
            text-align: right;
        }
        .invoice-details h2 {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0 0 6px 0;
        }
        .invoice-details table {
            font-size: 0.9rem;
        }
        .section {
            margin-bottom: 18px;
        }
        .section-title {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 6px;
            color: #222;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 2px 0;
            font-size: 0.92rem;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .items-table th, .items-table td {
            border: 1px solid #e5e7eb;
            padding: 8px 6px;
            font-size: 0.95rem;
        }
        .items-table th {
            background: #f3f4f6;
            font-weight: 600;
            text-align: left;
        }
        .items-table td.amount {
            text-align: right;
        }
        .summary-table {
            width: 260px;
            float: right;
            margin-top: 12px;
        }
        .summary-table td {
            padding: 6px 0;
            font-size: 1rem;
        }
        .summary-table .label {
            color: #555;
        }
        .summary-table .total-label {
            font-weight: 700;
            font-size: 1.08rem;
            color: #222;
        }
        .summary-table .total {
            font-weight: 700;
            font-size: 1.08rem;
            color: #222;
        }
        .clear { clear: both; }
        .notes, .payment-info {
            font-size: 0.93rem;
            color: #444;
            margin-top: 18px;
        }
        .status-paid { color: #16a34a; font-weight: 600; }
        .status-pending { color: #eab308; font-weight: 600; }
        .status-cancelled { color: #dc2626; font-weight: 600; }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <div class="company">
                <img src="{{ public_path('images/uap-logo.png') }}" alt="United Airport Pickup Logo" style="height:70px; width:auto; object-fit:contain; margin-right:1rem;">
                <div class="company-details">
                    <h1>United Airport Pickup</h1>
                    <p>Stockley Park, London</p>
                    <p>Phone: +44 7947 150607</p>
                    <p>Email: info@unitedairportpickup.co.uk</p>
                </div>
            </div>
            <div class="invoice-details">
                <h2>INVOICE</h2>
                <table>
                    <tr><td><strong>Invoice #:</strong></td><td>{{ $invoice->invoice_number }}</td></tr>
                    <tr><td><strong>Date:</strong></td><td>{{ $invoice->formatted_date }}</td></tr>
                    <tr><td><strong>Due Date:</strong></td><td>{{ $invoice->formatted_date }}</td></tr>
                </table>
            </div>
        </div>

        <div class="section">
            <table class="info-table">
                <tr>
                    <td style="width:50%; vertical-align:top;">
                        <div class="section-title">Bill To</div>
                        <div>
                            <strong>{{ $invoice->customer_name }}</strong><br>
                            {{ $invoice->customer_phone }}<br>
                            @if($invoice->customer_email)
                                {{ $invoice->customer_email }}<br>
                            @endif
                        </div>
                    </td>
                    <td style="width:50%; vertical-align:top;">
                        <div class="section-title">Trip Details</div>
                        <div>
                            <strong>From:</strong> {{ $invoice->pickup_location }}<br>
                            <strong>To:</strong> {{ $invoice->dropoff_location }}<br>
                            <strong>Date:</strong> {{ $invoice->formatted_date }}<br>
                            <strong>Time:</strong> {{ $invoice->formatted_time }}<br>
                            <strong>Vehicle:</strong> {{ ucfirst($invoice->vehicle_type) }}
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="section">
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th class="amount">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>Airport Transfer Service</strong><br>
                            {{ ucfirst($invoice->vehicle_type) }} • {{ $invoice->pickup_location }} → {{ $invoice->dropoff_location }}<br>
                            Date: {{ $invoice->formatted_date }} at {{ $invoice->formatted_time }}
                        </td>
                        <td class="amount">{{ $invoice->formatted_total }}</td>
                    </tr>
                    <tr>
                        <td>Base Fare<br><span style="color:#888;font-size:0.92em;">Standard pickup and drop-off service</span></td>
                        <td class="amount">£{{ number_format($invoice->base_fare, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Distance Fare<br><span style="color:#888;font-size:0.92em;">Additional charge for distance traveled</span></td>
                        <td class="amount">£{{ number_format($invoice->distance_fare, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <table class="summary-table">
            <tr>
                <td class="label">Subtotal:</td>
                <td style="text-align:right;">{{ $invoice->formatted_total }}</td>
            </tr>
            <tr>
                <td class="label">Tax (0%):</td>
                <td style="text-align:right;">£0.00</td>
            </tr>
            <tr>
                <td class="total-label">Total:</td>
                <td class="total" style="text-align:right;">{{ $invoice->formatted_total }}</td>
            </tr>
        </table>
        <div class="clear"></div>

        <div class="section payment-info">
            <div class="section-title">Payment Information</div>
            <div>
                <strong>Payment Method:</strong> {{ ucfirst($invoice->payment_method) }}<br>
                <strong>Status:</strong> 
                @if($invoice->status === 'paid')
                    <span class="status-paid">Paid</span>
                @elseif($invoice->status === 'pending')
                    <span class="status-pending">Pending</span>
                @else
                    <span class="status-cancelled">Cancelled</span>
                @endif
                <br>
                @if($invoice->paid_at)
                    <strong>Payment Date:</strong> {{ $invoice->paid_at->format('M d, Y') }}<br>
                @endif
            </div>
        </div>

        <div class="section notes">
            <div class="section-title">Notes</div>
            <div>
                Thank you for choosing United Airport Pickup!<br>
                For any questions, please contact us at +44 7947 150607
            </div>
        </div>
    </div>
</body>
</html> 