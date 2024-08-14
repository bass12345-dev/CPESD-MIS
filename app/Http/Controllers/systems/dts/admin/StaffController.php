<?php

namespace App\Http\Controllers\systems\dts\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Services\dts\admin\DashboardService;
use Carbon\Carbon;

class StaffController extends Controller
{
    protected $conn;
    protected $customRepository;
    protected $dashboardService;
    public function __construct(CustomRepository $customRepository, DashboardService $dashboardService){
        $this->conn                 = config('custom_config.database.dts');
        $this->customRepository     = $customRepository;
        $this->dashboardService     = $dashboardService;
     
    }
    public function index(){
        $data['title']      = 'Manage Staff';
        return view('systems.dts.admin.pages.manage_staff.manage_staff')->with($data);
    }

    



}
