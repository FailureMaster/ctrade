<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdvancedChartController extends Controller
{
    public function index(){
        $pageTitle = '';
        return view('advanced-chart', compact('pageTitle'));
    }
}
