<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceAttachment;
use App\Models\InvoiceDetails;
use Illuminate\Http\Request;

class InvoiceDetailsController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:invoice_details', ['only' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($invoice_id, Request $request)
    {
        if ($request->archive_invoice_id != null) {
            $invoice_id = $request->archive_invoice_id;
            $invoice = Invoice::onlyTrashed()->find($invoice_id);
        } else
            $invoice = Invoice::find($invoice_id);
        $invoice_details = InvoiceDetails::whereInvoiceId($invoice_id)->get();
        $invoice_attachments = InvoiceAttachment::whereInvoiceId($invoice_id)->get();
        return view('invoices.details', compact(['invoice', 'invoice_details', 'invoice_attachments']));
    }
}
