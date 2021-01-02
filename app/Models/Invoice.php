<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed invoice_number
 */
class Invoice extends Main
{
    use HasFactory, SoftDeletes;

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
        'user_id',
        'status'
    ];

    /**
     * @return string
     */
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
                $status = 'غير مُعرَّفة';
                break;
        }
        return $status;
    }

    public function getAttachment()
    {
        $attachment_storage_path = InvoiceAttachment::where('invoice_id', $this->id)->first()->file_path;
        return str_replace('app/', '', $attachment_storage_path);
    }

    private function calculate()
    {
        $commission_amount = $this->commission_amount;
        $discount = $this->discount;
        $commission_amount2 = $commission_amount - $discount;
        $rate_vat = $this->rate_vat;
        $result1 = $commission_amount2 * ($rate_vat / 100);
        $result2 = $result1 + $commission_amount2;
        return ['value_vat' => $result1, 'total' => $result2];
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

    public function setValueVatAttribute($value_vat)
    {
        $this->attributes['value_vat'] = $this->calculate()['value_vat'];
    }

    public function setTotalAttribute()
    {
        $this->attributes['total'] = $this->calculate()['total'];
    }

    // Accessors

    public function getInvoiceDateAttribute()
    {
        return Carbon::make($this->attributes['invoice_date'])->format('m/d/Y');
    }

    public function getDueDateAttribute()
    {
        return Carbon::make($this->attributes['due_date'])->format('m/d/Y');
    }

    // Relations

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function section(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
