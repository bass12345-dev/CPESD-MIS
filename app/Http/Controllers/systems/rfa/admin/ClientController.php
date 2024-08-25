<?php

namespace App\Http\Controllers\systems\rfa\admin;
use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Repositories\rfa\admin\AdminRFAQuery;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    protected $conn;
    protected $customRepository;
    protected $rFAQuery;

    public function __construct(CustomRepository $customRepository, AdminRFAQuery $rFAQuery)
    {

        $this->customRepository = $customRepository;
        $this->conn = config('custom_config.database.pmas');
        $this->rFAQuery = $rFAQuery;
    }
    public function index()
    {
        $data['title'] = 'Admin Dashboard';
        $data['count_completed_rfa_transactions'] = $this->customRepository->q_get_where($this->conn, array('rfa_status' => 'completed'), 'rfa_transactions')->count();
        $data['count_pending_rfa_transactions'] = $this->customRepository->q_get_where($this->conn, array('rfa_status' => 'pending'), 'rfa_transactions')->count();
        return view('systems.rfa.admin.pages.dashboard.dashboard')->with($data);
    }


    public function load_gender_client_by_month(Request $request)
    {

        $year = $request->input('year1');
        $months = array();
        $male = array();
        $female = array();

        for ($m = 1; $m <= 12; $m++) {

            $total_male = $this->rFAQuery->QueryGenderByMonthAndYear($m, $year, 'male');
            array_push($male, $total_male);


            $total_female = $this->rFAQuery->QueryGenderByMonthAndYear($m, $year, 'female');
            array_push($female, $total_female);

            $month = date('M', mktime(0, 0, 0, $m, 1));
            array_push($months, $month);
        }
        $data['label'] = $months;
        $data['male'] = $male;
        $data['female'] = $female;
        return response()->json($data);

    }


    public function get_by_gender_total(){
        $total = array();
        $gender = ['male','female'];
        foreach($gender as $row) {

            $res = $this->customRepository->q_get_where($this->conn,array('gender' => $row),'rfa_clients')->count();
            array_push($total, $res);
        }

       $data['label'] = $gender;
       $data['total']    = $total;
       $data['color'] = ['rgb(41,134,204)','rgb(201,0,118)'];
       return response()->json($data);
    }

}
