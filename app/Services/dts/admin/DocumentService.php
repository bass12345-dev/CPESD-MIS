<?php

namespace App\Services\dts\admin;

use App\Repositories\CustomRepository;
use App\Repositories\dts\AdminDtsQuery;
use App\Repositories\dts\DtsQuery;
use App\Services\user\ActionLogService;
use App\Services\CustomService;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DocumentService
{

    protected $conn;
    protected $conn_user;
    protected $customRepository;
    protected $documents_table;
    protected $history_table;
    protected $outgoing_table;
    protected $user_table;
    protected $adminDtsQuery;
    protected $customService;
    protected $actionLogService;

    public function __construct(CustomRepository $customRepository, AdminDtsQuery $adminDtsQuery, CustomService $customService, ActionLogService $actionLogService)
    {
        $this->conn = config('custom_config.database.dts');
        $this->conn_user = config('custom_config.database.users');
        $this->customRepository = $customRepository;
        $this->customService = $customService;
        $this->actionLogService = $actionLogService;
        $this->adminDtsQuery = $adminDtsQuery;
        $this->documents_table = 'documents';
        $this->history_table = 'history';
        $this->outgoing_table = 'outgoing_documents';
        $this->user_table = 'users';
    }

    public function get_all_document_process($month, $year)
    {


        if ($month == '' && $year == '') {
            $items = $this->adminDtsQuery->QueryAllDocuments();
        } else {
            $items = $this->adminDtsQuery->QueryDocumentsByMonth($month, $year);
        }

        $data = [];
        $i = 1;
        foreach ($items as $key) {
            $where = array('t_number' => $key->tracking_number);
            $delete_button = $this->customRepository->q_get_where($this->conn, $where, $this->history_table)->count() > 1 ? true : false;
            $status = $this->customService->check_status($key->doc_status);
            $history = $this->customRepository->q_get_where_order($this->conn, $this->history_table, $where, 'history_id', 'desc');
            $is_existing = $history->count();
            $data[] = array(
                'number' => $i++,
                'tracking_number' => $key->tracking_number,
                'document_name' => $key->document_name,
                'type_name' => $key->type_name,
                'created' => date('M d Y - h:i a', strtotime($key->created)),
                'a' => $delete_button,
                'document_id' => $key->document_id,
                'history_id' => $is_existing == 0 ? '' : $history->first()->history_id,
                'error' => $is_existing == 0 ? 'text-danger' : '',
                'user_id' => $key->u_id,
                'created_by' => $key->first_name . ' ' . $key->middle_name . ' ' . $key->last_name . ' ' . $key->extension,
                'is' => $status,
                'history_status' => $key->doc_status
            );
        }


        return $data;
    }


}
