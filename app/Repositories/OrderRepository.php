<?php

namespace App\Repositories;
use App\Repositories\Contract\OrderRepositoryInterface;
use App\Order;
use App\OrderItem;
use App\OrderStatus;

class OrderRepository implements OrderRepositoryInterface
{
    public function all($keyword = '', $records_per_page = 20)
    {

        return Order::with('customer','status')->withCount(['items as sum' => function($query) {
            $query->select(\DB::raw('sum(quantity*unit_price_cny)'));
        }])->when($keyword, function($query, $keyword){
            return $query->where('name', 'like', '%' . $keyword . '%');
        })->orderBy('id','desc')->paginate(20);

    }

    public function create($attributes, $user)
    {
        return Order::create([
            'customer_id' => $attributes->customer_id,
            'user_id' => $user->id,
            'address_id' => $attributes->address_id
        ]);
    }

    public function createDetail($order, $orderItems, $exchange_rate)
    {
        collect($orderItems)->map(function($orderItem) use (&$order, &$exchange_rate){
            return OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $orderItem['id'],
                'unit_price_cny' => $orderItem['rrp_cny'],
                'purchase_price_aud' => $orderItem['ref_price_aud'],
                'quantity' => $orderItem['num'],
                'exchange_rate' => $exchange_rate
            ]);
        });
    }

    public function changeStatus(Order $order , OrderStatus $status)
    {
        $order->status_id = $status->id;
        $order->save();

        return $order;
    }
}