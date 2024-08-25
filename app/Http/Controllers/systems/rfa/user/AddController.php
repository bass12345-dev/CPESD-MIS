<?php

namespace App\Http\Controllers\systems\rfa\user;

use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\rfa\user\RFAQuery;
use Illuminate\Http\Request;

class AddController extends Controller
{

    protected $conn;
    protected $conn_user;
    protected $customRepository;
    protected $rFAQuery;

    public function __construct(CustomRepository $customRepository, RFAQuery $rFAQuery)
    {

        $this->customRepository = $customRepository;
        $this->conn = config('custom_config.database.pmas');
        $this->conn_user = config('custom_config.database.users');
        $this->rFAQuery = $rFAQuery;
    }
    public function index()
    {

        if (session('user_type') == 'user') {

            $data['title'] = 'Request For Assistance';
            $data['data']   = null;
            $data['barangay'] = config('custom_config.barangay');
            $data['employment_status'] = config('custom_config.employment_status');
            $data['type_of_request'] = $this->customRepository->q_get_order($this->conn,'type_of_request','type_of_request_name', 'asc')->get();
            $data['type_of_transactions'] = config('custom_config.type_of_transactions');
            $data['refer_to'] = $this->customRepository->q_get_where_order($this->conn_user,'users',array('user_type' => 'user'),'first_name','desc')->get(); 
            return view('systems.rfa.user.pages.add.add')->with($data);

        } else {
          echo  '404';
        }
       
    }


    public function get_last_ref_number()
    {

        #define reference number variable
        $reference_number = '';

        #count rfa added in database
        $count_rfa = $this->customRepository->q_get($this->conn, 'rfa_transactions')->count();


        #get current year
        $current_year = date('Y', time());

        #ymd format = Year Month Day
        $ymd_format = date('Y-m-d', time());


        #CONDITION

        if ($count_rfa) {

            #get last added in database
            $last_created = date('Y', strtotime($this->customRepository->q_get_order($this->conn, 'rfa_transactions', 'rfa_date_filed', 'desc')->first()->rfa_date_filed));

            #current year is greater than the last year added
            if ($current_year > $last_created) {

                #set reference to 001
                $reference_number = '001';

            } else if ($current_year < $last_created) {
                //get last created rfa plus 1
                $last_reference_number_add_one = $this->rFAQuery->get_last_ref_number_where($ymd_format)->first()->number + 1;
                $reference_number = $this->put_zeros($last_reference_number_add_one);

            } else if ($current_year === $last_created) {

                $last_reference_number_add_one = $this->rFAQuery->get_last_ref_number_where($current_year)->first()->number + 1;
                $reference_number = $this->put_zeros($last_reference_number_add_one);
            }

        } else {

            $reference_number = '001';
        }

        echo $reference_number;

    }


    private function put_zeros($last_digits)
    {

        $reference_number = '';

        switch ($last_digits) {
            case $last_digits < 10:
                $reference_number = '00' . $last_digits;
                break;
            case $last_digits < 100:
                $reference_number = '0' . $last_digits;
                break;
            default:
                $reference_number = $last_digits;
                break;
        }
        return $reference_number;

    }




}
