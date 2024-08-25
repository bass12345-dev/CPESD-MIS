<?php

namespace App\Http\Controllers\systems\rfa\admin;
use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\rfa\admin\AdminRFAQuery;
use App\Services\CustomService;
use App\Services\user\UserService;
use Illuminate\Http\Request;

class PendingController extends Controller
{

    protected $conn;
    protected $customRepository;
    protected $customService;
    protected $userService;
    protected $rFAQuery;

    public function __construct(CustomRepository $customRepository, AdminRFAQuery $rFAQuery, CustomService $customService, UserService $userService){
       
        $this->customRepository = $customRepository;
        $this->customService    = $customService;
        $this->userService      = $userService;
        $this->conn             = config('custom_config.database.pmas');
        $this->rFAQuery         = $rFAQuery;
    }
    public function index(){
        $data['title']                                  = 'Pending';
        return view('systems.rfa.admin.pages.pending.pending')->with($data);
    }

    public function get_admin_pending_rfa(){

        $data = [];
        $items = $this->rFAQuery->QueryPendingRFA();

        foreach ($items as $row) {

            $action1 = '';
            $status1 = '';

            
            if ($row->reffered_to == NULL ) {
                    $status1 = '<a href="javascript:;" class="btn btn-danger btn-rounded p-1 pl-2 pr-2">needs to be refer</a>';
                    $action1 = '<div class="btn-group dropleft">
                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ti-settings" style="font-size : 15px;"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:;" data-id="'.$row->rfa_id.'" id="refer_to" data-toggle="modal" data-target="#refer_to_modal"  >Refer to</a>
                                </di>';
                }else if ($row->reffered_to != NULL && $row->accomplished_status == 0) {
     
                    $status1 = '<a href="javascript:;" class="btn btn-warning btn-rounded p-1 pl-2 pr-2">Referred</a>
                     <br>'.$row->reffered_first_name.' '.$row->reffered_middle_name.' '.$row->reffered_last_name.' '.$row->reffered_extension;
                     $action1 = '<ul class="d-flex justify-content-center">
                                <li class="mr-3 "><a href="javascript:;" class="text-secondary action-icon" data-id="'.$row->rfa_id.'"   id="view_rfa_" ><i class="fa fa-eye"></i></a></li>
                                </ul>';
                }else if ($row->reffered_to != NULL && $row->accomplished_status == 1) {
                    $status1 = '<a href="javascript:;" class="btn btn-success btn-rounded p-1 pl-2 pr-2">Accomplished</a><br>
                                <a href="javascript:;" id="view_action" data-id="'.$row->rfa_id.'" >View</a><br>'.$row->reffered_first_name.' '.$row->reffered_middle_name.' '.$row->reffered_last_name.' '.$row->reffered_extension;
                    $action1 = '<ul class="d-flex justify-content-center">
                                <li class="mr-3 "><a href="javascript:;" class="text-success action-icon"  id="approved" data-id="'.$row->rfa_id.'" data-name="'.$this->customService->ref_number($row).'"  ><i class="fa fa-check"></i></a></li>
                                <li class="mr-3 "><a href="javascript:;" class="text-secondary action-icon" data-id="'.$row->rfa_id.'"   id="view_rfa_" ><i class="fa fa-eye"></i></a></li>
                                </ul>'; 
                }

                $data[] = array(

                                    'rfa_id'               => $row->rfa_id ,
                                    'encoded_by'            => $this->userService->user_full_name($row),
                                    'name'                  => $row->client_first_name.' '.$row->client_middle_name.' '.$row->client_last_name.' '.$row->client_extension,
                                    'type_of_request_name'  => $row->type_of_request_name,
                                    'type_of_transaction'   => $row->type_of_transaction,
                                    'address'               => $row->client_purok == 0 ? $row->client_barangay : 'Purok '.$row->client_purok.' '.$row->client_barangay,
                                    'status1'               => $status1,
                                    'action1'               => $action1,
                                    'ref_number'           => $this->customService->ref_number($row),                       
                            );

        }

        return response()->json($data);
    }



  
}
