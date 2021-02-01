<?php

namespace App\Http\Livewire;

use App\Models\Invoice;
use Livewire\Component;
use phpDocumentor\Reflection\Types\Boolean;

class InvoiceNumberSearch extends Component
{
    public $invoice_number;
    public $results;
    private $find_invoice = false;

    public function render()
    {
        if ($this->invoice_number == null)
            $this->results = [];
        else
        if ($this->find_invoice)
            $this->results = [];
        else
            $this->results = Invoice::where('invoice_number', 'LIKE', '%' . $this->invoice_number . '%')->pluck('invoice_number', 'id');

        return view('livewire.invoice-number-search');
    }

    public function fillInput($invoice_number)
    {
        $this->invoice_number = $invoice_number;
        $this->find_invoice = true;
    }
}
