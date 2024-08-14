<?php

namespace App\Http\Controllers\systems\dts\both;

use App\Http\Controllers\Controller;
use App\Repositories\dts\DtsQuery;
use App\Services\dts\user\DocumentService;
use Illuminate\Http\Request;

class SearchDocuments extends Controller
{
    protected $dtsQuery;
    protected $documentService;
    private $user_type                  = 'user';
    public function __construct(DtsQuery $dtsQuery, DocumentService $documentService)
    {
        $this->dtsQuery = $dtsQuery;
        $this->documentService = $documentService;
    }
    public function index(Request $request){
        $data['title']          = 'Search Documents';
        $segments = $request->segments();
        if($segments[0] == 'user') {
             return view('systems.dts.user.pages.search_documents.search_documents')->with($data);
        }else if($segments[0] == 'admin') {
            return view('systems.dts.admin.pages.search_documents.search_documents')->with($data);
        }
    }



}
