<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceDetails extends Main
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'invoice_id',
        'payment_date',
        'status',
        'note',
        'user_id',
    ];

    // Mutator

    public function setUserIdAttribute()
    {
        $this->attributes['user_id'] = auth()->user()->id;
    }

    public function setPaymentDateAttribute($payment_date)
    {
        $this->attributes['payment_date'] = Carbon::parse($payment_date)->format('Y-m-d');
    }

    // Relations

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
