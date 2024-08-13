<?php

namespace App\Http\Controllers\systems\dts\user;

use App\Http\Controllers\Controller;
use App\Repositories\CustomRepository;
use App\Services\dts\user\DocumentService;

class MyDocumentsController extends Controller
{
   
    protected $conn;
    protected $customRepository;
    protected $documentService;
    protected $document_types_table;       
    protected $office_table;               
    public function __construct(CustomRepository $customRepository, DocumentService $documentService){
        $this->conn                 = config('custom_config.database.dts');
        $this->customRepository     = $customRepository;
        $this->documentService      = $documentService;
        $this->document_types_table = "document_types";
        $this->office_table         = 'offices';
     
    }
    public function index(){
        $data['title']          = 'My Documents';
        $data['document_types'] = $this->customRepository->q_get_order($this->conn,$this->document_types_table, 'type_name', 'asc')->get();
        $data['offices']        = $this->customRepository->q_get_order($this->conn,$this->office_table, 'office', 'asc')->get();
        return view('systems.dts.user.pages.my_documents.my_documents')->with($data);
    }

    public function get_my_documents(){

        $items = $this->documentService->get_my_documents();
        return response()->json($items);
    }
}
