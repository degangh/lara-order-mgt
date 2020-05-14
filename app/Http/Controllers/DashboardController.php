<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Repositories\Contract\DashboardRepositoryInterface;

class DashboardController extends Controller
{
    protected $dashRepo;
    public function __construct(DashboardRepositoryInterface $dashboardRepository)
    {
        $this->dashRepo = $dashboardRepository;
    }
    
    public function index()
    {
        $result = array(
            'sales_revenue' => $this->dashRepo->mtd_revenue(),
            'transaction' => $this->dashRepo->mtd_transactions(),
            'profit' => round($this->dashRepo->mtd_profit(),2),
            'overdue_amount' => round($this->dashRepo->overdue_amount(),2),
            'overdue_orders' => $this->dashRepo->overdue_trans(),
            'pending_deliveries' => $this->dashRepo->pending_delivery(),
            'pending_orders' => $this->dashRepo->pending_orders(),
        );

        return response()->json($result);

    }

    public function mtd()
    {
       return  $this->dashRepo->mtd_profit();
    }

    public function monthly_sum()
    {
        return $this->dashRepo->sum_by_month();
    }

    public function monthly_profit()
    {
        return $this->dashRepo->profit_by_month();
    }
}
