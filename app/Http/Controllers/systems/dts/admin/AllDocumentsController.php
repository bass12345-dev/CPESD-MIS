<?php

namespace App\Http\Controllers\systems\dts\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CustomRepository;
use App\Services\dts\admin\DocumentService;
use Carbon\Carbon;

class AllDocumentsController extends Controller
{
    protected $conn;
    protected $customRepository;
    protected $documentService;
    protected $final_actions_table;
    public function __construct(CustomRepository $customRepository,DocumentService $documentService){
        $this->conn                 = config('custom_config.database.dts');
        $this->customRepository     = $customRepository;
        $this->documentService      = $documentService;
        $this->final_actions_table  = "final_actions";
     
    }
    public function index(){
        $data['title']              = 'All Documents';
        $data['final_actions']      = $this->customRepository->q_get($this->conn,$this->final_actions_table)->get();
        $data['current']            = Carbon::now()->year.'-'.Carbon::now()->month;
        return view('systems.dts.admin.pages.all_documents.all_documents')->with($data);
    }

    //CREATE
        
    //READ
    public function get_all_documents(){

        $month = '';
        $year = '';
        if(isset($_GET['date'])){
            $month =   date('m', strtotime($_GET['date']));
            $year =   date('Y', strtotime($_GET['date']));
        }
        
        $data = $this->documentService->get_all_document_process($month,$year);
        return response()->json($data);

    }
    //UPDATE
    //DELETE



}
