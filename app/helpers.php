<?php

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
