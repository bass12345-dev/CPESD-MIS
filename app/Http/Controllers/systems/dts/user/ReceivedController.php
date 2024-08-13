<?php

namespace App\Http\Controllers\systems\dts\user;

use App\Http\Controllers\Controller;
use App\Repositories\dts\DtsQuery;
use App\Services\dts\user\DocumentService;
use Illuminate\Http\Request;
use League\CommonMark\Node\Block\Document;

class ReceivedController extends Controller
{
    protected $dtsQuery;
    protected $documentService;
    private $user_type                  = 'user';
    public function __construct(DtsQuery $dtsQuery, DocumentService $documentService)
    {
        $this->dtsQuery = $dtsQuery;
        $this->documentService = $documentService;
    }
    public function index(){
        $data['title']          = 'Received Documents';
        return view('systems.dts.user.pages.received.received')->with($data);
    }

    public function get_received_documents(){


        $data = [];
        $rows = $this->dtsQuery->get_received_documents();
        $i = 1;
        foreach ($rows as $value => $key) {
 
          
             $data[] = array(
                     'his_tn'            => $key->history_id.'-'.$key->tracking_number,
                     'tracking_number'   => $key->tracking_number,
                     't_'                => $key->tracking_number,
                     'document_name'     => $key->document_name,
                     'type_name'         => $key->type_name,
                     'received_date'     => date('M d Y - h:i a', strtotime($key->received_date)) ,
                     'history_id'        => $key->history_id,
                     'document_id'       => $key->document_id,
                     'a'                 => $key->user_type == 'admin' ? false : true,
                     'remarks'           => $key->remarks,
                     'number'            => $i++
             );
         }
 
        return response()->json($data);
 
     }



}
