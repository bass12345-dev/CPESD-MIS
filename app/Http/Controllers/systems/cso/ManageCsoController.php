<?php

namespace App\Http\Controllers\systems\cso;

use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\pmas\user\UserPmasQuery;
use App\Services\CustomService;
use App\Services\cso\CsoService;
use App\Services\user\ActionLogService;
use App\Services\user\UserService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ManageCsoController extends Controller
{

    protected $conn;
    protected $customRepository;
    protected $customService;
    protected $userService;
    protected $csoService;
    protected $userPmasQuery;
    protected $actionLogService;
    public function __construct(CustomRepository $customRepository, CustomService $customService, UserService $userService, UserPmasQuery $userPmasQuery, CsoService $csoService, ActionLogService $actionLogService)
    {

        $this->customRepository = $customRepository;
        $this->userPmasQuery    = $userPmasQuery;
        $this->customService = $customService;
        $this->userService = $userService;
        $this->csoService = $csoService;
        $this->actionLogService = $actionLogService;
        $this->conn = config('custom_config.database.pmas');
    }
    public function index()
    {
        $data['title'] = 'Manage CSO';
        $data['type_of_cso']        = config('custom_config.cso_type');
        $data['barangay']           = config('custom_config.barangay');
        $data['positions']          = config('custom_config.positions');
        return view('systems.cso.pages.manage_cso.manage_cso')->with($data);
    }

    public function view_cso($id)
    {
        $row = $this->customRepository->q_get_where($this->conn, array('cso_id' => $id), 'cso');
        if ($row->count()) {
            $row = $row->first();
            $data['title'] = $row->cso_name;
            $data['row']    = $row;
            return view('systems.cso.pages.view_cso.view_cso')->with($data);
        } else {
            echo '404';
        }
    }

    public function get_cso_infomation(Request $request)
    {

        $row = $this->customRepository->q_get_where($this->conn, array('cso_id' =>  $request->input('id')), 'cso')->first();

        $address = '';
        if ($row->barangay == '') {
            $address = '';
        } else if ($row->purok_number == '' && $row->barangay != '') {
            $address = $row->barangay;
        } else if ($row->purok_number != '' && $row->barangay != '') {
            $address = 'Purok ' . $row->purok_number . ' ' . $row->barangay;
        }
        $data = array(
            'cso_id'            => $row->cso_id,
            'cso_name'          => $row->cso_name,
            'cso_code'          => $row->cso_code,
            'purok_number'      => $row->purok_number,
            'barangay'          => $row->barangay,
            'address'           => $address,
            'contact_person'    => $row->contact_person,
            'contact_number'    => $row->contact_number,
            'telephone_number'  => $row->telephone_number,
            'email_address'     => $row->email_address,
            'type_of_cso'       => strtoupper($row->type_of_cso),
            'status'            => $row->cso_status,
            'cso_status'        => $row->cso_status == 'active' ?  '<span class="status-p bg-success">' . ucfirst($row->cso_status) . '</span>' : '<span class="status-p bg-danger">' . ucfirst($row->cso_status) . '</span>',



        );

        return response()->json($data);
    }

    public function get_cso(Request $request)
    {
        $data = '';
        $where = array('cso_status' => $request->input('cso_status'), 'type_of_cso' => $request->input('cso_type'));
        if ($where['cso_status'] != '' &&  $where['type_of_cso'] == '') {
            $where_status = array('cso_status' => $where['cso_status']);
            $data = $this->csoService->cso_query_where($where_status);
        } else if ($where['type_of_cso'] != '' && $where['cso_status'] == '') {
            $where_status = array('type_of_cso' => $where['type_of_cso']);
            $data = $this->csoService->cso_query_where($where_status);
        } else if ($where['cso_status'] != '' &&  $where['type_of_cso'] != '') {
            $where_status = array('cso_status' => $where['cso_status'], 'type_of_cso' => $where['type_of_cso']);
            $data = $this->csoService->cso_query_where($where_status);
        } else if ($where['cso_status'] == '' &&  $where['type_of_cso'] == '') {
            $data = $this->csoService->all_cso();
        }

        return response()->json($data);
    }

    public function add_cso(Request $request)
    {

        $data = array(
            'cso_name'                  => $request->input('cso_name'),
            'cso_code'                  => $request->input('cso_code'),
            'type_of_cso'               => strtoupper($request->input('cso_type')),
            'purok_number'              => $request->input('purok'),
            'barangay'                  => $request->input('barangay'),
            'contact_person'            => ($request->input('contact_person') == '') ?  '' : $request->input('contact_person'),
            'contact_number'            => $request->input('contact_number'),
            'telephone_number'          => ($request->input('telephone_number') == '') ?  '' : $request->input('telephone_number'),
            'email_address'             => ($request->input('email_address') == '') ?  '' : $request->input('email_address'),
            'cso_status'                => 'active',
            'cso_created'               => Carbon::now()->format('Y-m-d H:i:s'),

        );

        $verify = $this->customRepository->q_get_where($this->conn, array('cso_code' => $data['cso_code']), 'cso')->count();
        if ($verify > 0) {

            $data = array(
                'message' => 'Error Duplicate Code',
                'response' => false
            );
        } else {

            $cso_id            = DB::connection($this->conn)->table('cso')->insertGetId($data);
            if ($cso_id) {
                $this->actionLogService->add_pmas_rfa_action('cso', $cso_id, 'Added CSO | ' . $data['cso_name']);
                $data = array(
                    'message' => 'CSO Added Succesfully',
                    'response' => true
                );
            } else {
                $data = array(
                    'message' => 'Something Wrong',
                    'response' => false
                );
            }
        }

        return response()->json($data);
    }

    public function delete_cso(Request $request)
    {
        $where1 = array('cso_Id' => $request->input('id'));
        $where2 = array('cso_id' => $request->input('id'));
        $check  = $this->customRepository->q_get_where($this->conn, $where1, 'transactions')->count();
        $cso    = $this->customRepository->q_get_where($this->conn, array('cso_id' => $where2['cso_id']), 'cso')->first();

        if ($check > 0) {
            $data = array(
                'message' => 'This CSO is used in other operations',
                'response' => false
            );
        } else {

            $result     = $this->customRepository->delete_item($this->conn, 'cso', $where2);
            if ($result) {
                $this->actionLogService->add_pmas_rfa_action('cso', $cso->cso_id, 'Deleted CSO | ' . $cso->cso_name);
                $data = array(
                    'message' => 'CSO Added Succesfully',
                    'response' => true
                );
            } else {
                $data = array(
                    'message' => 'Something Wrong',
                    'response' => false
                );
            }
        }

        return response()->json($data);
    }

    public function update_cso_status(Request $request)
    {
        $data = array(
            'cso_status' => $request->input('cso_status_update')
        );

        $where = array(
            'cso_id' => $request->input('cso_id')
        );

        $update     = $this->customRepository->update_item($this->conn, 'cso', $where, $data);
        if ($update) {
            $cso    = $this->customRepository->q_get_where($this->conn, array('cso_id' => $where['cso_id']), 'cso')->first();
            $this->actionLogService->add_pmas_rfa_action('cso', $cso->cso_id, 'Updated CSO Status | ' . $cso->cso_name);
            $resp = array(
                'message' => 'Successfully Updated',
                'response' => true
            );
        } else {

            $resp = array(
                'message' => 'Error',
                'response' => false
            );
        }
        return response()->json($resp);
    }


    public function get_officers(Request $request)
    {
        $data = [];
        $pid = 0;
        $id = 1;
        $item = $this->customRepository->q_get_where_order($this->conn,'cso_officers', array('officer_cso_id' => $request->input('cso_id')), 'position_number', 'asc');
        foreach ($item as $row) {

            $data[] = array(
                'id' => $id++,
                'pid' => $pid++,
                'name' => $row->first_name . ' ' . $row->middle_name . ' ' . $row->last_name . ' ' . $row->extension,
                'first_name' => $row->first_name,
                'middle_name' => $row->middle_name,
                'last_name' => $row->last_name,
                'extension' => $row->extension,
                'title' => explode("-", $row->cso_position)[0],
                'position' => $row->cso_position,
                'img' => "https://www.pngitem.com/pimgs/m/504-5040528_empty-profile-picture-png-transparent-png.png",
                'contact_number' => $row->contact_number,
                'email_address' => $row->email_address,
                'cso_officer_id' => $row->cso_officer_id,




            );
        }

        return response()->json($data);
    }
}
