<?php

namespace App\Http\Controllers\systems\lls_whip\whip\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\whip\ProjectEmployeeStoreRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Repositories\CustomRepository;
use App\Repositories\whip\ProjectQuery;
use App\Services\CustomService;

class MonitoringController extends Controller
{   
    protected $conn;
    protected $customRepository;
    protected $customService;
    protected $projectQuery;
    protected $monitoring_table;
    protected $position_table;
    protected $employment_status_table;
    protected $project_employee_table;
    public function __construct(CustomRepository $customRepository, ProjectQuery $projectQuery, CustomService $customService){
        $this->conn                 = config('custom_config.database.lls_whip');
        $this->customRepository     = $customRepository;
        $this->customService        = $customService;
        $this->projectQuery         = $projectQuery;
        $this->monitoring_table     = 'project_monitoring';
        $this->position_table       = 'positions';
        $this->employment_status_table = 'employment_status';
        $this->project_employee_table = 'project_employee';
    }
    public function add_monitoring_view(){
        $data['title'] = 'Add New Monitoring';
        return view('systems.lls_whip.whip.user.pages.project_monitoring.add_new.add_new')->with($data);
    }

    public function pending_project_monitoring_view(){
        $data['title'] = 'Pending Project Monitoring';
    return view('systems.lls_whip.whip.user.pages.project_monitoring.pending_list.lists')->with($data);
    }  
    
    public function project_monitoring_information($id){
        
        $count = $this->projectQuery->get_monitoring_information($this->conn,array('project_monitoring_id' => $id));
        if($count->count() > 0 ){
            $row                = $count->first();
            $data['title']      = 'Pending Project Monitoring '.$row->project_title;
            $data['row']        = $row;
            $data['positions']    =  $this->customRepository->q_get_where_order($this->conn,$this->position_table,array('type' => 'whip'),'position','asc')->get();
            $data['employment_status']      = $this->customRepository->q_get_order($this->conn,$this->employment_status_table,'status','asc')->get();
            $data['nature_of_employment']   = config('custom_config.whip_nature_of_employment');
            $data['level_of_employment']    = config('custom_config.level_of_employment');
            return view('systems.lls_whip.whip.user.pages.project_monitoring.view_monitoring.view_monitoring')->with($data);
        }else {
            echo '404';
        }
       
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

    public function insert_update_project_employee(ProjectEmployeeStoreRequest $request){
        $row = $request->validated();
   
        $items = array(
            'employee_id'                   => $row['employee_id'],
            'project_id'                   => $row['project_id'],
            'position_id'                   => $row['position'],
            'nature_of_employment'          => $row['employment_nature'],
            'status_of_employment_id'       => $row['employment_status'],  
            'start_date'                    => NULL,
            'end_date'                      => NULL,
            'level_of_employment'              => $row['employment_level'],
            'project_monitoring_id'         => $row['project_monitoring_id'],
            'created_on'                    => Carbon::now()->format('Y-m-d H:i:s')
        );
        $insert = $this->customRepository->insert_item($this->conn,$this->project_employee_table,$items);
        if ($insert) {
            // Registration successful
            return response()->json([
                'message' => 'Employee Added Successfully', 
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
                    'project_monitoring_id'         => $row->project_monitoring_id,
                    'project_title'                 => $row->project_title,
                    'date_of_monitoring'            => date('M d Y ', strtotime($row->date_of_monitoring)),
                    'specific_activity'             => $row->specific_activity,
                    'monitoring_status'             => $row->monitoring_status,
                    'contractor'                    => $row->contractor_name,
                    'address'                       => $row->barangay.' '.$row->street
                   
           );
        }

        return response()->json($items);
    }


    public function get_all_project_employee(Request $request){
       $items = $this->projectQuery->get_project_employee($this->conn,$request->input('id'));
       $data = [];
        foreach ($items as $row) {
           $data[] = array(
                    'project_employee_id'   => $row->project_employee_id,
                    'employee_id'           => $row->employee_id,
                    'full_name'             => $this->customService->user_full_name($row),
                    'full_address'          => $this->customService->full_address($row),
                    'position'              => $row->position,
                    'position_id'           => $row->position_id,
                    'nature_of_employment'  => $row->nature_of_employment,
                    'status_id'             => $row->employment_status_id,
                    'status_of_employment'  => $row->status,
                    'start_date'            =>  $row->start_date == NULL ? '-' :  Carbon::parse($row->start_date)->format('M Y'),
                    'end_date'              => $row->end_date == NULL ? '-' :  Carbon::parse($row->end_date)->format('M Y'),
                    'level_of_employment'   => $row->level_of_employment,
                    'gender'                => $row->gender
           );
        }
        return response()->json($data);
    }
    //UPDATE
    public function update_project_monitoring(Request $request){
        $where = array('project_monitoring_id' => $request->input('project_monitoring_id'));
        $items = array(

                    'date_of_monitoring'    => $request->input('date_of_monitoring'),
                    'specific_activity'     => $request->input('specific_activity'),   
                    'annotations'           => $request->input('annotations'),
        );

        $update = $this->customRepository->update_item($this->conn,$this->monitoring_table,$where,$items);
        if ($update) {
        // Registration successful
        return response()->json([
            'message' => 'Project Monitoring Updated Successfully', 
            'response' => true
        ], 201);

        }else {
                return response()->json([
                    'message' => 'Something Wrong', 
                    'response' => false
                ], 422);
            }
    }
    //DELETE



   
}
