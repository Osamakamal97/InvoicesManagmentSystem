<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'due_date',
        'product_id',
        'section_id',
        'discount',
        'rate_vat',
        'value_vat',
        'total',
        'collection_amount',
        'commission_amount',
        'note',
        'user_id'
    ];

    public function getStatus()
    {
        $status = '';
        switch ($this->status) {
            case 0:
                $status = 'غير مدفوعة';
                break;
            case 1:
                $status = 'مدفوعة';
                break;
            case 2:
                $status = 'مدفوعة جزئياً';
                break;
            default:
                $status = 'غير معرف';
                break;
        }
        return $status;
    }

    // Mutator

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

    // Relations

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
