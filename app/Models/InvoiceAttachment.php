<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_path',
        'created_by',
        'invoice_id'
    ];

    public function setCreatedByAttribute()
    {
        $this->attributes['created_by'] = auth()->user()->name;
    }
}
