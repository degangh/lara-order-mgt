<?php
namespace App\Repositories\Contract;

interface DashboardRepositoryInterface
{
    public function mtd_revenue();
    public function mtd_transaction();
    public function mtd_profit();
    public function ytd_revenue();
    public function revenue_between($start_date, $end_date);
}
