<?php

use App\Http\Middleware\AdminCheck;
use App\Http\Middleware\SessionGuard;
use App\Http\Middleware\UserLoginCheck;
use Illuminate\Support\Facades\Route;

//Auth View
Route::get('/', function () {
   $data['title'] = 'CPESD MIS LOGIN';
   return view('system_auth.login')->with($data);
})->middleware(UserLoginCheck::class);
//Auth Login Action
Route::post('/v-u', [App\Http\Controllers\auth\AuthController::class, 'verify_user']);
Route::get('/logout', [App\Http\Controllers\auth\AuthController::class, 'logout']);


Route::get('/home', function () {
   $data['title'] = 'CPESD MIS MANAGEMENT INFORMATION SYSTEM';
   $data['link']  = session('user_type') == 'user' ? 'user' : 'admin';
   return view('home.index')->with($data);
})->middleware(SessionGuard::class);



            ////SYSTEM MANAGEMENT


//SYSTEM MANAGEMENT ROUTES
Route::middleware([SessionGuard::class, AdminCheck::class])->prefix('/admin/sysm')->group(function () {
   Route::get("/dashboard",[ App\Http\Controllers\system_management\DashboardController::class, 'index']);
   Route::get("/login-history",[ App\Http\Controllers\system_management\LoginHistoryController::class, 'index']);
   //Manage USer
   Route::get("/manage-users",[ App\Http\Controllers\system_management\ManageUserController::class, 'index']);
   Route::get("/user/{id}",[ App\Http\Controllers\system_management\ManageUserController::class, 'view_profile']);
});
//SYSTEM MANAGEMENT ACTIONS
Route::middleware([SessionGuard::class, AdminCheck::class])->prefix('/admin/sysm/act')->group(function () {
   Route::get("/g-a-l-l",[ App\Http\Controllers\system_management\LoginHistoryController::class, 'get_all_login_logs']);
   //Manage User
   Route::get("/g-a-u",[ App\Http\Controllers\system_management\ManageUserController::class, 'get_all_users']);
   //System Authorization
   Route::post("/a-s",[ App\Http\Controllers\system_management\ManageUserController::class, 'authorize_system']);
});


            ////LABOR LOCALIZATION AND WHIP


