<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Models\Invoice;
use App\Models\InvoiceAttachment;
use App\Models\InvoiceDetails;
use App\Models\Product;
use App\Models\Section;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(Section::inRandomOrder()->first()->id);
        $invoices = Invoice::all();
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Section::all();
        return view('invoices.create', [
            'sections' => $sections
        ]);
    }

    public function getProducts($id)
    {
        $products = Product::where('section_id', $id)->pluck('name', 'id');
        return json_encode($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceRequest $request)
    {
        // try {
        // Because there is multiple DB insert process this help if there is any problem happen in any insertion
        DB::beginTransaction();

        // Store invoice
        $invoice_id = Invoice::create($request->validated())->id;

        // $request->invoice_id = $invoice_id;
        // store invoice details
        // [
        //     'invoice_id' => $invoice_id,
        //     'invoice_number' => $request->invoice_number,
        //     'invoice_date' => $request->invoice_date,
        //     'due_date' => $request->due_date,
        //     'product_id' => $request->product_id,
        //     'section_id' => $request->section_id,
        //     'note' => $request->note,
        //     'user_id' => $request->user_id,
        // ]
        InvoiceDetails::create(Arr::add($request->validated(), 'invoice_id', $invoice_id));
        // check if there is any attachment to store it in a folder
        if ($request->has('attachment')) {
            $file_path = uploadImage('invoices', $request->attachment);
            // store invoice attachment
            InvoiceAttachment::create([
                'file_path' => $file_path,
                'invoice_id' => $invoice_id,
                'created_by' => 'samer'
            ]);
        }

        // Commit DB insertions
        DB::commit();
        return redirect()->route('invoices.index')->with('success', 'تم إنشاء الفاتورة بنجاح.');
        // } catch (Exception $e) {
        //     DB::rollBack();
        return redirect()->back()->withInput($request->all())->with('error', 'error');
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
