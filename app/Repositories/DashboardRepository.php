<?php

namespace App\Repositories;
use App\Repositories\Contract\DashboardRepositoryInterface;
use App\Order;
use App\OrderItem;
use App\OrderStatus;
use Carbon\Carbon;
use DB;

class DashboardRepository implements DashboardRepositoryInterface
{
    public function ytd_revenue()
    {

    }

    public function mtd_revenue()
    {
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now();
        
        return $this->revenue_between($start, $end);
    }

    public function revenue_between($from, $to)
    {
        return DB::table('orders')
        ->join('order_items','orders.id', '=', 'order_items.order_id')
        ->whereBetween('orders.created_at',[$from, $to])
        ->sum(DB::raw('unit_price_cny * quantity'));
    }

    public function mtd_transaction()
    {
        return false;
    }

    public function mtd_profit()
    {
        return false;
    }

}