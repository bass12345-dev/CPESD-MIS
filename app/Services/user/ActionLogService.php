<?php 
namespace App\Services\user;
use App\Repositories\CustomRepository;
use Carbon\Carbon;
class ActionLogService
{   
    protected $customRepository;
    protected $now;
    protected $conn;
    public function __construct(CustomRepository $customRepository)
    {
        $this->conn                 = config('custom_config.database.dts');
        $this->now                  =  Carbon::now();
        $this->customRepository     = $customRepository;
        
    }

    public function dts_add_action($action,$user_type,$_id){

        $items  = array(
            'action'            => $action,
            'web_type'          => 'dts',
            'user_type'         => $user_type,
            'user_id'           =>  session('user_id'),
            '_id'               =>  $_id,
            'action_datetime'   => Carbon::now()->format('Y-m-d H:i:s'),
           
        );
        
        $this->customRepository->insert_item($this->conn,'action_logs', $items);
    }

    // public function AllActionLogs($month,$year){

    //    if($month == '' && $year == ''){
    //         $items =  $this->adminRepository->get_actions_dts();
    //    }else {
    //         $items           =  $this->adminRepository->get_actions_dts_by_month($month,$year);
    //    }
    //    $i                    = 1;
    //    $data = [];
    //    foreach ($items as $value => $key) {
    //     $data[] = array(
    //         'number'            => $i++,
    //         'name'              => $key->first_name . ' ' . $key->middle_name . ' ' . $key->last_name . ' ' . $key->extension,
    //         'user_type'         => $key->user_type,
    //         'tracking_number'   => $key->tracking_number,
    //         'action'            => $key->action,
    //         'action_datetime'   => date('M d Y h:i A', strtotime($key->action_datetime))
            
    //     );
    // }

    // return $data;

    // }

}