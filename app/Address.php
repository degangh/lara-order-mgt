<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'postcode',
        'mobile',
        'address',
        'customer_id',
        'is_default'
    ];
    
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orders()
    {
        return $this->hasMany(Address::class);
    }
}
