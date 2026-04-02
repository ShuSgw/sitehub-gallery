<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.dashboard', compact("users"));
    }
}