//USER VIEW 
Route::middleware([SessionGuard::class])->prefix('/user')->group(function () {
   //LLS
      //Dashboard
      Route::get("/lls/dashboard",[ App\Http\Controllers\systems\lls_whip\lls\user\DashboardController::class, 'index']);
      //Establishments
         Route::get("/lls/add-new-establishment",[ App\Http\Controllers\systems\lls_whip\lls\both\EstablishmentsController::class, 'add_new_establishments']);
         Route::get("/lls/establishments-list",[ App\Http\Controllers\systems\lls_whip\lls\both\EstablishmentsController::class, 'establishments_list']);
         Route::get("/lls/establishment/{id}",[App\Http\Controllers\systems\lls_whip\lls\both\EstablishmentsController::class, 'establishments_view_information']);
      //Positions
         Route::get("/lls/establishments-positions",[ App\Http\Controllers\systems\lls_whip\lls\both\PositionsController::class, 'index']);
      //Employees Record
         Route::get("/lls/employees-record",[ App\Http\Controllers\systems\lls_whip\both\EmployeeController::class, 'index']);
        
   //WHIP
      //Dashboard
         Route::get("/whip/dashboard",[ App\Http\Controllers\systems\lls_whip\whip\user\DashboardController::class, 'index']);
      //Employees Record
         Route::get("/whip/employees-record",[ App\Http\Controllers\systems\lls_whip\both\EmployeeController::class, 'index']);
      //Contractors
         Route::get("/whip/add-new-contractor",[ App\Http\Controllers\systems\lls_whip\whip\both\ContractorsController::class, 'add_new_contractor']);
         Route::get("/whip/contractors-list",[ App\Http\Controllers\systems\lls_whip\whip\both\ContractorsController::class, 'contractors_list']);
         Route::get("/whip/contractor-information/{id}",[ App\Http\Controllers\systems\lls_whip\whip\both\ContractorsController::class, 'contractor_information']);
      //Projects
         Route::get("/whip/add-new-project",[ App\Http\Controllers\systems\lls_whip\whip\both\ProjectsController::class, 'add_new_project']);
         Route::get("/whip/projects-list",[ App\Http\Controllers\systems\lls_whip\whip\both\ProjectsController::class, 'projects_list']);
         Route::get("/whip/project-information/{id}",[ App\Http\Controllers\systems\lls_whip\whip\both\ProjectsController::class, 'project_information']);
      //Project Monitoring
         Route::get("/whip/add-monitoring",[ App\Http\Controllers\systems\lls_whip\whip\user\MonitoringController::class, 'add_monitoring_view']);
         Route::get("/whip/pending-projects-monitoring",[ App\Http\Controllers\systems\lls_whip\whip\user\MonitoringController::class, 'pending_project_monitoring_view']);
         Route::get("/whip/project-monitoring-info/{id}",[ App\Http\Controllers\systems\lls_whip\whip\user\MonitoringController::class, 'project_monitoring_information']);
         Route::get("/whip/approved-projects-monitoring",[ App\Http\Controllers\systems\lls_whip\whip\user\MonitoringController::class, 'approved_project_monitoring_view']);
         //Reports
         Route::get("/whip/monitoring-report/{id}",[ App\Http\Controllers\systems\lls_whip\whip\user\MonitoringController::class, 'view_monitoring_report']);
      //Positions
         Route::get("/whip/whip-positions",[ App\Http\Controllers\systems\lls_whip\both\PositionsController::class, 'index']);

   
                                                   //DOCUMENT TRACKING SYSTEM//
      //USER
         //Dashboard
         Route::get("/dts/dashboard",[ App\Http\Controllers\systems\dts\user\DashboardController::class, 'index']);
         //My documents
         Route::get("/dts/my-documents",[ App\Http\Controllers\systems\dts\user\MyDocumentsController::class, 'index']);
         //Add Documents
         Route::get("/dts/add-document",[ App\Http\Controllers\systems\dts\user\AddDocumentController::class, 'index']);
         //Incoming
         Route::get("/dts/incoming",[ App\Http\Controllers\systems\dts\user\IncomingController::class, 'index']);
         //Received
         Route::get("/dts/received",[ App\Http\Controllers\systems\dts\user\ReceivedController::class, 'index']);
         //Forwarded
         Route::get("/dts/forwarded",[ App\Http\Controllers\systems\dts\user\ForwardedController::class, 'index']);
         //Outgoing
         Route::get("/dts/outgoing",[ App\Http\Controllers\systems\dts\user\OutgoingController::class, 'index']);
         //Action Logs
         Route::get("/dts/action-logs",[ App\Http\Controllers\systems\dts\user\ActionLogsController::class, 'index']);
         //Search Documents
         Route::get("/dts/search-docs",[ App\Http\Controllers\systems\dts\both\SearchDocuments::class, 'index']);
         //View Document
         Route::get("/dts/view",[ App\Http\Controllers\systems\dts\both\SearchDocuments::class, 'view_document']);

});


