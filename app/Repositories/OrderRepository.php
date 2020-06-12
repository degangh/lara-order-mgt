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
        /*
        ->when($keyword, function($query, $keyword){
            return $query->where('name', 'like', '%' . $keyword . '%');
        })->*/
        return Order::withCount(['items as sum' => function($query) {
            $query->select(\DB::raw('sum(quantity*unit_price_cny)'));
        }])->with('customer')
        ->whereHas(
            'customer', function($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                ->where('name', '<>', 'null');
            }
            )->orderBy('id','desc')->paginate(20);

    }

    public function create($attributes, $user)
    {
        return Order::create([
            'customer_id' => $attributes->customer_id,
            'user_id' => $user->id,
            'address_id' => $attributes->address_id,
            'order_date' => $attributes->order_date
        ]);
    }

    public function createDetail($order, $orderItems, $exchange_rate)
    {
        collect($orderItems)->map(function($orderItem) use (&$order, &$exchange_rate){
            return OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $orderItem['id'],
                'sell_price' => $orderItem['rrp_cny'],
                'purchase_price' => $orderItem['ref_price_aud'],
                'quantity' => $orderItem['num'],
                'exchange_rate' => $exchange_rate,
                'sell_currency' => 'CNY',
                'purchase_currency' => 'AUD'

            ]);
        });
    }

    public function paid(Order $order)
    {
        $order->paid = 1;
        $order->save();
        return $order;
    }

    public function sent(Order $order)
    {   
        $order->sent = 1;
        $order->save();
        return $order;
    }

      
}