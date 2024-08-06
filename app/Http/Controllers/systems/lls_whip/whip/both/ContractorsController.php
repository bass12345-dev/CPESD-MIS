<?php

namespace App\Http\Controllers\systems\lls_whip\whip\both;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContractorsController extends Controller
{
    public function add_new_contractor(){
        $data['title'] = 'Add New Contractor';
        return view('systems.lls_whip.whip.both.contractors.add_new.add_new')->with($data);
    }

    public function contractors_list(){
        $data['title'] = 'Contractors List';
        return view('systems.lls_whip.whip.both.contractors.lists.lists')->with($data);
    }
}
