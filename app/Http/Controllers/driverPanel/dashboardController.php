<?php

namespace App\Http\Controllers\driverPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Mail\Mailler;

class dashboardController extends Controller
{
    function index()
    {
        return view('driverPanel.layouts.main');
    }
}
