<?php

namespace Http\Controllers;

use Illuminate\Http\Request;

class GetDashboardController extends Controller
{
    
    public function __invoke()
    {
        return view('pages.dashboard');
    }
}
