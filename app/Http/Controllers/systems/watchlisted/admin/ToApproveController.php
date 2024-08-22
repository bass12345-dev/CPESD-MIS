<?php

namespace App\Http\Controllers\systems\watchlisted\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Repositories\watchlisted\PersonQuery;
use App\Services\watchlisted\user\DashboardService;
use Carbon\Carbon;
class ToApproveController extends Controller
{
   
    protected $conn;
    protected $customRepository;
    protected $dashboardService;
    protected $personQuery;
    public function __construct(CustomRepository $customRepository, DashboardService $dashboardService, PersonQuery $personQuery){
        $this->conn                 = config('custom_config.database.dts');
        $this->customRepository     = $customRepository;
        $this->dashboardService     = $dashboardService;
        $this->personQuery          = $personQuery;
     
    }
    public function index(){
      
        $data['title']                      = 'Admin Dashboard';
        return view('systems.watchlisted.admin.pages.to_approved.to_approved')->with($data);
    }
}