//USER ACTION LLS_WHIP
Route::middleware([SessionGuard::class])->prefix('/user/act')->group(function () {
   //LLS
      //POSITIONS
      Route::get("/lls/a-p",[App\Http\Controllers\systems\lls_whip\both\PositionsController::class, 'get_all_lls_positions']);
      Route::post("/lls/i-u-p",[App\Http\Controllers\systems\lls_whip\both\PositionsController::class, 'insert_update_position_lls']);
      //ESTABLISHMENTS
      Route::post("/lls/insert-es",[App\Http\Controllers\systems\lls_whip\lls\both\EstablishmentsController::class, 'insert_establishment']);
      Route::get("/lls/g-a-e",[App\Http\Controllers\systems\lls_whip\lls\both\EstablishmentsController::class, 'get_all_establishment']);
      Route::post("/lls/d-e",[App\Http\Controllers\systems\lls_whip\lls\both\EstablishmentsController::class, 'delete_establishment']);
      Route::post("/lls/u-e",[App\Http\Controllers\systems\lls_whip\lls\both\EstablishmentsController::class, 'update_establishment']);
   //WHIP
      //Dashboard
         Route::get("/whip/g-c-i-o",[ App\Http\Controllers\systems\lls_whip\whip\admin\DashboardController::class, 'get_contractors_inside_outside']);
         Route::get("/whip/g-w-i-o",[ App\Http\Controllers\systems\lls_whip\whip\admin\DashboardController::class, 'get_workers_inside_outside']);
         Route::get("/whip/g-d-p-p-b",[ App\Http\Controllers\systems\lls_whip\whip\admin\DashboardController::class, 'get_projects_per_barangay']);

         
      //Employees Record
         Route::get("/g-a-em",[ App\Http\Controllers\systems\lls_whip\both\EmployeeController::class, 'get_all_employees']);
         Route::post("/i-e",[ App\Http\Controllers\systems\lls_whip\both\EmployeeController::class, 'insert_employee']);
         Route::post("/d-em",[ App\Http\Controllers\systems\lls_whip\both\EmployeeController::class, 'delete_employee']);
         Route::get("/search-emp",[ App\Http\Controllers\systems\lls_whip\both\EmployeeController::class, 'search_employee']);
      //Contractors
         Route::post("/whip/insert-contractor",[ App\Http\Controllers\systems\lls_whip\whip\both\ContractorsController::class, 'insert_contractor']);
         Route::post("/whip/update-contractor",[ App\Http\Controllers\systems\lls_whip\whip\both\ContractorsController::class, 'update_contractor']);
         Route::get("/whip/g-a-c",[App\Http\Controllers\systems\lls_whip\whip\both\ContractorsController::class, 'get_all_contractors']);
         Route::post("/whip/d-c",[App\Http\Controllers\systems\lls_whip\whip\both\ContractorsController::class, 'delete_contractors']);
         Route::get("/whip/search-query",[App\Http\Controllers\systems\lls_whip\whip\both\ContractorsController::class, 'search_query']);  
         Route::post("/whip/g-c-p",[App\Http\Controllers\systems\lls_whip\whip\both\ContractorsController::class, 'get_contractor_projects']);  
      //Projects
         Route::post("/whip/insert-project",[ App\Http\Controllers\systems\lls_whip\whip\both\ProjectsController::class, 'insert_project']);
         Route::post("/whip/update-project",[ App\Http\Controllers\systems\lls_whip\whip\both\ProjectsController::class, 'update_project']);
         Route::get("/whip/g-a-p",[App\Http\Controllers\systems\lls_whip\whip\both\ProjectsController::class, 'get_all_projects']);
         Route::post("/whip/d-p",[App\Http\Controllers\systems\lls_whip\whip\both\ProjectsController::class, 'delete_projects']);
         Route::get("/whip/search-project",[App\Http\Controllers\systems\lls_whip\whip\both\ProjectsController::class, 'search_project']);
         Route::get("/whip/g-p-p-b/{id}",[ App\Http\Controllers\systems\lls_whip\whip\both\ProjectsController::class, 'get_projects_per_barangay']);
      //Projects Monitoring
         Route::post("/whip/i-p-m",[ App\Http\Controllers\systems\lls_whip\whip\user\MonitoringController::class, 'insert_project_monitoring']);
         Route::get("/whip/g-u-p-m",[ App\Http\Controllers\systems\lls_whip\whip\user\MonitoringController::class, 'get_pending_project_monitoring']);
         Route::get("/whip/g-m-a-p-m",[ App\Http\Controllers\systems\lls_whip\whip\user\MonitoringController::class, 'get_my_approved_project_monitoring']);
         Route::post("/whip/u-p-m",[ App\Http\Controllers\systems\lls_whip\whip\user\MonitoringController::class, 'update_project_monitoring']);
         Route::post("/whip/d-p-m",[ App\Http\Controllers\systems\lls_whip\whip\user\MonitoringController::class, 'delete_project_monitoring']);
         Route::post("/whip/i-u-p-e",[ App\Http\Controllers\systems\lls_whip\whip\user\MonitoringController::class, 'insert_update_project_employee']);
         Route::post("/whip/g-a-p-e",[ App\Http\Controllers\systems\lls_whip\whip\user\MonitoringController::class, 'get_all_project_employee']);
         Route::post("/whip/d-p-e",[ App\Http\Controllers\systems\lls_whip\whip\user\MonitoringController::class, 'delete_project_employee']);
      
      //Remarks
         Route::post("/whip/add-remarks",[ App\Http\Controllers\systems\lls_whip\whip\user\MonitoringController::class, 'add_remarks']);
         Route::post("/whip/get-remarks",[ App\Http\Controllers\systems\lls_whip\whip\user\MonitoringController::class, 'get_remarks']);
         
         //Reports
            Route::post("/whip/g-n-e-i",[ App\Http\Controllers\systems\lls_whip\whip\user\MonitoringController::class, 'get_nature_employee_inside']);
            Route::post("/whip/g-n-e-o",[ App\Http\Controllers\systems\lls_whip\whip\user\MonitoringController::class, 'get_nature_employee_outside']);
            Route::post("/whip/g-s-u-t",[ App\Http\Controllers\systems\lls_whip\whip\user\MonitoringController::class, 'get_skilled_unskilled_total']);
            Route::post("/whip/generate-report",[ App\Http\Controllers\systems\lls_whip\whip\user\MonitoringController::class, 'generate_report']);
      //WHIP POSITIONS
         Route::post("/whip/i-u-p",[App\Http\Controllers\systems\lls_whip\both\PositionsController::class, 'insert_update_position_whip']);
         Route::get("/whip/a-p",[App\Http\Controllers\systems\lls_whip\both\PositionsController::class, 'get_all_whip_positions']);
         Route::post("/d-p",[App\Http\Controllers\systems\lls_whip\both\PositionsController::class, 'delete_positions']);
   //DTS
      //My Documents
         Route::post("/dts/g-m-d",[App\Http\Controllers\systems\dts\user\MyDocumentsController::class, 'get_my_documents']);
         Route::post("/dts/update-document",[App\Http\Controllers\systems\dts\user\MyDocumentsController::class, 'update_document']);
      //Add Document
         Route::get("/dts/g-l-d",[App\Http\Controllers\systems\dts\user\AddDocumentController::class, 'get_documents_limit']);
         Route::get("/dts/g-t-n",[App\Http\Controllers\systems\dts\user\AddDocumentController::class, 'get_last_tracking_number']);
         Route::post("/dts/i-d",[App\Http\Controllers\systems\dts\user\AddDocumentController::class, 'insert_document']);
      //Incoming Documents
         Route::get('/dts/incoming-documents', [App\Http\Controllers\systems\dts\user\IncomingController::class, 'get_incoming_documents']);
         Route::post('/dts/receive-documents', [App\Http\Controllers\systems\dts\user\IncomingController::class, 'receive_documents']);
         
      //Recieved Documents
         Route::get('/dts/received-documents', [App\Http\Controllers\systems\dts\user\ReceivedController::class, 'get_received_documents']);
         Route::post('/dts/forward-documents', [App\Http\Controllers\systems\dts\user\ReceivedController::class, 'forward_documents']);
         Route::post('/dts/receive-errors', [App\Http\Controllers\systems\dts\user\ReceivedController::class, 'received_errors']);
      //Forwarded Documents
         Route::get('/dts/forwarded-documents', [App\Http\Controllers\systems\dts\user\ForwardedController::class, 'get_forwarded_documents']);
         Route::post('/dts/update-remarks', [App\Http\Controllers\systems\dts\user\ForwardedController::class, 'update_remarks']);
         Route::post('/dts/update-forwarded', [App\Http\Controllers\systems\dts\user\ForwardedController::class, 'update_forwarded']);
       //Outgoing Documents
         Route::get('/dts/outgoing-documents', [App\Http\Controllers\systems\dts\user\OutgoingController::class, 'get_outgoing_documents']);
         Route::post('/dts/outgoing-documents', [App\Http\Controllers\systems\dts\user\OutgoingController::class, 'outgoing_documents']);
         Route::post('/dts/r-f-o', [App\Http\Controllers\systems\dts\user\OutgoingController::class, 'received_from_outgoing']);
         Route::post('/dts/u-o-d', [App\Http\Controllers\systems\dts\user\OutgoingController::class, 'update_outgoing_documents']);
      //Action Logs
         Route::get('/dts/action-logs', [App\Http\Controllers\systems\dts\user\ActionLogsController::class, 'get_action_logs']);

      //Complete Documents
         Route::post('/dts/complete-docs', [App\Http\Controllers\systems\dts\admin\AllDocumentsController::class, 'complete_documents']);
      //Cancel Documents
         Route::post("/dts/cancel-documents",[ App\Http\Controllers\systems\dts\admin\AllDocumentsController::class, 'cancel_documents']);

      //Receiver
         //Receiver Incoming
            Route::get("/dts/receiver-incoming",[ App\Http\Controllers\systems\dts\receiver\IncomingController::class, 'get_receiver_incoming']);
      //Search 
            Route::get("/dts/search",[ App\Http\Controllers\systems\dts\user\MyDocumentsController::class, 'search']);
      
});


