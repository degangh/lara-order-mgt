<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $table = "status";

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    public function getRouteKeyName()
    {
        return 'name';
    }
}
