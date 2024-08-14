<?php

namespace App\Repositories\whip;

use Illuminate\Support\Facades\DB;

class ProjectQuery
{
  protected $conn;
  protected $default_city;
  public function __construct(){
    $this->conn                 = config('custom_config.database.lls_whip');
    $this->default_city         = config('custom_config.default_city');
  }
    public function q_search($conn,$search){
        $rows = DB::connection($conn)->table('projects as projects')
        ->select(   
                    //Employee
                    'project_id', 
                    'project_title', 
                   
        )
        ->where('project_title', 'LIKE', "%" . $search . "%")
        ->orderBy('project_title', 'asc')->get();
        return $rows;
    }

    //All Projects
    public function QueryAllProjects(){

      $rows = DB::connection($this->conn)->table('projects as projects')
        ->leftJoin('contractors', 'contractors.contractor_id', '=', 'projects.contractor_id')
        ->leftJoin('project_nature', 'project_nature.project_nature_id', '=', 'projects.project_nature_id')
        ->leftJoin('project_monitoring', 'project_monitoring.project_id', '=', 'projects.project_id')
        ->select(   
                  DB::raw('COUNT(project_monitoring.project_id) as monitoring_count'),
                  //Contractors
                  'contractors.contractor_id as contractor_id', 
                  'contractors.contractor_name as contractor_name',
                  'contractors.status as contractor_status' ,
                  //Project Nature
                  'project_nature.project_nature as project_nature', 
                  //Projects
                  'projects.project_id as project_id',
                  'projects.project_title as project_title',
                  'projects.street as street',
                  'projects.barangay as barangay',
                  'projects.project_cost as project_cost',
                  'projects.project_status as project_status',
                  'projects.date_started as date_started'         

      )
      ->where('contractors.status', 'active')
      ->groupBy('project_monitoring.project_id')
      ->groupBy('projects.project_id')
      ->orderBy('projects.project_id', 'desc')
      ->get();
     
      return $rows;

    }


    //User Project Information
    public function get_user_monitoring(){

        $rows = DB::connection($this->conn)->table('project_monitoring as project_monitoring')
          ->leftJoin('projects', 'projects.project_id', '=', 'project_monitoring.project_id')
          ->leftJoin('contractors', 'contractors.contractor_id', '=', 'projects.contractor_id')
          ->select(   
                    //Contractors
                    'contractors.contractor_id as contractor_id', 
                    'contractors.contractor_name as contractor_name',
                    'contractors.status as contractor_status' ,
                    
                    //Project Monitoring
                    'project_monitoring.date_of_monitoring as date_of_monitoring',
                    'project_monitoring.specific_activity as specific_activity',
                    'project_monitoring.monitoring_status as monitoring_status',
                    'project_monitoring.project_monitoring_id as project_monitoring_id',

                    //Projects
                    'projects.project_id as project_id',
                    'projects.project_title as project_title',
                    'projects.street as street',
                    'projects.barangay as barangay',
                    'projects.project_cost as project_cost',
                    'projects.project_status as project_status',
                    'projects.date_started as date_started'         

        )
        ->where('contractors.status', 'active')
        ->orderBy('project_monitoring_id', 'desc')
        ->get();
       
        return $rows;
  
      }

    //Project Monitoring Information
    public function get_monitoring_information($where){

      $rows = DB::connection($this->conn)->table('project_monitoring as project_monitoring')
          ->leftJoin('projects', 'projects.project_id', '=', 'project_monitoring.project_id')
          ->leftJoin('contractors', 'contractors.contractor_id', '=', 'projects.contractor_id')
          ->select(   
                    //Contractors
                    'contractors.contractor_id as contractor_id', 
                    'contractors.contractor_name as contractor_name',
                    'contractors.status as contractor_status' ,
                    
                    //Project Monitoring
                    'project_monitoring.date_of_monitoring as date_of_monitoring',
                    'project_monitoring.specific_activity as specific_activity',
                    'project_monitoring.annotations as annotations',
                    'project_monitoring.monitoring_status as monitoring_status',
                    'project_monitoring.project_monitoring_id as project_monitoring_id',

                    //Projects
                    'projects.project_id as project_id',
                    'projects.project_title as project_title',
                    'projects.street as street',
                    'projects.barangay as barangay',
                    'projects.project_cost as project_cost',
                    'projects.project_status as project_status',
                    'projects.date_started as date_started'         

        )
        ->where('contractors.status', 'active')
        ->where($where);
       
        return $rows;

    }


    //Project Employee
    public function get_project_employee($id){

      $rows = DB::connection($this->conn)->table('project_employee as project_employee')
          ->leftJoin('employees', 'employees.employee_id', '=', 'project_employee.employee_id')
          ->leftJoin('positions','positions.position_id','=','project_employee.position_id')
          ->leftJoin('employment_status','employment_status.employment_status_id','=','project_employee.status_of_employment_id')
          ->select(   
            'project_employee.project_employee_id as project_employee_id',
            //User
            'employees.first_name as first_name',
            'employees.middle_name as middle_name',
            'employees.last_name as last_name',
            'employees.extension as extension',
            'employees.province as province',
            'employees.city as city',
            'employees.barangay as barangay',
            'employees.street as street',
            'employees.gender as gender',
            //Position
            'positions.position_id as position_id',
            'positions.position as position',
            //Status
            'employment_status.employment_status_id as employment_status_id',
            'employment_status.status as status',
            //Nature of Employment
            'project_employee.employee_id as employee_id',
            'project_employee.nature_of_employment as nature_of_employment',
            'project_employee.start_date as start_date',
            'project_employee.end_date as end_date',
            'project_employee.level_of_employment as level_of_employment'

                    

        )
        ->where('project_monitoring_id',$id)
        ->orderBy('first_name', 'desc')
        ->get();
        return $rows;


    }

    public function query_contractor_projects($id){

      $rows = DB::connection($this->conn)->table('projects as projects')
      ->leftJoin('project_nature', 'project_nature.project_nature_id', '=', 'projects.project_nature_id')
      ->select(   
        //Project Nature
        'project_nature.project_nature as project_nature', 
        //Projects
        'projects.project_id as project_id',
        'projects.project_title as project_title',
        'projects.street as street',
        'projects.barangay as barangay',
        'projects.project_cost as project_cost',
        'projects.project_status as project_status',
        'projects.date_started as date_started',         
        'projects.date_completed as date_completed'         
      )
      ->where('contractor_id',$id)
      ->orderBy('date_started', 'desc')
      ->get();

      return $rows;


    }




    
}