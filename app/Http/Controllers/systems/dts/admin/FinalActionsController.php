<?php

namespace App\Http\Controllers\systems\dts\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Services\dts\admin\DashboardService;
use Carbon\Carbon;

class FinalActionsController extends Controller
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
        $data['title']      = 'Final Actions';
        return view('systems.dts.admin.pages.final_actions.final_actions')->with($data);
    }

    



}
