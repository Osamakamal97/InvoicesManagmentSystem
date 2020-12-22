<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'invoice_number',
        'invoice_date',
        'due_date',
        'product_id',
        'section_id',
        'status',
        'note',
        'user_id',
    ];
    
    public function setUserIdAttribute()
    {
        $this->attributes['user_id'] = auth()->user()->id;
    }

    public function setInvoiceDateAttribute($invoice_date)
    { 
        $this->attributes['invoice_date'] = Carbon::parse($invoice_date)->format('Y-m-d');
    }   
    public function setDueDateAttribute($due_date)
    { 
        $this->attributes['due_date'] = Carbon::parse($due_date)->format('Y-m-d');
    }
}
