<?php

namespace App\Services\dts\user;

use App\Repositories\CustomRepository;
use App\Repositories\dts\DtsQuery;
use Carbon\Carbon;

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

    public function __construct(CustomRepository $customRepository,DtsQuery $dtsQuery ){
        $this->conn                 = config('app._database.dts');
        $this->conn_user            = config('app._database.users');
        $this->customRepository     = $customRepository;
        $this->dtsQuery             = $dtsQuery;
        $this->documents_table      = 'documents';
        $this->history_table        = 'history';
        $this->outgoing_table       = 'outgoing_documents';
        $this->user_table           = 'users';
        
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


    



    
}