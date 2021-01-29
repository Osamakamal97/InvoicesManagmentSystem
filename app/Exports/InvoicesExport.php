<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InvoicesExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Invoice::all();
    }

    public function headings(): array
    {
        return [
            __('frontend.invoice_number'),
            __('frontend.invoice_create_date'),
            __('frontend.due_date'),
            __('frontend.section'),
            __('frontend.product'),
            __('frontend.total_with_discount'),
            __('frontend.collection_amount'),
            __('frontend.commission_amount'),
            __('frontend.user'),
            __('frontend.status')
        ];
    }

    /**
     * @var Invoice $invoice
     */
    public function map($invoice): array
    {
        return [
            $invoice->invoice_number,
            $invoice->invoice_date,
            $invoice->due_date,
            $invoice->section->name,
            $invoice->product->name,
            $invoice->total,
            $invoice->collection_amount,
            $invoice->commission_amount,
            $invoice->user->name,
            $invoice->getStatus(),
        ];
    }
}
