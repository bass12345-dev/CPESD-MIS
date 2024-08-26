<?php

namespace App\Http\Controllers\systems\pmas\user;
use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\pmas\user\UserPmasQuery;
use App\Services\CustomService;
use App\Services\user\ActionLogService;
use App\Services\user\UserService;
use Illuminate\Http\Request;

class PendingController extends Controller
{

    protected $conn;
    protected $conn_user;
    protected $customRepository;
    protected $userService;
    protected $actionLogService;
    protected $customService;
    protected $userPmasQuery;

    public function __construct(CustomRepository $customRepository,  UserService $userService,UserPmasQuery $userPmasQuery, ActionLogService $actionLogService, CustomService $customService)
    {

        $this->customRepository = $customRepository;
        $this->userPmasQuery    = $userPmasQuery;
        $this->userService = $userService;
        $this->actionLogService = $actionLogService;
        $this->customService    = $customService;
        $this->conn = config('custom_config.database.pmas');
        $this->conn_user = config('custom_config.database.users');

    }
    public function index()
    {
        $data['title']      = 'Pending';
        $data['pass_to']    = $this->customRepository->q_get_where_order($this->conn_user,'users',array('user_type' => 'user'),'first_name','desc')->get(); 
        return view('systems.pmas.user.pages.pending.pending')->with($data);
    }


    public function get_user_pending_transactions(){

        $data = [];


        $items = $this->userPmasQuery->QueryUserPendingTransactions();

        foreach ($items as $row ) {


            $action = '';
            $status_display = '';
            $update_status_display = '';
            $updated_status = '';

            if ($row->remarks == '' AND $row->action_taken_date == null) {
                if ($row->update_status == 'updated') {
                    $update_status_display  = '<a class="dropdown-item text-success" href="javascript:;"> 
                                                    <i class="ti-check"></i> Last Updated </br>'.date('F d, Y', strtotime($row->updated_on)).' '.date('h:i a', strtotime($row->updated_on)).'
                                                </a>';
                }else {
                    $update_status_display  = '<a class="dropdown-item text-danger" href="javascript:;">Not Updated</a>';
                }
                                    $action = '<div class="btn-group dropleft">
                                                    <button type="button" class="btn btn-secondary dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="ti-settings" style="font-size : 15px;"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="javascript:;" data-id="'.$row->transaction_id.'"  data-name="'.date('Y', strtotime($row->date_and_time_filed)).' - '.date('m', strtotime($row->date_and_time_filed)).' - '.$row->number.'"  id="update-transaction" > 
                                                                <i class="ti-eye"></i> View/Update Information
                                                        </a>
                                                        <a class="dropdown-item" href="javascript:;" id="pass_to" data-id="'.$row->transaction_id.'"  data-name="'.date('Y', strtotime($row->date_and_time_filed)).' - '.date('m', strtotime($row->date_and_time_filed)).' - '.$row->number.'"  data-toggle="modal" data-target="#pass_to_modal"> 
                                                            <i class="ti-arrow-right"></i> Pass to
                                                        </a>
                                                    </div>
                                                </div>';
                            $status_display = '<a href="javascript:;" class="btn btn-secondary btn-rounded p-1 pl-2 pr-2">Wait for Remarks....</a>'.' '. $update_status_display;
            }else if ($row->remarks != '' AND $row->action_taken_date == null) {
                                    $action = '<div class="btn-group dropleft">
                                                    <button type="button" class="btn btn-secondary dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="ti-settings" style="font-size : 15px;"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="javascript:;" data-id="'.$row->transaction_id.'"  data-name="'.date('Y', strtotime($row->date_and_time_filed)).' - '.date('m', strtotime($row->date_and_time_filed)).' - '.$row->number.'"  id="update-transaction" > 
                                                            <i class="ti-eye"></i> View/Update Information
                                                        </a>
                                                    </di>
                                                </div>';
                $status_display = '<a href="javascript:;" class="btn btn-danger btn-rounded p-1 pl-2 pr-2">remarks added</a><br><a href="javascript:;"  data-id="'.$row->transaction_id.'" id="view-remarks">View Remarks</a>';
            }else if ($row->remarks != '' AND $row->action_taken_date != null) {
                                    $action = '<ul class="d-flex justify-content-center">
                                                        <li class="mr-3 ">
                                                            <a href="javascript:;" class="text-secondary action-icon" data-id="'.$row->transaction_id.'" data-status="'.$row->transaction_status.'"  id="view_transaction" >
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        </li>
                                                </ul>';
                $status_display = '<a href="javascript:;" class="btn btn-success btn-rounded p-1 pl-2 pr-2">Accomplished || For Approval</a>';
                
            }


            $data[] = array(
                            'transaction_id'                => $row->transaction_id,
                            'pmas_no'                       => date('Y', strtotime($row->date_and_time_filed)).' - '.date('m', strtotime($row->date_and_time_filed)).' - '.$row->number,
                            'date_and_time_filed'           => date('F d Y', strtotime($row->date_and_time_filed)).' '.date('h:i a', strtotime($row->date_and_time_filed)),
                            'responsible_section'           => $row->responsible_section_name,
                            'type_of_activity_name'         => $row->type_of_activity_name,
                            'responsibility_center'         => $row->responsibility_center_code.' - '.$row->responsibility_center_name,
                            'date_and_time'                 => date('M,d Y', strtotime($row->date_and_time)).' '.date('h:i a', strtotime($row->date_and_time)),
                            'is_training'                   => $row->is_training == 1 ? true : false,
                            'is_project_monitoring'         =>  $row->is_project_monitoring == 1 ? true : false,
                            'name'                          => $row->first_name.' '.$row->middle_name.' '.$row->last_name.' '.$row->extension,
                            's'                             => $status_display,
                            'action'                        => $action,
                );

        }

        return response()->json($data);

    }


