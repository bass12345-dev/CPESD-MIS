<?php

namespace App\Http\Controllers\system_management;

use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Services\CustomService;
use App\Services\user\USerService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ManageUserController extends Controller
{

    protected $conn;
    protected $customRepository;
    protected $customService;
    protected $userService;
    protected $user_table;
    protected $user_system_authorized_table;
    public function __construct(CustomRepository $customRepository, USerService $uSerService, CustomService $customService){
        $this->customRepository     = $customRepository;
        $this->userService          = $uSerService;
        $this->customService        = $customService;
        $this->conn                 = config('custom_config.database.users');
        $this->user_table           = 'users';
        $this->user_system_authorized_table = 'user_system_authorized';
    }
    public function index(){
        $data['title']  = 'Manage Users';
        return view('system_management.contents.manage_users.manage_users')->with($data);
    }

    public function get_all_users(){
        $items = $this->customRepository->q_get_where($this->conn,array('user_type' => 'user'),$this->user_table)->get();
        $data = [];
        $i = 1;
        foreach ($items as $value => $key) {
            $data[] = array(
                'i'                     => $i++,
                'user_id'               => $key->user_id,
                'full_name'             => $this->customService->user_full_name($key),
                'username'              => $key->username,
                'address'               => $key->address,
                'email_address'         => $key->email_address,
                'phone_number'          => $key->contact_number,
                'status'                => $key->user_status
            );
            
    }
    return response()->json($data);
}

public function view_profile($id){
    $row                = $this->customRepository->q_get_where($this->conn,array('user_id' => $id),$this->user_table)->first();
    $row_sys_count      = $this->customRepository->q_get_where($this->conn,array('user_id' => $id),$this->user_system_authorized_table);
    $row_sys            = $row_sys_count->count() > 0 ?  $row_sys_count->get() : '';
    $row_sys_explode    = explode(',',$row_sys);
    $data['title']      = $this->customService->user_full_name($row);
    $data['systems']    = $this->userService->get_systems($row_sys_explode);
    $data['user']       = $row;
    return view('system_management.contents.manage_users.view_profile.view_profile')->with($data);
}

public function authorize_system(Request $request){

    $ids            = $request->input('id');
    $user_id      = $request->input('user_id');
    if (is_array($ids)) {
        $this->customRepository->delete_item($this->conn,$this->user_system_authorized_table,array('user_id' => $user_id));
        $systems_implode = implode(",", $ids);
       
        $items = array(
                'user_id'                   => $request->input('user_id'),
                'system_authorized'         => $systems_implode,
                'updated_on'                => Carbon::now()->format('Y-m-d H:i:s'),
            );
        $insert = $this->customRepository->insert_item($this->conn,$this->user_system_authorized_table,$items);
        if ($insert) {
            // Registration successful
            return response()->json([
                'message' => 'Updated Successfully', 
                'response' => true
            ], 201);
    } else {
        $delete =   $this->customRepository->delete_item($this->conn,$this->user_system_authorized_table,array('user_id' => $user_id));
        if($delete){
            return response()->json([
                'message' => 'Removed Successfully', 
                'response' => true
            ], 201);
        }else {
            return response()->json([
                        'message' => 'Something Wrong', 
                        'response' => false
                    ], 422);
        }
    }
    }
}

}