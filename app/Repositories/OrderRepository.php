<?php

namespace App\Repositories;
use App\Repositories\Contract\OrderRepositoryInterface;
use App\Order;

class OrderRepository implements OrderRepositoryInterface
{
    public function all($keyword = '', $records_per_page = 20)
    {
        return Order::when($keyword, function($query, $keyword){
            return $query->where('name', 'like', '%' . $keyword . '%');
        })->paginate(20);

    }

    public function create($attributes, $user)
    {
        return Order::create([
            'customer_id' => $attributes->customer_id,
            'user_id' => $user->id,
        ]);
    }

    public function createDetail($order, $orderItems)
    {
        
    }
}