<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Http\Requests\UpdateInvoiceStatusRequest;
use App\Models\Invoice;
use App\Models\InvoiceAttachment;
use App\Models\InvoiceDetails;
use App\Models\Product;
use App\Models\Section;
use App\Notifications\InvoiceAdded;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InvoicesExport;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the invoices.
     *
     * @return Response
     */
    public function index()
    {
        try {
            $invoices = Invoice::all();
            $is_archive = false;
            return view('invoices.index', compact(['invoices', 'is_archive']));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'حصلت مشكلة في جلب بيانات الفواتير.');
        }
    }

    /**
     *  Display a listing of the Archived invoices and return
     *  it at same index form becaus there is no different
     *  between index and archive table
     */
    public function archives()
    {
        try {
            $invoices = Invoice::onlyTrashed()->get();
            $is_archive = true;
            return view('invoices.index', compact(['invoices', 'is_archive']));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'حصلت مشكلة في جلب بيانات الفواتير المأرشفة.');
        }
    }

    /**
     *  Archive invoice by using soft delete to not display any
     *  archive and finished invoices at main invoices screen
     */
    public function archive(Invoice $invoice)
    {
        try {
            // Delete invoice from Database
            $invoice->delete();
            return redirect()->back()->with('error', 'تم أرشفة الفاتورة بنجاح.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'error');
        }
    }

    /**
     * Unarchive any archived invoice if that
     * is happen by wrong or for any reason 
     */
    public function unarchive(Request $request)
    {
        $invoice = Invoice::onlyTrashed()->find($request->invoice_id);
        try {
            $invoice->restore();
            return redirect()->back()->with('error', 'تم إلغاء أرشفة الفاتورة بنجاح.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'error');
        }
    }

    public function print(Invoice $invoice)
    {
        return view('invoices.print', compact('invoice'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        try {
            $sections = Section::all();
            return view('invoices.create', [
                'sections' => $sections
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'حصلت مشكلة في فتح صفحة إنشاء الفاتورة.');
        }
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
     * @return Response
     */
    public function store(InvoiceRequest $request)
    {
        try {
            // Because there is multiple DB insert process this help if there is any problem happen in any insertion
            DB::beginTransaction();
            // Store invoice
            $invoice_id = Invoice::create($request->validated())->id;
            // store invoice details
            InvoiceDetails::create(Arr::add($request->validated(), 'invoice_id', $invoice_id));
            // check if there is any attachment to store it in a folder
            if ($request->has('attachments')) {
                $file_paths = uploadImage('invoices', $request->attachments, $request->invoice_number);
                // store invoice attachment
                foreach ($file_paths as $path)
                    InvoiceAttachment::create([
                        'file_path' => $path,
                        'invoice_id' => $invoice_id,
                        'created_by' => 'test'
                    ]);
            }
            // Send mail
            Notification::send(auth()->user(), new InvoiceAdded($invoice_id));
            // Commit DB insertions
            DB::commit();
            return redirect()->route('invoices.index')->with('success', 'تم إنشاء الفاتورة بنجاح.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput($request->all())->with('error', 'error');
        }
    }

    public function details($invoice_id)
    {
        $invoice = Invoice::find($invoice_id);
        $invoice_details = InvoiceDetails::whereInvoiceId($invoice_id)->get();
        $invoice_attachments = InvoiceAttachment::whereInvoiceId($invoice_id)->get();
        return view('invoices.details', compact(['invoice', 'invoice_details', 'invoice_attachments']));
    }

    public function export()
    {
        return Excel::download(new InvoicesExport, 'invoices.xlsx');
    }

    /**
     * Display the specified resource.
     *
     * @param Invoice $invoice
     * @return Response
     */
    public function show(Invoice $invoice)
    {
        return redirect()->route('invoices.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Invoice $invoice
     * @return Response
     */
    public function edit(Invoice $invoice)
    {
        $sections = Section::all();
        return view('invoices.edit', [
            'invoice' => $invoice,
            'sections' => $sections
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Invoice $invoice
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(InvoiceRequest $request, Invoice $invoice)
    {
        try {
            // check if invoice number is update
            if ($request->has('invoice_number'))
                // rename invoice attachment folder 
                Storage::disk('invoices')->move($invoice->invoice_number, $request->invoice_number);
            $invoice->update($request->validated());
            return redirect()->route('invoices.index')->with('success', 'تم تحديث بيانات الفاتورة بنجاح.');
        } catch (Exception $e) {
            return redirect()->back()->withInput($request->all())->with('error', 'error');
        }
    }

    public function editStatus(Invoice $invoice, Request $request)
    {
        // return $request;
        return view('invoices.editStatus', compact('invoice'));
    }

    public function updateStatus(UpdateInvoiceStatusRequest $request, Invoice $invoice)
    {
        // return $request;
        // update invoice status
        $invoice->update(['status' => $request->status]);
        // add new invoice details for new update
        InvoiceDetails::create(Arr::add($request->validated(), 'invoice_id', $invoice->id));
        return redirect()->route('invoices.index')->with('success', 'تم تعديل حالة الدفع بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Invoice $invoice
     * @return Response
     */
    public function destroy($invoice_id)
    {
        try {
            $invoice = Invoice::onlyTrashed()->find($invoice_id);
            // Delete invoice attachments
            Storage::disk('invoices')->deleteDirectory($invoice->invoice_number);
            // Delete invoice from Database
            $invoice->forceDelete();
            return redirect()->back()->with('error', 'تم حذف الفاتورة بنجاح.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'error');
        }
    }
}
