<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Main extends Model
{
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
}
