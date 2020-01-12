<?php
namespace App\Repositories\Contract;

interface OrderRepositoryInterface
{
    public function add(Order $order, OrderItem $item);

    public function update(OrderItem $item);

    public function delete(OrderItem $item);
}