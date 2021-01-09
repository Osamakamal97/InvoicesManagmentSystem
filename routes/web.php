<?php

use App\Http\Controllers\{
    AdminController,
    CustomersReportController,
    HomeController,
    InvoiceAttachmentController,
    InvoiceController,
    InvoiceDetailsController,
    InvoicesReportController,
    ProductController,
    RoleController,
    SectionController,
    UserController,
};
use Illuminate\Support\Facades\{
    Auth,
    Route
};

Route::get('/', function () {
    return view('welcome');
});

Route::view('test', 'test');
// Route::get('test', [HomeController::class, 'test']);
Route::view('app', 'layouts.app');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    // Invoices Routes
    Route::get('invoices/archives', [InvoiceController::class, 'archives'])->name('invoices.archives');
    Route::post('invoices/archive/{invoice}', [InvoiceController::class, 'archive'])->name('invoices.archive');
    Route::post('invoices/unarchive/{invoice}', [InvoiceController::class, 'unarchive'])->name('invoices.unarchive');
    Route::get('invoices/{invoice}/editStatus', [InvoiceController::class, 'editStatus'])->name('invoices.editStatus');
    Route::put('invoices/{invoice}/updateStatus', [InvoiceController::class, 'updateStatus'])->name('invoices.updateStatus');
    Route::get('invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');
    Route::get('invoices/export', [InvoiceController::class, 'export'])->name('invoices.export');
    // Resources
    Route::resources([
        'invoices' => InvoiceController::class,
        'sections' => SectionController::class,
        'products' => ProductController::class,
        'users' => UserController::class,
        'roles' => RoleController::class,
    ]);
    Route::get('invoices/{payment_status}', [InvoiceController::class, 'getInvoicesByPaymentStatus'])
        ->name('invoices.paid_invoices');
    // Invoice Details Routes
    Route::get('invoice/{invoice_id}/details', [InvoiceDetailsController::class, 'index'])->name('invoiceDetails.index');
    Route::post('invoices/archives/{invoice_id}/details', [InvoiceDetailsController::class, 'index'])
        ->name('archiveInvoiceDetails.index');
    // Invoice Attachment routes
    Route::resource('invoiceAttachment', InvoiceAttachmentController::class)
        ->only(['store', 'destroy', 'downloadAttachment', 'getAttachment']);
    Route::get('invoice-attachment/{invoice_number}/{attachment}', [InvoiceAttachmentController::class, 'getAttachment'])
        ->name('invoiceAttachment.getAttachment');
    Route::get(
        'invoice-attachment/download/{invoice_number}/{attachment}',
        [InvoiceAttachmentController::class, 'downloadAttachment']
    )
        ->name('invoiceAttachment.downloadAttachment');
    // Invoices Reports Routes 
    Route::get('invoices-reports', [InvoicesReportController::class, 'index'])->name('invoicesReports.index');
    Route::post('invoices-reports', [InvoicesReportController::class, 'search'])->name('invoicesReports.search');
    // Customers Reports Routes 
    Route::get('customers-reports', [CustomersReportController::class, 'index'])->name('customersReport.index');
    Route::post('customers-reports', [CustomersReportController::class, 'search'])->name('customersReport.search');
});

Route::get('section/{id}', [InvoiceController::class, 'getProducts']);

Route::get('{page}', [AdminController::class, 'index']);
