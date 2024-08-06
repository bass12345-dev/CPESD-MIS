<?php

namespace App\Repositories\whip;

use Illuminate\Support\Facades\DB;

class EmployeeQuery
{

    public function get_project_employee($conn,$id){

        $rows = DB::connection($conn)->table('contractor_employee as contractor_employee')
        ->leftJoin('employees', 'employees.employee_id', '=', 'contractor_employee.employee_id')
        ->leftJoin('positions', 'positions.position_id', '=', 'contractor_employee.position_id')
        ->leftJoin('employment_status', 'employment_status.employ_stat_id', '=', 'contractor_employee.status_of_employment_id')
        ->select(   
        'contractor_employee.contractor_employee_id as contractor_employee_id',
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
        'employment_status.employ_stat_id as employ_stat_id',
        'employment_status.status as status',
        //Nature of Employment
        'contractor_employee.employee_id as employee_id',
        'contractor_employee.nature_of_employment as nature_of_employment',
        'contractor_employee.start_date as start_date',
        'contractor_employee.end_date as end_date',
        'contractor_employee.level_of_employment as level_of_employment'
      )
      ->where('contractor_employee.project_id', $id)
      ->orderBy('employees.first_name', 'asc')
      ->get();
    
    return $rows;

    }  
}