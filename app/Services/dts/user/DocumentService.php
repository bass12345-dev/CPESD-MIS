<?php

namespace App\Services\dts\user;

use App\Repositories\CustomRepository;
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
    protected $dtsQuery;
    protected $customService;
    protected $actionLogService;

    public function __construct(CustomRepository $customRepository, DtsQuery $dtsQuery, CustomService $customService, ActionLogService $actionLogService)
    {
        $this->conn                 = config('custom_config.database.dts');
        $this->conn_user            = config('custom_config.database.users');
        $this->customRepository     = $customRepository;
        $this->customService        = $customService;
        $this->actionLogService    = $actionLogService;
        $this->dtsQuery             = $dtsQuery;
        $this->documents_table      = 'documents';
        $this->history_table        = 'history';
        $this->outgoing_table       = 'outgoing_documents';
        $this->user_table           = 'users';
    }

    public function get_my_documents()
    {
        $items = array();
        $rows = $this->dtsQuery->get_my_documents();
        $i = 1;
        foreach ($rows as  $key) {

            $delete_button = $this->customRepository->q_get_where($this->conn, array('t_number' => $key->tracking_number), $this->history_table)->count() > 1 ? true : false;
            $status = $this->check_status($key->doc_status);

            $items[] = array(
                'number'            => $i++,
                'tracking_number'   => $key->tracking_number,
                'document_name'     => $key->document_name,
                'type_name'         => $key->type_name,
                'created'           => date('M d Y - h:i a', strtotime($key->d_created)),
                'a'                 => $delete_button,
                'document_id'       => $key->document_id,
                'is'                => $status,
                'doc_type'          => $key->doc_type,
                'description'       => $key->document_description,
                'destination_type'  => $key->destination_type,
                'doc_status'        => $key->doc_status,
                'name'              => $key->name,
                'document_type_name' => $key->type_name,
                'encoded_by'        => $this->customService->user_full_name($key),
                'origin'            => $key->origin == NULL ? '-' : $key->origin,
                'origin_id'         => $key->origin_id
            );
        }

        return $items;
    }

    //ADD DOCUMENT PROCESS

    public function  add_document_process($request, $user_type)
    {

        $items = array(

            'tracking_number'   => $request->input('tracking_number'),
            'document_name'     => trim($request->input('document_name')),
            'u_id'              => base64_decode($request->input('user_id')),
            'offi_id'           => $request->input('office_id'),
            'doc_type'          => $request->input('document_type'),
            'document_description' => trim($request->input('description')),
            'created'           => Carbon::now()->format('Y-m-d H:i:s'),
            'doc_status'        => 'pending',
            'destination_type'  => $request->input('type'),
            'origin'            => $request->input('origin'),
        );

        $count = $this->customRepository->q_get_where($this->conn, array('tracking_number' => $items['tracking_number']), $this->documents_table)->count();

        if ($count == 0) {

            $add = $this->customRepository->insert_item($this->conn, $this->documents_table, $items);
            if ($add) {

                $row        = $this->document_data(array('tracking_number' => $items['tracking_number']));

                $items1 = array(
                    't_number'          => $row->tracking_number,
                    'user1'             => $row->u_id,
                    'office1'           => $row->offi_id,
                    'user2'             => $row->u_id,
                    'office2'           => $row->offi_id,
                    'status'            => 'received',
                    'received_status'   => '1',
                    'received_date'     => Carbon::now()->format('Y-m-d H:i:s'),
                    'release_status'    => NULL,
                    'to_receiver'       => 'no',
                    'release_date'      => NULL,
                );
                $add1 = $this->customRepository->insert_item($this->conn, $this->history_table, $items1);

                if (true) {
                    $this->actionLogService->dts_add_action('Added Document No. ' . $row->tracking_number, $user_type, $row->document_id);
                    $data = array('id' => $row->document_id, 'message' => 'Added Successfully', 'response' => true);
                } else {

                    $data = array('message' => 'Something Wrong', 'response' => false);
                }
            } else {

                $data = array('message' => 'Something Wrong', 'response' => false);
            }
        } else {
            $data = array('message' => 'Tracking Number is Existing', 'response' => false);
        }

        return $data;
    }

    //RECEIVED PROCESS
    public function received_process($history_id, $tracking_number, $user_type)
    {

        $to_update = array(

            'status'                => 'received',
            'received_status'       => 1,
            'received_date'         => Carbon::now()->format('Y-m-d H:i:s'),
        );

        $r = $this->document_data(array('tracking_number' => $tracking_number));

        if ($r->doc_status != 'cancelled') {

            $update_receive = $this->customRepository->update_item($this->conn,$this->history_table, array('history_id' => $history_id), $to_update);
            if ($update_receive) {
                $this->actionLogService->dts_add_action('Received Document No. ' . $tracking_number, $user_type, $r->document_id);
                $data = array('message' => 'Received Succesfully', 'id' => $history_id, 'tracking_number' => $tracking_number, 'response' => true);
            } else {
                $data = array('message' => 'Something Wrong', 'response' => false);
            }
        } else {
            $data = array('message' => 'This Document is cancelled', 'response' => false);
        }
        return $data;
    }



    public function check_status($doc_status)
    {
        $status = '';

        switch ($doc_status) {
            case 'completed':
                $status = '<span class="badge p-2 bg-success">Completed</span>';
                break;
            case 'pending':
                $status = '<span class="badge p-2 bg-danger">Pending</span>';
                break;

            case 'cancelled':
                $status = '<span class="badge p-2 bg-warning">Canceled</span>';
                break;

            case 'outgoing':
                $status = '<span class="badge p-2 bg-secondary">Outgoing</span>';
                break;
            default:
                # code...
                break;
        }

        return $status;
    }

    private function document_data($where)
    {
        $item =  $this->customRepository->q_get_where($this->conn, $where, $this->documents_table)->first();
        return $item;
    }
}
