<?php

namespace App\Http\Controllers\systems\lls_whip\whip\both;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\whip\ContractorStoreRequest;
use App\Repositories\CustomRepository;
use App\Repositories\whip\ContractorQuery;
use App\Services\CustomService;
use App\Services\whip\ContractorsService;

class ContractorsController extends Controller
{
    protected $contractorService;
    protected $customService;
    protected $customRepository;
    protected $Contractorquery;
    protected $conn;
    protected $contractors_table;
    protected $order_by_asc = 'asc';
    protected $order_by_key = 'contractor_id';
    public function __construct(CustomRepository $customRepository, ContractorsService $contractorService, ContractorQuery $contractorQuery, CustomService $customService){
        $this->conn                 = config('custom_config.database.lls_whip');
        $this->customRepository     = $customRepository;
        $this->contractorService    = $contractorService;
        $this->customService        = $customService;
        $this->contractors_table    = 'contractors';
        $this->Contractorquery      = $contractorQuery;
    }
    public function add_new_contractor(){
        $data['title'] = 'Add New Contractor';
        return view('systems.lls_whip.whip.both.contractors.add_new.add_new')->with($data);
    }

    public function contractors_list(){
        $data['title'] = 'Contractors List';
        return view('systems.lls_whip.whip.both.contractors.lists.lists')->with($data);
    }

    //CREATE
    public function insert_contractor(ContractorStoreRequest $request){
        $validatedData = $request->validated();
        $insert = $this->contractorService->registerContractor($validatedData);
        
        if ($insert) {
            // Registration successful
            return response()->json([
                'message' => 'Contractor Added Successfully', 
                'response' => true
            ], 201);
        }else {
            return response()->json([
                'message' => 'Something Wrong', 
                'response' => false
            ], 422);
        }
    }
    //READ
    public function get_all_contractors(){
        $contractors = $this->customRepository->q_get_order($this->conn,$this->contractors_table,$this->order_by_key,$this->order_by_asc)->get();
        $items = [];
        foreach ($contractors as $row) {
           $items[] = array(
                    'contractor_id'         => $row->contractor_id,
                    'contractor_name'       => $row->contractor_name,
                    'proprietor'            => $row->proprietor,
                    'full_address'          => $this->customService->full_address($row),
                    'phone_number'          => $row->phone_number,
                    'phone_number_owner'    => $row->phone_number_owner,
                    'telephone_number'      => $row->telephone_number,
                    'email_address'         => $row->email_address,
                    'status'                => $row->status
           );
        }

        return response()->json($items);
    }
    //UPDATE
    //DELETE
    public function delete_contractors(Request $request){
        $id = $request->input('id')['id'];
        if (is_array($id)) {
            foreach ($id as $row) {
               $where = array('contractor_id' => $row);
               $this->customRepository->delete_item($this->conn,$this->contractors_table,$where);
            }

            $data = array('message' => 'Deleted Succesfully', 'response' => true);
        } else {
            $data = array('message' => 'Error', 'response' => false);
        }
        return response()->json($data);
    }

    //SEARCH
    public function search_query(){
        $q = trim($_GET['key']);
        $emp = $this->Contractorquery->q_search($this->conn,$q);
        $data = [];
        foreach ($emp as $row) {
            $data[] = array(
                'contractor_id'      => $row->contractor_id,
                'contractor_name'    => $row->contractor_name,
                
            );
        }
        return response()->json($data);
    }
}
