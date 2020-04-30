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

    public function mtd_transactions()
    {
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now();

        return $this->transactions_between($start, $end);
    }

    public function mtd_profit()
    {
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now();

        return $this->profit_between($start, $end);
    }

    public function revenue_between($from, $to)
    {
        return DB::table('orders')
        ->join('order_items','orders.id', '=', 'order_items.order_id')
        ->whereBetween('orders.order_date',[$from, $to])
        ->where('paid', '=', 1)
        ->sum(DB::raw('unit_price_cny * quantity'));
    }

    public function transactions_between($from, $to)
    {
        return DB::table('orders')
        ->whereBetween('order_date',[$from, $to])
        ->where('sent', '=', 1)
        ->orWhere('paid', '=', 1)
        ->count();
    }  

    public function profit_between($from, $to)
    {
        return DB::table('orders')
        ->join('order_items','orders.id', '=', 'order_items.order_id')
        ->whereBetween('orders.order_date',[$from, $to])
        ->where('paid', '=', 1)
        ->sum(DB::raw('unit_price_cny * quantity-purchase_price_aud*quantity*exchange_rate'));
    }

}