Route::middleware([SessionGuard::class])->prefix('/receiver')->group(function () {

    //Receiver View
         //Dashboard
         Route::get("/dts/dashboard",[ App\Http\Controllers\systems\dts\receiver\DashboardController::class, 'index']);
         Route::get("/dts/incoming",[ App\Http\Controllers\systems\dts\receiver\IncomingController::class, 'index']);
         Route::get("/dts/find-document",[ App\Http\Controllers\systems\dts\receiver\FindDocumentController::class, 'index']);
         // Route::get("/dts/received",[ App\Http\Controllers\systems\dts\receiver\ReceivedController::class, 'index']);

   //Receiver Actions
      //Incoming
         Route::get("/act/dts/g-r-i-d",[ App\Http\Controllers\systems\dts\receiver\IncomingController::class, 'get_receiver_incoming_documents']);
         Route::get("/act/dts/search-documents",[ App\Http\Controllers\systems\dts\receiver\FindDocumentController::class, 'search_documents']);
        

});



//ADMIN VIEW LLS_WHIP
Route::middleware([SessionGuard::class,AdminCheck::class])->prefix('/admin')->group(function () {
   //LLS

   //ADMIN WHIP
      //Dashboard
         Route::get("/whip/dashboard",[ App\Http\Controllers\systems\lls_whip\whip\admin\DashboardController::class, 'index']);
         Route::get("/whip/analytics",[ App\Http\Controllers\systems\lls_whip\whip\admin\DashboardController::class, 'analytics']);
      //Employees Record
         Route::get("/whip/employees-record",[ App\Http\Controllers\systems\lls_whip\both\EmployeeController::class, 'index']);
      //Contractors
         Route::get("/whip/add-new-contractor",[ App\Http\Controllers\systems\lls_whip\whip\both\ContractorsController::class, 'add_new_contractor']);
         Route::get("/whip/contractors-list",[ App\Http\Controllers\systems\lls_whip\whip\both\ContractorsController::class, 'contractors_list']);

         Route::get("/whip/contractor-information/{id}",[ App\Http\Controllers\systems\lls_whip\whip\both\ContractorsController::class, 'contractor_information']);
      //Projects
         // Route::get("/whip/add-new-project",[ App\Http\Controllers\systems\lls_whip\whip\both\ProjectsController::class, 'add_new_project']);
         Route::get("/whip/projects-list",[ App\Http\Controllers\systems\lls_whip\whip\both\ProjectsController::class, 'projects_list']);
         Route::get("/whip/pending-monitoring",[ App\Http\Controllers\systems\lls_whip\whip\admin\MonitoringController::class, 'pending_project_monitoring_view']);
         Route::get("/whip/approved-monitoring",[ App\Http\Controllers\systems\lls_whip\whip\admin\MonitoringController::class, 'approved_project_monitoring_view']);

         Route::get("/whip/project-information/{id}",[ App\Http\Controllers\systems\lls_whip\whip\both\ProjectsController::class, 'project_information']);
         
      //Positions
         Route::get("/whip/whip-positions",[ App\Http\Controllers\systems\lls_whip\both\PositionsController::class, 'index']);
      //Employment Status
         Route::get("/whip/employment-status",[ App\Http\Controllers\systems\lls_whip\both\EmploymentStatusController::class, 'index']);
      //Project Nature
          Route::get("/whip/project-nature",[ App\Http\Controllers\systems\lls_whip\whip\admin\ProjectNatureController::class, 'index']);
    
                                             //DOCUMENT TRACKING SYSTEM//
      //ADMIN DTS
         //Dashboard
         Route::get("/dts/dashboard",[ App\Http\Controllers\systems\dts\admin\DashboardController::class, 'index']);
         Route::get("/dts/analytics",[ App\Http\Controllers\systems\dts\admin\AnalyticsController::class, 'index']);
         //All Documents
         Route::get("/dts/all-documents",[ App\Http\Controllers\systems\dts\admin\AllDocumentsController::class, 'index']);
         //Manage Offices
         Route::get("/dts/offices",[ App\Http\Controllers\systems\dts\admin\OfficesController::class, 'index']);
         //Document Types
         Route::get("/dts/doc-types",[ App\Http\Controllers\systems\dts\admin\DocumentTypesController::class, 'index']);
         //Final Actions
         Route::get("/dts/final-actions",[ App\Http\Controllers\systems\dts\admin\FinalActionsController::class, 'index']);
         //Manage Staff
         Route::get("/dts/manage-staff",[ App\Http\Controllers\systems\dts\admin\StaffController::class, 'index']);
         //Manage Users
        
         //Logged In History
         // Route::get("/dts/logged-in-history",[ App\Http\Controllers\systems\dts\admin\LoggedInController::class, 'index']);
         //Action Logs
         Route::get("/dts/action-logs",[ App\Http\Controllers\systems\dts\admin\ActionLogsController::class, 'index']);
         //Action Logs
         Route::get("/dts/search-docs",[ App\Http\Controllers\systems\dts\both\SearchDocuments::class, 'index']);
         //View Document
         Route::get("/dts/view",[ App\Http\Controllers\systems\dts\both\SearchDocuments::class, 'view_document']);



});


