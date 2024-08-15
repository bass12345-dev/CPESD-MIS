<?php

namespace App\Http\Controllers\systems\lls_whip\whip\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;

class DashboardController extends Controller
{
    protected $conn;
    protected $customRepository;
    protected $contractors_table;
    protected $projects_table;
    protected $positions_table;
    public function __construct(CustomRepository $customRepository){
        $this->conn                 = config('custom_config.database.lls_whip');
        $this->customRepository     = $customRepository;
        $this->contractors_table    = 'contractors';
        $this->projects_table       = 'projects';
        $this->positions_table      = 'positions';
    }
    public function index(){

        $data['title'] = 'Admin Dashboard';
        $data['title']              = 'User Dashboard';
        $data['count_contractors']  = $this->customRepository->q_get($this->conn,$this->contractors_table)->count();
        $data['count_whip_positions']  = $this->customRepository->q_get_where($this->conn,array('type' => 'whip'),$this->positions_table)->count();
        $data['pending_projects']    = $this->customRepository->q_get_where($this->conn,array('project_status' => 'ongoing'),$this->projects_table)->count();
        $data['completed_projects']  = $this->customRepository->q_get_where($this->conn,array('project_status' => 'completed'),$this->projects_table)->count();
        return view('systems.lls_whip.whip.admin.pages.dashboard.dashboard')->with($data);
    }
}
