<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceReportSearchRequest;
use App\Models\Invoice;
use Carbon\Carbon;

class InvoicesReportController extends Controller
{
    public function index()
    {
        // !This is add because there is a problem happen in view that can't catch it using isset
        $oldInputs['date_range'] = '';
        return view('invoicesReport.index', compact('oldInputs'));
    }

    /**
     * This use to search about invoice number OR invoice status that we have there
     * of them and with that you can add range of date that make search between
     * them after that return results to index with or without data then 
     * make a report using something
     */
    public function search(InvoiceReportSearchRequest $request)
    {
        if ($request->search_type == 'by_invoice_type')
            if ($request->date_range != '01/01/2000 - 01/01/2000') {
                $dates = explode('-', $request->date_range);
                $from_date = Carbon::parse($dates[0])->format('Y-m-d');
                $to_date = Carbon::parse($dates[1])->format('Y-m-d');
                $invoices = Invoice::whereBetween('invoice_date', [$from_date, $to_date])
                    ->whereStatus($request->invoice_status)->get();
            } else
                $invoices = Invoice::whereStatus($request->invoice_status)->get();
        else
            $invoices = Invoice::whereInvoiceNumber($request->invoice_number)->get();
        $oldInputs = $request->all();
        return view('invoicesReport.index', compact(['invoices', 'oldInputs']));
    }
}