// ADMIN ACTION LLS WHIP
Route::middleware([SessionGuard::class])->prefix('/admin/act')->group(function () {
   //LLS 

   // WHIP
      //Project Nature
         Route::post("/whip/i-u-p-n",[App\Http\Controllers\systems\lls_whip\whip\admin\ProjectNatureController::class, 'insert_update_nature']);
         Route::get("/whip/a-p-n",[App\Http\Controllers\systems\lls_whip\whip\admin\ProjectNatureController::class, 'get_all_project_nature']);
         Route::post("/whip/d-p-n",[App\Http\Controllers\systems\lls_whip\whip\admin\ProjectNatureController::class, 'delete_project_nature']);

      //Employment Status
         Route::get("/a-e-s",[App\Http\Controllers\systems\lls_whip\both\EmploymentStatusController::class, 'get_all_status']);
         Route::post("/i-u-e-s",[App\Http\Controllers\systems\lls_whip\both\EmploymentStatusController::class, 'insert_update_status']);
         Route::post("/d-s",[App\Http\Controllers\systems\lls_whip\both\EmploymentStatusController::class, 'delete_status']);

      //Project Monitoring
         Route::post("/whip/a-m",[ App\Http\Controllers\systems\lls_whip\whip\admin\MonitoringController::class, 'approved_monitoring']);
         Route::post("/whip/g-a-m",[ App\Http\Controllers\systems\lls_whip\whip\admin\MonitoringController::class, 'get_approved_monitoring']);
         Route::get("/whip/g-a-p-m",[ App\Http\Controllers\systems\lls_whip\whip\admin\MonitoringController::class, 'get_approved_project_monitoring']);
   // DTS
      //Analytics
         Route::post("/dts/d-t-analytics",[ App\Http\Controllers\systems\dts\admin\AnalyticsController::class, 'get_document_types_analytics']);
         Route::post("/dts/p-m-analytics",[ App\Http\Controllers\systems\dts\admin\AnalyticsController::class, 'get_per_month_analytics']);
      //All Documents
         Route::get("/dts/all-documents",[ App\Http\Controllers\systems\dts\admin\AllDocumentsController::class, 'get_all_documents']);
         Route::post("/dts/delete-documents",[ App\Http\Controllers\systems\dts\admin\AllDocumentsController::class, 'delete_documents']);
         Route::post("/dts/cancel-documents",[ App\Http\Controllers\systems\dts\admin\AllDocumentsController::class, 'cancel_documents']);
         Route::post("/dts/revert-document",[ App\Http\Controllers\systems\dts\admin\AllDocumentsController::class, 'revert_document']);
      //Offices
         Route::get("/dts/all-offices",[ App\Http\Controllers\systems\dts\admin\OfficesController::class, 'get_all_offices']);
         Route::post("/dts/i-u-o",[ App\Http\Controllers\systems\dts\admin\OfficesController::class, 'insert_update_office']);
         Route::post("/dts/d-o",[ App\Http\Controllers\systems\dts\admin\OfficesController::class, 'delete_office']);
      //Document Types
         Route::get("/dts/types",[ App\Http\Controllers\systems\dts\admin\DocumentTypesController::class, 'get_document_types']);
         Route::post("/dts/i-u-t",[ App\Http\Controllers\systems\dts\admin\DocumentTypesController::class, 'insert_update']);
         Route::post("/dts/d-t",[ App\Http\Controllers\systems\dts\admin\DocumentTypesController::class, 'delete']);
      //Final Actions
         Route::get("/dts/final-actions",[ App\Http\Controllers\systems\dts\admin\FinalActionsController::class, 'get_final_actions']);
         Route::post("/dts/i-u-f",[ App\Http\Controllers\systems\dts\admin\FinalActionsController::class, 'insert_update']);
         Route::post("/dts/d-f",[ App\Http\Controllers\systems\dts\admin\FinalActionsController::class, 'delete']);
      
      //Manage Users
         Route::get("/dts/all-users",[ App\Http\Controllers\systems\dts\admin\UsersController::class, 'get_all_users']);
         Route::get("/dts/g-c-r",[ App\Http\Controllers\systems\dts\admin\StaffController::class, 'get_current_receiver']);
         Route::get("/dts/g-c-oic",[ App\Http\Controllers\systems\dts\admin\StaffController::class, 'get_current_oic']);

         Route::post("/dts/update-receiver",[ App\Http\Controllers\systems\dts\admin\StaffController::class, 'update_receiver']);
         Route::post("/dts/update-oic",[ App\Http\Controllers\systems\dts\admin\StaffController::class, 'update_oic']);

      //Logged in History
         // Route::get("/dts/logged-in-history",[ App\Http\Controllers\systems\dts\admin\LoggedInController::class, 'get_logged_in_history']);
      //Action Logs
         Route::get("/dts/action-logs",[ App\Http\Controllers\systems\dts\admin\ActionLogsController::class, 'get_action_logs']);
});      