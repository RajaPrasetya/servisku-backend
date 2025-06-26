<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormService extends Model
{
    protected $fillable = [
        'status',
        'id_customer',
        'id_user',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // bagian dari form servis

    public function detailService()
    {
        return $this->hasOne(DetailService::class, 'no_form', 'no_form');
    }

    public function unitServices()
    {
        return $this->hasMany(UnitService::class, 'no_form', 'no_form');
    }

    public function statusGaransi()
    {
        return $this->hasOne(StatusGaransi::class, 'no_form', 'no_form');
    }
}
