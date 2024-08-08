<?php

namespace App\Repositories\whip;

use Illuminate\Support\Facades\DB;

class ProjectQuery
{
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


    public function QueryAllProjects($conn){

      $rows = DB::connection($conn)->table('projects as projects')
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



    public function get_user_monitoring($conn){

        $rows = DB::connection($conn)->table('project_monitoring as project_monitoring')
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







    
}