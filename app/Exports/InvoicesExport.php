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
            'invoice_number',
            'User',
            'Date',
        ];
    }

    /**
    * @var Invoice $invoice
    */
    public function map($invoice): array
    {
        return [
            $invoice->invoice_number,
            $invoice->user->name,
            $invoice->created_at,
        ];
    }
}
