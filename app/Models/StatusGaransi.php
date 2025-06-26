<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusGaransi extends Model
{
    protected $fillable = [
        'garansi',
        'tgl_beli',
        'no_nota',
        'no_form',
    ];

    public function formService()
    {
        return $this->belongsTo(FormService::class, 'no_form', 'no_form');
    }
}
