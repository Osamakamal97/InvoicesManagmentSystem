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
use App\Models\User;
use App\Notifications\CreateInvoice;

class InvoiceController extends Controller
{

    private $is_archive = false;

    public function __construct()
    {
        $this->middleware('permission:invoices_index', ['only' => ['index']]);
        $this->middleware('permission:invoices_archives', ['only' => ['archives']]);
        $this->middleware('permission:paid_invoices', ['only' => ['paidInvoices']]);
        $this->middleware('permission:part_paid_invoices', ['only' => ['partPaidInvoices']]);
        $this->middleware('permission:unpaid_invoices', ['only' => ['unpaidInvoices']]);
        $this->middleware('permission:archive_invoice', ['only' => ['archive']]);
        $this->middleware('permission:unarchive_invoice', ['only' => ['unarchive']]);
        $this->middleware('permission:create_invoice', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_invoice', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_invoice', ['only' => ['destroy']]);
        $this->middleware('permission:edit_invoice_payment_status', ['only' => ['editStatus']]);
        $this->middleware('permission:export_invoices_excel', ['only' => ['export']]);
        $this->middleware('permission:print_invoice', ['only' => ['print']]);
        $this->middleware('permission:edit_invoice_status', ['only' => ['editStatus', 'updateStatus']]);
    }

    /**
     * Display a listing of the invoices.
     *
     * @return Response
     */
    public function index()
    {
        try {
            $invoices = Invoice::all();
            $is_archive = $this->is_archive;
            $page_type = 'invoices';
            return view('invoices.index', compact(['invoices', 'is_archive', 'page_type']));
        } catch (Exception $e) {
            return redirect()->back()->with('error',  __('notifications.error_get_invoices'));
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
            $page_type = 'archives';
            return view('invoices.index', compact(['invoices', 'is_archive', 'page_type']));
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('notifications.error_get_archive_invoices'));
        }
    }

    public function getInvoicesByPaymentStatus($payment_status)
    {
        switch ($payment_status) {
            case 'paid':
                $status = 1;
                $page_type = 'paid';
                break;
            case 'part-paid':
                $status = 2;
                $page_type = 'part_paid';
                break;
            case 'unpaid':
                $status = 0;
                $page_type = 'unpaid';
                break;
        }
        try {
            $invoices = Invoice::where('status', $status)->get();
            $is_archive = false;
            return view('invoices.index', compact(['invoices', 'is_archive', 'page_type']));
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('notifications.error_get_archive_invoices'));
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
            return redirect()->back()->with('success', __('notifications.success_archive_invoice'));
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
            return redirect()->back()->with('error', __('notifications.success_unarchive_invoice'));
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
            return redirect()->back()->with('error', __('notifications.error_open_create_invoice'));
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
            // Send notification for any user except login one
            $users = User::where('id', '!=', auth()->user()->id)->get();
            Notification::send($users, new CreateInvoice(Invoice::latest()->first()));
            // Commit DB insertions
            DB::commit();
            return redirect()->route('invoices.index')->with('success', __('notifications.success_create_invoice'));
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
            if ($request->invoice_number != $invoice->invoice_number)
                // rename invoice attachment folder
                Storage::disk('invoices')->move($invoice->invoice_number, $request->invoice_number);
            $invoice->update($request->validated());
            return redirect()->route('invoices.index')->with('success', __('notifications.success_update_invoice'));
        } catch (Exception $e) {
            return redirect()->back()->withInput($request->all())->with('error', 'error');
        }
    }

    public function editStatus(Invoice $invoice, Request $request)
    {
        // return $request;
        return view('invoices.edit_status', compact('invoice'));
    }

    public function updateStatus(UpdateInvoiceStatusRequest $request, Invoice $invoice)
    {
        // update invoice status
        $invoice->update(['status' => $request->status]);
        // add new invoice details for new update
        InvoiceDetails::create(Arr::add($request->validated(), 'invoice_id', $invoice->id));
        return redirect()->route('invoices.index')->with('success', __('notifications.success_edit_invoice_payment_status'));
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
            return redirect()->back()->with('error', __('notifications.success_delete_invoice'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'error');
        }
    }

    public function createMultiProduct()
    {
        $sections = Section::all();
        return view('invoices.multiProductCreate', compact('sections'));
    }
}
