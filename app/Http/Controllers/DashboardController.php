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
            'transaction' => 23,
            'profit' => 900,
        );

        return response()->json($result);

    }

    public function mtd()
    {
       return  $this->dashRepo->mtd_revenue();
    }
}
