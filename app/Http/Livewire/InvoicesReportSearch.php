<?php

namespace App\Http\Livewire;

use Livewire\Component;

class InvoicesReportSearch extends Component
{

    public $search_by_invoice_number = false;
    public $search_type = 'invoice_type';

    public function render()
    {
        if ($this->search_type == 'invoice_number')
            $this->search_by_invoice_number = true;
        else
            $this->search_by_invoice_number = false;
        return view('livewire.invoicesReportSearch');
    }
}
