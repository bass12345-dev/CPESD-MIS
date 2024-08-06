<?php

namespace App\Repositories\whip;

use Illuminate\Support\Facades\DB;

class ContractorQuery
{
    public function q_search($conn,$search){
        $rows = DB::connection($conn)->table('contractors as contractors')
        ->select(   
                    //Employee
                    'contractors.contractor_id as contractor_id', 
                    'contractors.contractor_name as contractor_name', 
                   
        )
        ->where('contractor_name', 'LIKE', "%" . $search . "%")
        ->orderBy('contractor_name', 'asc')->get();
        return $rows;
    }


    public function QueryAllProjects($conn){

        $rows = DB::connection($conn)->table('projects as projects')
          ->leftJoin('contractors', 'contractors.contractor_id', '=', 'projects.contractor_id')
          ->select(   
                    //Contractors
                    'contractors.contractor_id as contractor_id', 
                    'contractors.contractor_name as contractor_name',
                    'contractors.status as contractor_status' ,

                    //Projects
                    'projects.project_id as project_id',
                    'projects.project_title as project_title',
                    'projects.street as street',
                    'projects.barangay as barangay',
                    'projects.city as city',
                    'projects.province as province', 
                    'projects.project_cost as project_cost',
                    'projects.project_status as project_status'             

        )
        ->where('contractors.status', 'active')
        ->orderBy('project_id', 'desc')
        ->get();
       
        return $rows;
  
      }



    
}