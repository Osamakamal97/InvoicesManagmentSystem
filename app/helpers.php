<?php

use App\Models\Invoice;
use Illuminate\Support\Facades\Storage;

function uploadImage($folder, $files, $invoice_number)
{
    $paths = [];
    foreach ($files as $file) {
        $file_name = $file->hashName();
        Storage::disk('invoices')->put($invoice_number, $file);
        array_push($paths, 'storage/app/' . $folder . '/' . $invoice_number . '/' . $file_name);
    }
    return $paths;
}

function totalInvoices()
{
    $total = Invoice::sum('total');
    return number_format($total, 2);
}

function totalInvoicesByStatus($status)
{
    if ($status >= 0 && $status < 3) {
        $total = Invoice::whereStatus($status)->sum('total');
        return number_format($total, 2);
    }
    return 0;
}

function totalInvoicesPercentageByStatus($status)
{
    $invoices = Invoice::count();
    $tInvoices = Invoice::whereStatus($status)->count();
    if ($invoices > 0)
        return number_format(($tInvoices / $invoices) * 100, 2);
    return 0;
}

function invoiceCountByStatus($status)
{
    return Invoice::whereStatus($status)->count();
}
