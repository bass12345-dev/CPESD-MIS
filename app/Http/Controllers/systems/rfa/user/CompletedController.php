<?php

namespace App\Http\Controllers\systems\rfa\user;

use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\rfa\user\RFAQuery;
use Illuminate\Http\Request;

class CompletedController extends Controller
{
   
    protected $conn;
    protected $customRepository;
    protected $rFAQuery;

    public function __construct(CustomRepository $customRepository, RFAQuery $rFAQuery){
       
        $this->customRepository = $customRepository;
        $this->conn             = config('custom_config.database.pmas');
        $this->rFAQuery         = $rFAQuery;
    }
    public function index(){
        $data['title']                      = 'Completed Transactions';
        return view('systems.rfa.user.pages.completed.completed')->with($data);
    }



  
}
