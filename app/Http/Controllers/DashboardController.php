<?php

namespace App\Http\Controllers;

use App\Models\Training\Enrollment;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * @return View<string, array<string, mixed>>
     */
    public function index(): View
    {
        return view('dashboard');
    }
}
