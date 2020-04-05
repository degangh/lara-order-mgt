<?php

namespace App\Repositories;
use App\Repositories\Contract\OrderRepositoryInterface;
use App\Order;
use App\OrderItem;
use App\OrderStatus;

class DashboardRepository implements DashboardRepositoryInterface
{
    public function ytd_revenue()
    {

    }

    public function mtd_revenue()
    {

    }

    public function revenue_between($from, $to)
    {
        return DB::table('orders')
        ->join('order_items','orders.id', '=', 'order_items.order_id')
        ->whereBetween('orders.created_at',['2020-04-01', '2020-04-30'])
        ->sum(DB::raw('unit_price_cny * quantity'));
    }
}