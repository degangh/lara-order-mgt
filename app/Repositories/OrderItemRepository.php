<?php

namespace App\Repositories;
use App\Repositories\Contract\OrderItemRepositoryInterface;
use App\Order;
use App\OrderItem;

class OrderItemRepository implements OrderItemRepositoryInterface
{
    public function add(Order $order, OrderItem $item, $exchange_rate)
    {
        return OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item['id'],
            'unit_price_cny' => $item['rrp_cny'],
            'purchase_price_aud' => $item['ref_price_aud'],
            'quantity' => $item['num'],
            'exchange_rate' => $exchange_rate
        ]);
    }
}