<?php

namespace App\Http\Controllers\systems\lls_whip\whip\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\whip\ProjectEmployeeStoreRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Repositories\CustomRepository;
use App\Repositories\whip\EmployeeQuery;
use App\Repositories\whip\ProjectQuery;
use App\Services\CustomService;
use App\Services\whip\ProjectsService;

class MonitoringController extends Controller
{
    protected $conn;
    protected $customRepository;
    protected $customService;
    protected $projectsService;
    protected $projectQuery;
    protected $employeeQuery;
    protected $monitoring_table;
    protected $position_table;
    protected $employment_status_table;
    protected $project_employee_table;
    public function __construct(CustomRepository $customRepository, ProjectQuery $projectQuery, EmployeeQuery $employeeQuery, CustomService $customService, ProjectsService $projectsService)
    {
        $this->conn                 = config('custom_config.database.lls_whip');
        $this->customRepository     = $customRepository;
        $this->customService        = $customService;
        $this->projectsService     = $projectsService;
        $this->projectQuery         = $projectQuery;
        $this->employeeQuery        = $employeeQuery;
        $this->monitoring_table     = 'project_monitoring';
        $this->position_table       = 'positions';
        $this->employment_status_table = 'employment_status';
        $this->project_employee_table = 'project_employee';
    }

    public function pending_project_monitoring_view()
    {
        $data['title'] = 'Pending Project Monitoring';
        return view('systems.lls_whip.whip.admin.pages.project_monitoring.pending_list.lists')->with($data);
    }

    public function approved_monitoring(Request $request)
    {
        $id = $request->input('id');
        $where = array('project_monitoring_id' => $id);
        $items = array('monitoring_status' => 'approved');
        $update = $this->customRepository->update_item($this->conn, $this->monitoring_table, $where, $items);
        if ($update) {
            // Registration successful
            return response()->json([
                'message' => 'Approved Updated Successfully',
                'response' => true
            ], 201);
        } else {
            return response()->json([
                'message' => 'Something Wrong',
                'response' => false
            ], 422);
        }
    }
}
