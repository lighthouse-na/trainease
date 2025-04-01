<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View
    {
        return view('dashboard');
    }
}
