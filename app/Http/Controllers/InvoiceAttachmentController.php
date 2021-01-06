<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceAttachmentRequest;
use App\Models\InvoiceAttachment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceAttachmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:add_invoice_attachment', ['only' => ['store']]);
        $this->middleware('permission:view_invoice_attachment', ['only' => ['getAttachment']]);
        $this->middleware('permission:download_invoice_attachment', ['only' => ['downloadAttachment']]);
        $this->middleware('permission:delete_invoice_attachment', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceAttachmentRequest $request)
    {
        if ($request->has('attachments')) {
            $file_paths = uploadImage('invoices', $request->attachments, $request->invoice_number);
            // store invoice attachment
            foreach ($file_paths as $path)
                InvoiceAttachment::create([
                    'file_path' => $path,
                    'invoice_id' => $request->invoice_id,
                    'created_by' => 'test'
                ]);
            return redirect()->back()->with('success', 'تم رفع المرفقات بنجاح.');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvoiceAttachment  $invoiceAttachment
     * @return \Illuminate\Http\Response
     */
    public function show(InvoiceAttachment $invoiceAttachment)
    {
        //
    }

    public function getAttachment($invoice_number, $attachment)
    {
        try {
            $file_path = $invoice_number . '/' . $attachment;
            // $attachment = Storage::disk('invoices')->get($file_path);
            $attachment = Storage::getDriver()->getAdapter()->applyPathPrefix('invoices/' . $file_path);
            return response()->file($attachment);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'حصل خطأ في عرض المرفقات.');
        }
    }

    public function downloadAttachment($invoice_number, $attachment)
    {
        try {
            $file_path = $invoice_number . '/' . $attachment;
            return Storage::download('invoices/' . $file_path);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'حصل خطأ في عرض المرفقات.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoiceAttachment  $invoiceAttachment
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoiceAttachment $invoiceAttachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvoiceAttachment  $invoiceAttachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoiceAttachment $invoiceAttachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoiceAttachment  $invoiceAttachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoiceAttachment $invoiceAttachment)
    {
        $file_path = str_replace('storage/app/invoices/', '', $invoiceAttachment->file_path);
        // delete attachment from file
        Storage::disk('invoices')->delete($file_path);
        // delete invoice attachment form database
        $invoiceAttachment->delete();
        return redirect()->back()->with('error', 'تم حذف المُرفَق بنجاح.');
    }
}
