<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $result = array(
            'sales_revenue' => 3203.25,
            'transaction' => 23,
            'profit' => 900,
        );

        return response()->json($result);

    }
}
