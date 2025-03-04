<?php

namespace App\Http\Controllers;

use App\Models\Training\Enrollment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }
}
