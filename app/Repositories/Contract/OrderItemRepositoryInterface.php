<?php
namespace App\Repositories\Contract;

use App\Order;
use App\OrderItem;

interface OrderItemRepositoryInterface
{
    public function add(Order $order, OrderItem $item, $exchange_rate);

    public function update(OrderItem $item);

    public function delete(OrderItem $item);
}