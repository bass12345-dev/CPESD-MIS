<?php

namespace App\Http\Controllers\systems\lls_whip\whip\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Repositories\CustomRepository;
use App\Repositories\whip\ProjectQuery;

class MonitoringController extends Controller
{   
    protected $conn;
    protected $customRepository;
    protected $projectQuery;
    protected $monitoring_table;
    public function __construct(CustomRepository $customRepository, ProjectQuery $projectQuery){
        $this->conn                 = config('custom_config.database.lls_whip');
        $this->customRepository     = $customRepository;
        $this->projectQuery        = $projectQuery;
        $this->monitoring_table     = 'project_monitoring';
    }
    public function add_monitoring_view(){
        $data['title'] = 'Add New Monitoring';
        return view('systems.lls_whip.whip.user.pages.project_monitoring.add_new.add_new')->with($data);
    }

    public function pending_project_monitoring_view(){
        $data['title'] = 'Pending Project Monitoring';
        return view('systems.lls_whip.whip.user.pages.project_monitoring.pending_list.lists')->with($data);
    }  
    
    public function project_monitoring_information(){
        $data['title'] = 'Pending Project Monitoring';
        return view('systems.lls_whip.whip.user.pages.project_monitoring.view_monitoring.view_monitoring')->with($data);
    }


    //CREATE
    public function insert_project_monitoring(Request $request){
    
        $items = array(
            'project_id'            => $request->input('project_id'),
            'date_of_monitoring'    => $request->input('date_of_monitoring'),
            'specific_activity'     => $request->input('specific_activity'),
            'annotations'           => $request->input('annotations'),
            'monitoring_status'     => 'pending',
            'added_by'              => session('user_id'),
            'created_on'            => Carbon::now()->format('Y-m-d H:i:s'),
        );

        $insert = $this->customRepository->insert_item($this->conn,$this->monitoring_table,$items);
        if ($insert) {
            // Registration successful
            return response()->json([
                'message' => 'Project Monitoring Added Successfully', 
                'response' => true
            ], 201);
        }else {
            return response()->json([
                'message' => 'Something Wrong', 
                'response' => false
            ], 422);
        }   
    }

    //READ
    public function get_user_project_monitoring(){

        $contractors = $this->projectQuery->get_user_monitoring($this->conn);
        $items = [];
        foreach ($contractors as $row) {
           $items[] = array(
                    'project_monitoring_id'         => $row->contractor_id,
                    'project_title'                 => $row->project_title,
                    'date_of_monitoring'            => date('M d Y ', strtotime($row->date_of_monitoring)),
                    'specific_activity'             => $row->specific_activity,
                    'monitoring_status'             => $row->monitoring_status,
                    'contractor'                    => $row->contractor_name,
                   
           );
        }

        return response()->json($items);
    }
    //UPDATE
    //DELETE



   
}
