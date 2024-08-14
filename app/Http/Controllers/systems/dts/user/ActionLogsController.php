<?php

namespace App\Http\Controllers\systems\dts\user;

use App\Http\Controllers\Controller;
use App\Repositories\dts\DtsQuery;
use App\Services\dts\user\DocumentService;


class ActionLogsController extends Controller
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
        $data['title']          = 'Action Logs';
        return view('systems.dts.user.pages.action_logs.action_logs')->with($data);
    }

    public function get_action_logs(){
        $data = [];
        $i = 1;
        $items = $this->dtsQuery->get_user_actions_dts();
        foreach ($items as $value => $key) {
            $data[] = array(
                'number'            => $i++,
                'tracking_number'   => $key->tracking_number,
                'action'            => $key->action,
                'action_datetime'   => date('M d Y h:i A', strtotime($key->action_datetime))
                
            );
        }
        return response()->json($data);
    }


}
