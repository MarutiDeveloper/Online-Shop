<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Invoice;  // Make sure to import your Invoice model
use App\Models\Order; // Import the Order model
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function downloadInvoice($id)
    {
        // Fetch the order by its ID, including the related items
        $invoice = Order::with('items')->findOrFail($id);

        // Prepare the invoice data
        $invoiceData = [
            'id' => $invoice->id,
            'date' => $invoice->created_at->toDateString(),
            'items' => $invoice->items, // This will include all items related to the order
            'discount' => $invoice->discount ?? 0, // Optional if discount is a field in your orders table
            'shipping_charge' => $invoice->shipping_charge ?? 0, // Optional if shipping_charge is a field
            'total' => $invoice->total ?? $invoice->items->sum('subtotal') - $invoice->discount + $invoice->shipping_charge, // Optional calculation for total
        ];

        // Load the view with invoice data
        $pdf = Pdf::loadView('front.invoice', compact('invoiceData'));
        //return view('front.invoice', compact('invoiceData'));
        // Return the invoice as a downloadable PDF
        return $pdf->download('invoice-' . $invoice->id . '.pdf');
       
    }
}
