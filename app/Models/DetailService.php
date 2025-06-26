<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailService extends Model
{
    protected $fillable = [
        'tgl_masuk',
        'tgl_selesai',
        'estimasi',
        'biaya',
        'no_form',
    ];

    public function formService()
    {
        return $this->belongsTo(FormService::class, 'no_form', 'no_form');
    }
}
