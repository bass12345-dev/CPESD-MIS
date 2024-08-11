<?php

namespace App\Http\Controllers\systems\lls_whip\lls\both;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EstablishmentsController extends Controller
{
    public function add_new_establishments(){

        $data['title'] = 'Add New Establishment';
        $data['barangay'] = config('custom_config.barangay');
        return view('systems.lls_whip.lls.both.establishments.add_new.add_new')->with($data);
    }


    public function establishments_list(){

        $data['title'] = 'Establishment List';
        return view('systems.lls_whip.lls.both.establishments.lists.lists')->with($data);
    }
}
