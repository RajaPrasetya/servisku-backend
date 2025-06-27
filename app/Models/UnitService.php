<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitService extends Model
{
    protected $fillable = [
        'no_form',
        'tipe_unit',
        'serial_number',
        'kerusakan',
        'kelengkapan',
    ];

    public function formService()
    {
        return $this->belongsTo(FormService::class, 'no_form', 'no_form');
    }
}
