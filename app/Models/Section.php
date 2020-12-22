<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'created_by', 'status'];

    public function setCreatedByAttribute($value)
    {
        if (auth()->check())
            $this->attributes['created_by'] = auth()->user()->name;
        $this->attributes['created_by'] = $value;
    }

    public function getStatus()
    {
        return $this->status == 0 ? 'معطل' : 'مفعل';
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'section_id', 'id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
