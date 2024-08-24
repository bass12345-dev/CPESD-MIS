<?php

namespace App\Repositories\rfa\user;

use Illuminate\Support\Facades\DB;

class RFAQuery
{

    protected $conn;
    protected $pmas_db_name;
    protected $users_db_name;

    public function __construct()
    {

        $this->conn = config('custom_config.database.pmas');
        $this->pmas_db_name = env('DB_DATABASE_PMAS');
        $this->users_db_name = env('DB_DATABASE');
    }
    //Dashboard
    public function QueryUserTransactionPerMonthYear($month, $year, $status)
    {
        $row = DB::connection($this->conn)->table('rfa_transactions')
            ->where('reffered_to', session('user_id'))
            ->where('rfa_status', $status)
            ->whereMonth('rfa_date_filed', '=', $month)
            ->whereYear('rfa_date_filed', '=', $year)
            ->count();
        return $row;

    }


    //Pending Transactions
    public function QueryUserPendingRFA(){

        $row = DB::table($this->pmas_db_name . '.rfa_transactions as rfa_transactions')
        ->leftJoin($this->pmas_db_name . '.type_of_request','type_of_request.type_of_request_id', '=','rfa_transactions.tor_id')
        ->leftJoin($this->users_db_name . '.users', 'users.user_id', '=', 'rfa_transactions.rfa_created_by')
        ->where('rfa_transactions.rfa_status','pending')
        ->where('rfa_transactions.rfa_created_by', session('user_id'))
        ->orderBy('rfa_transactions.rfa_date_filed','desc')
        ->get();
        return $row;

    }


    //REferred Transactions

    public function QueryUserReferredRFA(){


        $row = DB::table($this->pmas_db_name . '.rfa_transactions as rfa_transactions')
        ->leftJoin($this->pmas_db_name . '.type_of_request','type_of_request.type_of_request_id', '=','rfa_transactions.tor_id')
        ->leftJoin($this->users_db_name . '.users', 'users.user_id', '=', 'rfa_transactions.rfa_created_by')
        ->where('rfa_transactions.rfa_status','pending')
        ->where('rfa_transactions.reffered_to', session('user_id'))
        ->orderBy('rfa_transactions.reffered_date_and_time','desc')
        ->get();
        return $row;
    }

    //Add View

    public function QueryRFATransactionsLimit($limit)
    {

        $row = DB::table($this->pmas_db_name . '.rfa_transactions')
            ->leftJoin($this->users_db_name . '.users as users', 'users.user_id', '=', 'rfa_transactions.rfa_created_by')
            ->orderBy('rfa_transactions.rfa_date_filed', 'desc')
            ->limit($limit)
            ->get();
        return $row;

    }

    public function get_last_ref_number_where($where)
    {
        $row = DB::connection($this->conn)->table('rfa_transactions')
            ->whereYear('rfa_date_filed', '=', $where)
            ->orderBy('rfa_date_filed', 'desc');
        return $row;
    }

    //Search 

    public function search_client($search)
    {
        $row = DB::connection($this->conn)->table('rfa_clients')
        
        ->where(DB::raw("concat(first_name, ' ', last_name)"), 'LIKE', "%" . $search . "%")
        ->get();
        return $row;

    }



}
