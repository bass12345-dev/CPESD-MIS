<?php

namespace App\Http\Controllers\systems\pmas\user;
use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\pmas\user\UserPmasQuery;
use App\Services\CustomService;
use App\Services\user\UserService;
use Illuminate\Http\Request;

class AddController extends Controller
{

    protected $conn;
    protected $customRepository;
    protected $customService;
    protected $userService;

    protected $userPmasQuery;

    public function __construct(CustomRepository $customRepository, CustomService $customService, UserService $userService,UserPmasQuery $userPmasQuery)
    {

        $this->customRepository = $customRepository;
        $this->userPmasQuery    = $userPmasQuery;
        $this->customService = $customService;
        $this->userService = $userService;
        $this->conn = config('custom_config.database.pmas');

    }
    public function index()
    {
        $data['title'] = 'Add Transaction';
        $data['activities']                 = $this->customRepository->q_get_order($this->conn,'type_of_activities','type_of_activity_name','asc')->get();
        $data['responsible']                = $this->customRepository->q_get_order($this->conn,'responsible_section','responsible_section_name','asc')->get();
        $data['responsibility_centers']     = $this->customRepository->q_get_order($this->conn,'responsibility_center','responsibility_center_id','desc')->get();
        $data['cso']                        = $this->customRepository->q_get_where_order($this->conn,'cso',array('cso_status'=> 'active'),'cso_code','asc')->get();
        $data['training_text']              = 'training';
        $data['rgpm_text']                  = 'regular monthly project monitoring';
        $data['rmm']                        = 'regular monthly meeting';
        return view('systems.pmas.user.pages.add.add')->with($data);
    }




    public function get_last_pmas_number(){
          #define reference number variable
          $pmas_number = '';

          #count rfa added in database
          $count_pmas  = $this->customRepository->q_get($this->conn, 'transactions')->count();

          #get current year
          $current_year = date('Y', time());

          #ymd format = Year Month Day
          $ymd_format = date('Y-m-d', time());


          #CONDITION

           if($count_pmas) {

              $last_created = date('Y', strtotime($this->customRepository->q_get_order($this->conn,'transactions','date_and_time_filed','desc')->first()->date_and_time_filed));

                if($current_year > $last_created ){

                      $pmas_number = '001';

                }else if($current_year < $last_created){
                      $last_pmas_number_add_one = $this->userPmasQuery->get_last_pmas_number_where($ymd_format)->first()->number + 1;
                      $pmas_number = $this->customService->put_zeros_p_r($last_pmas_number_add_one);

                }else if($current_year === $last_created){
                      $last_pmas_number_add_one = $this->userPmasQuery->get_last_pmas_number_where($current_year)->first()->number + 1;
                      $pmas_number = $this->customService->put_zeros_p_r($last_pmas_number_add_one);

                }

           }else {

              $pmas_number = '001';
           }
          
          echo $pmas_number;

    }


}
