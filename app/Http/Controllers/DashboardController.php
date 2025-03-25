<?php

namespace App\Http\Controllers;

use App\Models\Training\Enrollment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     *@return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        return view('dashboard');
    }
}
