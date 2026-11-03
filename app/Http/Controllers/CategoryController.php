<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GreetingService;


class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $greetingService = new GreetingService();
        $greeting = $greetingService->get();
        $siteId = $request->query('site');

        return view('user.category', compact(
            'greeting',
            'siteId'
        ));
    }
}
