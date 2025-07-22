<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::latest()->paginate(10);
        $stats = [
            'total' => Invoice::count(),
            'total_revenue' => Invoice::sum('total_amount'),
            'this_month' => Invoice::whereMonth('created_at', now()->month)->count(),
            'avg_amount' => Invoice::avg('total_amount') ?? 0,
        ];
        
        return view('dashboard', compact('invoices', 'stats'));
    }

    public function create()
    {
        return view('welcome');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'pickup_location' => 'required|string|max:255',
            'dropoff_location' => 'required|string|max:255',
            'trip_date' => 'required|date',
            'trip_time' => 'required',
            'vehicle_type' => 'required|string|max:50',
            'base_fare' => 'required|numeric|min:0',
            'distance_fare' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:50',
            'status' => 'required|in:pending,paid',
            'notes' => 'nullable|string',
        ]);

        $invoice = Invoice::create([
            'invoice_number' => 'INV-' . strtoupper(Str::random(6)),
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'pickup_location' => $request->pickup_location,
            'dropoff_location' => $request->dropoff_location,
            'trip_date' => $request->trip_date,
            'trip_time' => $request->trip_time,
            'vehicle_type' => $request->vehicle_type,
            'base_fare' => $request->base_fare,
            'distance_fare' => $request->distance_fare,
            'total_amount' => $request->total_amount,
            'payment_method' => $request->payment_method,
            'status' => $request->status,
            'notes' => $request->notes,
            'paid_at' => $request->status === 'paid' ? now() : null,
        ]);

        return redirect()->route('invoices.preview', $invoice)->with('success', 'Invoice generated successfully!');
    }

    public function show(Invoice $invoice)
    {
        return view('invoice-preview', compact('invoice'));
    }

    public function preview(Invoice $invoice)
    {
        return view('invoice-preview', compact('invoice'));
    }

    public function updateStatus(Request $request, Invoice $invoice)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,cancelled',
        ]);

        if ($request->status === 'paid') {
            $invoice->markAsPaid();
        } elseif ($request->status === 'cancelled') {
            $invoice->markAsCancelled();
        } else {
            $invoice->update(['status' => $request->status]);
        }

        return back()->with('success', 'Invoice status updated successfully!');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('dashboard')->with('success', 'Invoice deleted successfully!');
    }

    public function downloadPdf(Invoice $invoice)
    {
        $pdf = \PDF::loadView('invoice-pdf', compact('invoice'));
        return $pdf->download("invoice-{$invoice->invoice_number}.pdf");
    }

    public function shareWhatsApp(Invoice $invoice)
    {
        // Generate PDF first
        $pdf = \PDF::loadView('invoice-pdf', compact('invoice'));
        $pdfPath = storage_path("app/public/invoices/invoice-{$invoice->invoice_number}.pdf");
        
        // Ensure directory exists
        if (!file_exists(dirname($pdfPath))) {
            mkdir(dirname($pdfPath), 0755, true);
        }
        
        // Save PDF to storage
        $pdf->save($pdfPath);
        
        // Create public URL for the PDF
        $pdfUrl = url("storage/invoices/invoice-{$invoice->invoice_number}.pdf");
        
        $message = "📄 *Invoice #{$invoice->invoice_number}*\n\n";
        $message .= "💰 *Amount:* {$invoice->formatted_total}\n";
        $message .= "🚗 *Trip:* {$invoice->pickup_location} → {$invoice->dropoff_location}\n";
        $message .= "📅 *Date:* {$invoice->formatted_date} at {$invoice->formatted_time}\n";
        $message .= "👤 *Customer:* {$invoice->customer_name}\n";
        $message .= "🚙 *Vehicle:* " . ucfirst($invoice->vehicle_type) . "\n";
        $message .= "💳 *Payment Method:* " . ucfirst($invoice->payment_method) . "\n";
        $message .= "📊 *Status:* " . ucfirst($invoice->status) . "\n\n";
        $message .= "📎 *Invoice PDF:* {$pdfUrl}\n\n";
        $message .= "Thank you for choosing United Airport Pickup! 🚀";
        
        $whatsappUrl = "https://wa.me/?text=" . urlencode($message);
        
        return redirect($whatsappUrl);
    }

    public function share(Invoice $invoice)
    {
        $pdfUrl = route('invoices.download', $invoice);
        $message = urlencode("Here is your invoice from United Airport Pickup: $pdfUrl");
        $whatsappUrl = "https://wa.me/?text=$message";
        return redirect($whatsappUrl);
    }
}
