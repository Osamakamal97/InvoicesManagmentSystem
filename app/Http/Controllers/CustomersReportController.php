<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomersReportSearchRequest;
use App\Models\Invoice;
use App\Models\Section;
use Carbon\Carbon;

class CustomersReportController extends Controller
{

    public function index()
    {
        $oldInputs['date_range'] = '';
        $oldInputs['section_id'] = '';
        $oldInputs['product_id'] = '';
        $sections = Section::all();
        return view('customersReport.index', compact(['oldInputs', 'sections']));
    }

    public function search(CustomersReportSearchRequest $request)
    {
        // with date range
        if ($request->date_range != null) {
            // Separate two dates then format it with the way that database can understand
            $dates = explode('-', $request->date_range);
            $from_date = Carbon::parse($dates[0])->format('Y-m-d');
            $to_date = Carbon::parse($dates[1])->format('Y-m-d');
            // has section id
            if ($request->section_id != 0)
                // has product id
                if ($request->product_id == 0)
                    $invoices = Invoice::whereBetween('invoice_date', [$from_date, $to_date])
                        ->whereSectionId($request->section_id)->get();
                // hasn't product id
                else
                    $invoices = Invoice::whereSectionId($request->section_id)
                        ->whereProductId($request->product_id)
                        ->whereProductId($request->product_id)->get();
            // hasn't product id
            else
                $invoices = Invoice::whereBetween('invoice_date', [$from_date, $to_date])->get();
            // without date range
        } else {
            // has product id
            if ($request->product_id == 0)
                $invoices = Invoice::whereSectionId($request->section_id)->get();
            // hasn't product id
            else
                $invoices = Invoice::whereSectionId($request->section_id)
                    ->whereProductId($request->product_id)->get();
        }
        // Get all inputs to return it to a page as old inputs.
        $oldInputs = $request->all();
        $sections = $this->sections;
        return view('customersReport.index', compact(['invoices', 'oldInputs', 'sections']));
    }
}
