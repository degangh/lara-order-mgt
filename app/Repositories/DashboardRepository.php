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
        ->sum(DB::raw('sell_price * quantity'));
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
        ->sum(DB::raw('sell_price * quantity-purchase_price * quantity * exchange_rate'));
    }

    public function sum_by_month()
    {
        return $this->get_term()->map(function($term){
            
            $carbon = new Carbon($term);
            $from = $carbon->startOfMonth()->format('Y-m-d');
            
            $to = $carbon->endOfMonth()->format('Y-m-d');
            return array(
                'sum' => $this->revenue_between($from , $to),
                'order_month' => $term
            );
        });
        
           
    }

    public function profit_by_month()
    {
        return $this->get_term()->map(function($term){
            
            $carbon = new Carbon($term);
            $from = $carbon->startOfMonth()->format('Y-m-d');
            
            $to = $carbon->endOfMonth()->format('Y-m-d');
            return array(
                'sum' => $this->profit_between($from , $to),
                'order_month' => $term
            );
        });
        
           
    }

    private function get_term($term = 'MONTH')
    {
        $terms = array();

        for ($i = 0; $i < 6; $i++) $terms[] = date('F Y', strtotime("-$i month"));

        return collect(array_reverse($terms));
    }

    public function overdue_amount()
    {
        return DB::table('orders')
        ->join('order_items','orders.id', '=', 'order_items.order_id')
        ->where('sent', '=', 1)
        ->where('paid', '=', 0)
        ->sum(DB::raw('sell_price * quantity'));
    }
    public function overdue_trans()
    {
        return DB::table('orders')
        ->where('sent', '=', 1)
        ->where('paid', '=', 0)
        ->count();
    }
    public function pending_delivery()
    {
        return DB::table('orders')
        ->where('sent', '=', 0)
        ->where('paid', '=', 1)
        ->count();
    }
    public function pending_orders()
    {
        return DB::table('orders')
        ->where('sent', '=', 0)
        ->where('paid', '=', 0)
        ->count();
    }

    

}