<?php

namespace App\Http\Controllers\systems\dts\user;

use App\Http\Controllers\Controller;
use App\Repositories\dts\DtsQuery;
use App\Services\dts\user\DocumentService;
use Illuminate\Http\Request;
use League\CommonMark\Node\Block\Document;

class OutgoingController extends Controller
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
        $data['title']          = 'Outgoing Documents';
        return view('systems.dts.user.pages.outgoing.outgoing')->with($data);
    }

    public function get_outgoing_documents(){

        $items = $this->dtsQuery->get_outgoing_documents();
        $i = 1;
        $data = [];
        foreach ($items as $key) {

            $data[] = array(
                'number'            => $i++,
                'outgoing_id'       => $key->outgoing_id,
                'doc_id'            => $key->outgoing_id.'-'.$key->doc_id,
                'tracking_number'   => $key->tracking_number,
                'document_name'     => $key->document_name,
                'name'              => $key->first_name.' '.$key->middle_name.' '.$key->last_name.' '.$key->extension,
                'type_name'         => $key->type_name,
                'remarks'           => $key->remarks,
                'office'            => $key->office,
                'office_id'         => $key->office_id,
                'outgoing_date'     => date('M d Y - h:i a', strtotime($key->outgoing_date))
            );
          
        }

        return response()->json($data);
    }


}
