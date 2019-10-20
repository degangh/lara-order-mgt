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
            'address_id' => $attributes->address_id
        ]);
    }

    public function createDetail($order, $orderItems)
    {
        collect($orderItems)->map(function($orderItem){
            return OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $orderItem->product_id,
                'unit_price_cny' => $orderItem->unit_price_cny,
                'purchase_price_aud' => $orderItem->purchase_price_aud,
                'quantity' => $orderItem->quantity
            ]);
        });
    }
}