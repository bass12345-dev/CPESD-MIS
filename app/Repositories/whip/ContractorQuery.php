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






    
}