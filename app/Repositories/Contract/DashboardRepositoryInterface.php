<?php
namespace App\Repositories\Contract;

interface DashboardRepositoryInterface
{
    public function mtd_revenue();
    public function mtd_transactions();
    public function mtd_profit();
    public function ytd_revenue();
    public function revenue_between($start_date, $end_date);
    public function transactions_between($start_date, $end_date);
    public function profit_between($start_date, $end_date);
    public function sum_by_month();
}
