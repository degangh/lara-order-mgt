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
            'product_id' => $item->product_id,
            'unit_price_cny' => $item->unit_price_cny,
            'purchase_price_aud' => $item->purchase_price_aud,
            'quantity' => $item->quantity,
            'exchange_rate' => $item->exchange_rate
        ]);
    }

    public function update($attribute, OrderItem $item)
    {
        $orderItem = OrderItem::find($item->id);
        $orderItem->sell_price = $attribute->unit_price_cny;
        $orderItem->quantity = $attribute->quantity;
        $orderItem->purchase_price = $attribute->purchase_price_aud;
        $orderItem->exchange_rate = $attribute->exchange_rate;
        
        $orderItem->save();

        return $item->unit_price_cny;
    }

    public function delete(OrderItem $item)
    {
        return OrderItem::find($item->id)->delete();
    }
}