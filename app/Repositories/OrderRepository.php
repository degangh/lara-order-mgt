<?php

namespace App\Repositories;
use App\Repositories\Contract\OrderRepositoryInterface;
use App\Order;
use App\OrderItem;

class OrderRepository implements OrderRepositoryInterface
{
    public function all($keyword = '', $records_per_page = 20)
    {

        return Order::with('customer')->withCount(['items as sum' => function($query) {
            $query->select(\DB::raw('sum(quantity*unit_price_cny)'));
        }])->when($keyword, function($query, $keyword){
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
        collect($orderItems)->map(function($orderItem) use (&$order){
            return OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $orderItem->product_id,
                'unit_price_cny' => $orderItem->unit_price_cny,
                'purchase_price_aud' => $orderItem->purchase_price_aud,
                'quantity' => $orderItem->quantity,
                'exchange_rate' => $orderItem->exchange_rate
            ]);
        });
    }
}