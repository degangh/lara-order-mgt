<?php
namespace App\Repositories\Contract;

use App\Order;
use App\OrderStatus;
interface OrderRepositoryInterface
{
    /**
     * get list of records, default 20 records
     * 
     * @parmas record_per_page default 20
     * 
     * @return 
     */
    public function all($record_per_page = 20);

    public function create($attributes, $user);

    public function createDetail($order, $orderItems, $exchange_rate);

    public function changeStatus(Order $order , OrderStatus $status);

}