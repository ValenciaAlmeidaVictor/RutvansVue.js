<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        // Obtener la URL actual
        $currentUrl = url()->current();

        // Pasar la URL actual a la vista
        return view('dashboard', compact('currentUrl'));
    }
}