    public function pass_pmas(Request $request){
        $where   = array('transaction_id' => $request->input('pmas_id'));
        $data    = array('created_by'    => $request->input('pass_to_id'));


        $update = $this->customRepository->update_item($this->conn, 'transactions', $where, $data);

        if ($update) {
            $user = $this->customRepository->q_get_where($this->conn_user, array('user_id' => $data['created_by']), 'users')->first();
            $pmas_item = $this->customRepository->q_get_where($this->conn, array('transaction_id' => $where['transaction_id']), 'transactions')->first();
            $this->actionLogService->add_pmas_rfa_action('pmas', $pmas_item->transaction_id, 'Passed PMAS No. '.$this->customService->pmas_number($pmas_item).' to '.$user->first_name.' '.$user->last_name);
            $resp = array('message' => 'Passed PMAS Successfully', 'response' => true);
        } else {
            $resp = array('message' => 'Error', 'response' => false);
        }
        return response()->json($resp);
    }


    public function get_pending_transaction_limit(){

        $data = [];
        $items = $this->userPmasQuery->QueryTransactionsLimit(20);
        foreach ($items as $row ) {
            $data[] = array(
                                'transaction_id'        => $row->transaction_id,
                                'pmas_no'               => $this->customService->pmas_number($row),
                                'date_and_time_filed'   => date('F d Y', strtotime($row->date_and_time_filed)).' '.date('h:i a', strtotime($row->date_and_time_filed)),
                                'responsible_section'   => $row->responsible_section_name,
                                'type_of_activity_name' => $row->type_of_activity_name,
                                'responsibility_center' => $row->responsibility_center_code.' - '.$row->responsibility_center_name,
                                'date_and_time'         => date('F d Y', strtotime($row->date_and_time)).' '.date('h:i a', strtotime($row->date_and_time)),
                                'is_training'           => $row->is_training == 1 ? true : false,
                                'is_project_monitoring' =>  $row->is_project_monitoring == 1 ? true : false,
                                'name'                  => $row->first_name.' '.$row->middle_name.' '.$row->last_name.' '.$row->extension,
                                'cso_name'              => $row->cso_name,
                                'type_of_activity' => $row->type_of_activity_name,      
                    );
        }
    
        return response()->json($data);
    }




}
