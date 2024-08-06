<?php

namespace App\Services\whip;

use App\Repositories\CustomRepository;
use Carbon\Carbon;

class ContractorsService
{

    protected $conn;
    protected $customRepository;
    protected $contractors_table;
    protected $contractor_employee_table;
    public function __construct(CustomRepository $customRepository)
    {
        $this->conn                         = config('app._database.lls_whip');
        $this->customRepository             = $customRepository;
        $this->contractors_table            = 'contractors';
        $this->contractor_employee_table    = 'contractor_employee';
    }


    //REGISTER USER
    public function registerContr(array $userData)
    {

        $items = array(
            'contractor_name'       => $userData['contractor_name'],
            'proprietor'            => $userData['proprietor'],
            'street'                => $userData['street'],
            'barangay'              => $userData['barangay'],
            'city'                  => $userData['city'],
            'province'              => $userData['province'],
            'phone_number'          => $userData['phone_number'],
            'phone_number_owner'    => $userData['phone_number_owner'],
            'telephone_number'      => $userData['telephone_number'],
            'email_address'         => $userData['email_address'],
            'status'                => 'active',
            'created_on'            => Carbon::now()->format('Y-m-d H:i:s'),

        );
        $user = $this->customRepository->insert_item($this->conn, $this->contractors_table, $items);
        return $user;
    }


    public function insert_contractor_employee(array $items)
    {
        $data = [];;
        $count = $this->customRepository->q_get_where($this->conn, array('employee_id' => $items['employee_id'], 'contractor_id' => $items['contractor_id']), $this->contractor_employee_table)->count();
        if ($count == 0) {
            $items["created_on"] = Carbon::now()->format('Y-m-d H:i:s');
            $insert = $this->customRepository->insert_item($this->conn, $this->contractor_employee_table, $items);
            if ($insert) {
                // Registration successful
                $data = [
                    'message' => 'Employee Added Successfully',
                    'response' => true
                ];
            } else {
                $data = [
                    'message' => 'Something Wrong',
                    'response' => false
                ];
            }
        } else {
            $data = [
                'message' => 'Duplicate Entry',
                'response' => false
            ];
        }
        return $data;
    }


    public function update_establishment_employee(array $where,array $items){
        $update = $this->customRepository->update_item($this->conn,$this->contractor_employee_table,$where,$items);

        if ($update) {
                // Registration successful
                $data = [
                    'message' => 'Employee Updated Successfully', 
                    'response' => true
                ];
            }else {
                $data = [
                    'message' => 'Something Wrong/No Changes Applied', 
                    'response' => false
                ];
                
            }
       return $data;
    }


    public function full_address($row)
    {

        $province   = $row->province == NULL ? '' :  explode("-", $row->province)[1];
        $city       = $row->city == NULL ? '' : explode("-", $row->city)[1] . ' , ';
        $barangay   = $row->barangay == NULL ? '' : explode("-", $row->barangay)[1] . ' , ';
        $street     = $row->street == NULL ? '' : $row->street . ' , ';

        return $street . '' . $barangay . '' . $city . '' . $province;
    }
}
