<?php

namespace App\Http\Controllers\systems\lls_whip\whip\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){

        $data['title'] = 'Admin Dashboard';
        return view('systems.lls_whip.whip.admin.pages.dashboard.dashboard')->with($data);
    }
}
