<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'phone',
    ];

    public function formServices()
    {
        return $this->hasMany(FormService::class, 'id_customer', 'id_customer');
    }
}
