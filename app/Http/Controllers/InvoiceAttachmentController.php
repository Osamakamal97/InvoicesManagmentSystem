<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceAttachmentRequest;
use App\Models\InvoiceAttachment;
use Exception;
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
            return redirect()->back()->with('success', __('notifications.success_upload_attachments'));
        }
        return redirect()->back();
    }

    public function getAttachment($invoice_number, $attachment)
    {
        try {
            $file_path = $invoice_number . '/' . $attachment;
            // $attachment = Storage::disk('invoices')->get($file_path);
            $attachment = Storage::getDriver()->getAdapter()->applyPathPrefix('invoices/' . $file_path);
            return response()->file($attachment);
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('notifications.error_show_attachments'));
        }
    }

    public function downloadAttachment($invoice_number, $attachment)
    {
        try {
            $file_path = $invoice_number . '/' . $attachment;
            return Storage::download('invoices/' . $file_path);
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('notifications.error_show_attachments'));
        }
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
        return redirect()->back()->with('error', __('notifications.success_delete_attachment'));
    }
}
