<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $primaryKey = 'id_customer';
    
    protected $fillable = [
        'nama',
        'no_telp',
        'alamat',
    ];

    public function formServices()
    {
        return $this->hasMany(FormService::class, 'id_customer', 'id_customer');
    }
}
