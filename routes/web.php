<?php

use App\Http\Controllers\{
    AdminController,
    CustomersReportController,
    GeneralController,
    HomeController,
    InvoiceAttachmentController,
    InvoiceController,
    InvoiceDetailsController,
    InvoicesReportController,
    NotificationController,
    ProductController,
    RoleController,
    SectionController,
    TestController,
    UserController,
};
use Illuminate\Support\Facades\{
    Auth,
    Route
};

Route::get('/', function () {
    return view('welcome');
});


Route::get('change-language/{locale}', [GeneralController::class, 'changeLanguage'])->name('change_locale');

// Route::view('test', 'test');
Route::get('test', [TestController::class, 'index']);
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
    Route::get('{payment_status}-invoices', [InvoiceController::class, 'getInvoicesByPaymentStatus'])
        ->name('invoices.paid_invoices');
    // Resources
    Route::resources([
        'invoices' => InvoiceController::class,
        'sections' => SectionController::class,
        'products' => ProductController::class,
        'users' => UserController::class,
        'roles' => RoleController::class,
    ]);
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
    // Notifications
    Route::get('notification/read-all', [NotificationController::class, 'readAllNotifications'])->name('notifications.readAll');
    Route::get('notification/{notification_id}/read/{invoice_id}', [NotificationController::class, 'readNotification'])->name('notifications.read');
});

Route::get('section/{id}', [InvoiceController::class, 'getProducts']);

Route::get('{page}', [AdminController::class, 'index']);
