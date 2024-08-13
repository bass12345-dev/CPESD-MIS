<?php

namespace App\Http\Controllers\systems\dts\user;

use App\Http\Controllers\Controller;
use App\Repositories\dts\DtsQuery;
use App\Services\dts\user\DocumentService;
use Illuminate\Http\Request;
use League\CommonMark\Node\Block\Document;

class ForwardedController extends Controller
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
        $data['title']          = 'Forwarded Documents';
        return view('systems.dts.user.pages.forwarded.forwarded')->with($data);
    }

    public function get_forwarded_documents(){

        $data = [];
        $i = 1;
        $rows =  $this->dtsQuery->get_forwarded_documents();
        foreach ($rows as $value => $key) {
 
             $data[] = array(
                     'number'            => $i++,
                     'tracking_number'   => $key->tracking_number,
                     'history_id'        => $key->history_id,
                     'document_name'     => $key->document_name,
                     'type_name'         => $key->type_name,
                     'released_date'     => date('M d Y - h:i a', strtotime($key->release_date)) ,
                     'forward_to_id'     => $key->user_id,
                     'forwarded_to'      => $key->final_receiver == 'yes' ? '<span class="text-danger">To Final Receiver</span>' : $key->first_name.' '.$key->middle_name.' '.$key->last_name.' '.$key->extension,
                     'document_id'       => $key->document_id,
                     'remarks'           => $key->remarks,
             );
         }
 
        return response()->json($data);
 
      }




}
