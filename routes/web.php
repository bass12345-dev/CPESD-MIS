<?php

use App\Http\Middleware\AdminCheck;
use App\Http\Middleware\DtsCheck;
use App\Http\Middleware\RFACheck;
use App\Http\Middleware\SessionGuard;
use App\Http\Middleware\UserLoginCheck;
use App\Http\Middleware\WatchCheck;
use App\Http\Middleware\WhipCheck;
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
   $data['systems']   = config('custom_config._systems');
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

                                       //System
      //System Authorization
          Route::get("/sysm/c-i-a",[ App\Http\Controllers\system_management\ManageUserController::class, 'check_authorized']);
                                          //LABOR LOCALIZATIOn
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
        
                                          //WORKERS HIRED INFRASTRACTURE PROJECT
         Route::middleware([WhipCheck::class])->prefix('/whip')->group(function () {
         //Dashboard
             Route::get("/dashboard",[ App\Http\Controllers\systems\lls_whip\whip\user\DashboardController::class, 'index']);
         //Employees Record
            Route::get("/employees-record",[ App\Http\Controllers\systems\lls_whip\both\EmployeeController::class, 'index']);
         //Contractors
            Route::get("/add-new-contractor",[ App\Http\Controllers\systems\lls_whip\whip\both\ContractorsController::class, 'add_new_contractor']);
            Route::get("/contractors-list",[ App\Http\Controllers\systems\lls_whip\whip\both\ContractorsController::class, 'contractors_list']);
            Route::get("/contractor-information/{id}",[ App\Http\Controllers\systems\lls_whip\whip\both\ContractorsController::class, 'contractor_information']);
         //Projects
            Route::get("/add-new-project",[ App\Http\Controllers\systems\lls_whip\whip\both\ProjectsController::class, 'add_new_project']);
            Route::get("/projects-list",[ App\Http\Controllers\systems\lls_whip\whip\both\ProjectsController::class, 'projects_list']);
            Route::get("/project-information/{id}",[ App\Http\Controllers\systems\lls_whip\whip\both\ProjectsController::class, 'project_information']);
         //Project Monitoring
            Route::get("/add-monitoring",[ App\Http\Controllers\systems\lls_whip\whip\user\MonitoringController::class, 'add_monitoring_view']);
            Route::get("/pending-projects-monitoring",[ App\Http\Controllers\systems\lls_whip\whip\user\MonitoringController::class, 'pending_project_monitoring_view']);
            Route::get("/project-monitoring-info/{id}",[ App\Http\Controllers\systems\lls_whip\whip\user\MonitoringController::class, 'project_monitoring_information']);
            Route::get("/approved-projects-monitoring",[ App\Http\Controllers\systems\lls_whip\whip\user\MonitoringController::class, 'approved_project_monitoring_view']);
            //Reports
            Route::get("/monitoring-report/{id}",[ App\Http\Controllers\systems\lls_whip\whip\user\MonitoringController::class, 'view_monitoring_report']);
         //Positions
            Route::get("/whip-positions",[ App\Http\Controllers\systems\lls_whip\both\PositionsController::class, 'index']);
         });

   
                                          //DOCUMENT TRACKING SYSTEM//
         Route::middleware([DtsCheck::class])->prefix('/dts')->group(function () {
         //USER
            //Dashboard
            Route::get("/dashboard",[ App\Http\Controllers\systems\dts\user\DashboardController::class, 'index']);
            //My documents
            Route::get("/my-documents",[ App\Http\Controllers\systems\dts\user\MyDocumentsController::class, 'index']);
            //Add Documents
            Route::get("/add-document",[ App\Http\Controllers\systems\dts\user\AddDocumentController::class, 'index']);
            //Incoming
            Route::get("/incoming",[ App\Http\Controllers\systems\dts\user\IncomingController::class, 'index']);
            //Received
            Route::get("/received",[ App\Http\Controllers\systems\dts\user\ReceivedController::class, 'index']);
            //Forwarded
            Route::get("/forwarded",[ App\Http\Controllers\systems\dts\user\ForwardedController::class, 'index']);
            //Outgoing
            Route::get("/outgoing",[ App\Http\Controllers\systems\dts\user\OutgoingController::class, 'index']);
            //Action Logs
            Route::get("/action-logs",[ App\Http\Controllers\systems\dts\user\ActionLogsController::class, 'index']);
            //Search Documents
            Route::get("/search-docs",[ App\Http\Controllers\systems\dts\both\SearchDocuments::class, 'index']);
            //View Document
            Route::get("/view",[ App\Http\Controllers\systems\dts\both\SearchDocuments::class, 'view_document']);
         });

                                       //WATCHLISTED//
         Route::middleware([WatchCheck::class])->prefix('/watchlisted')->group(function () {
         //USER
            //Dashboard
            Route::get("/dashboard",[ App\Http\Controllers\systems\watchlisted\user\DashboardController::class, 'index']);
            //Approved
            Route::get("/approved",[ App\Http\Controllers\systems\watchlisted\user\ApprovedController::class, 'index']);
            //Pending
            Route::get("/pending",[ App\Http\Controllers\systems\watchlisted\user\PendingController::class, 'index']);
            //Removed
            Route::get("/removed",[ App\Http\Controllers\systems\watchlisted\user\RemovedController::class, 'index']);
            //Search
            Route::get("/search",[ App\Http\Controllers\systems\watchlisted\user\SearchController::class, 'index']);
            //Add
            Route::get("/add",[ App\Http\Controllers\systems\watchlisted\user\AddController::class, 'index']);
            //View
            Route::get("/view_profile/{id}",[ App\Http\Controllers\systems\watchlisted\user\ViewController::class, 'index']);
         });

         Route::middleware([RFACheck::class])->prefix('/rfa')->group(function () {
         //USER
            //Dashboard
            Route::get("/dashboard",[ App\Http\Controllers\systems\rfa\user\DashboardController::class, 'index']);
            //Add
            Route::get("/add",[ App\Http\Controllers\systems\rfa\user\AddController::class, 'index']);
            //Pending Encoded
            Route::get("/pending",[ App\Http\Controllers\systems\rfa\user\PendingController::class, 'index']);
            Route::get("/update-rfa/{id}",[ App\Http\Controllers\systems\rfa\user\PendingController::class, 'update_rfa_view']);
            //Approved Transactions
            Route::get("/completed",[ App\Http\Controllers\systems\rfa\user\CompletedController::class, 'index']);
            //Referred Transactions
            Route::get("/referred",[ App\Http\Controllers\systems\rfa\user\ReferredController::class, 'index']);
            //Clients
            Route::get("/clients",[ App\Http\Controllers\systems\rfa\user\ClientController::class, 'index']);


         });

});


//USER ACTION LLS_WHIP
Route::middleware([SessionGuard::class])->prefix('/user/act')->group(function () {
                                 //LABOR LOCALIZATION
      //POSITIONS
      Route::get("/lls/a-p",[App\Http\Controllers\systems\lls_whip\both\PositionsController::class, 'get_all_lls_positions']);
      Route::post("/lls/i-u-p",[App\Http\Controllers\systems\lls_whip\both\PositionsController::class, 'insert_update_position_lls']);
      //ESTABLISHMENTS
      Route::post("/lls/insert-es",[App\Http\Controllers\systems\lls_whip\lls\both\EstablishmentsController::class, 'insert_establishment']);
      Route::get("/lls/g-a-e",[App\Http\Controllers\systems\lls_whip\lls\both\EstablishmentsController::class, 'get_all_establishment']);
      Route::post("/lls/d-e",[App\Http\Controllers\systems\lls_whip\lls\both\EstablishmentsController::class, 'delete_establishment']);
      Route::post("/lls/u-e",[App\Http\Controllers\systems\lls_whip\lls\both\EstablishmentsController::class, 'update_establishment']);


                                 //WORKERS HIRED INFRASTRACTURE PROJECT
      //Dashboard
         Route::get("/whip/g-c-i-o",[ App\Http\Controllers\systems\lls_whip\whip\admin\DashboardController::class, 'get_contractors_inside_outside']);
         Route::get("/whip/g-w-i-o",[ App\Http\Controllers\systems\lls_whip\whip\admin\DashboardController::class, 'get_workers_inside_outside']);
         Route::get("/whip/g-d-p-p-b",[ App\Http\Controllers\systems\lls_whip\whip\admin\DashboardController::class, 'get_projects_per_barangay']);
         Route::get("/whip/g-w-m-a",[ App\Http\Controllers\systems\lls_whip\whip\admin\DashboardController::class, 'get_monitoring_analytics']);

         
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
   
                                 //DOCUMENT TRACKING SYSTEM//

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



                              //WHIP
         //Add
            Route::post("/watchlisted/i-p",[App\Http\Controllers\systems\watchlisted\user\AddController::class, 'insert_person']);
         //Pending
            Route::get("/watchlisted/g-p-w",[App\Http\Controllers\systems\watchlisted\user\PendingController::class, 'get_pending_watchlisted']);
            Route::post("/watchlisted/d-p",[App\Http\Controllers\systems\watchlisted\user\PendingController::class, 'delete_person']);
         //Approved
            Route::get("/watchlisted/g-a-w",[App\Http\Controllers\systems\watchlisted\user\ApprovedController::class, 'get_approved_watchlisted']);
         //Removed
            Route::get("/watchlisted/g-r-w",[App\Http\Controllers\systems\watchlisted\user\RemovedController::class, 'get_removed_watchlisted']);
         //Search
            Route::post("/watchlisted/search-query",[App\Http\Controllers\systems\watchlisted\both\SearchController::class, 'search_query']);
         //Info
            Route::get("/watchlisted/g-w-r",[App\Http\Controllers\systems\watchlisted\both\ViewController::class, 'get_watchlisted_records']);
         //Records
            Route::post("/watchlisted/i-u-r",[App\Http\Controllers\systems\watchlisted\both\ViewController::class, 'insert_update_records']);
            Route::post("/watchlisted/delete-record",[App\Http\Controllers\systems\watchlisted\both\ViewController::class, 'delete_record']);



                                 //RFA
         //User

         //Dashboard
            Route::post("/rfa/l-u-c-r-t-d",[App\Http\Controllers\systems\rfa\user\DashboardController::class, 'get_user_chart_rfa_transaction_data']);
         //Pending
            Route::get("/rfa/g-u-p-r",[App\Http\Controllers\systems\rfa\user\PendingController::class, 'get_user_pending_rfa']);
            Route::get("/rfa/g-p-t-l",[App\Http\Controllers\systems\rfa\user\PendingController::class, 'get_pending_transactions_limit']);
            Route::post("/rfa/get-rfa-data",[App\Http\Controllers\systems\rfa\user\PendingController::class, 'get_rfa_data']);
         //Completed
            Route::get("/rfa/get-user-completed-rfa",[App\Http\Controllers\systems\rfa\user\CompletedController::class, 'get_user_completed_rfa']);
         //Reference Number
            Route::get("/rfa/g-l-r-n",[App\Http\Controllers\systems\rfa\user\AddController::class, 'get_last_ref_number']);
         //Client
            Route::post("/rfa/s-c",[App\Http\Controllers\systems\rfa\user\ClientController::class, 'search_name']);
            Route::post("/rfa/a-c",[App\Http\Controllers\systems\rfa\user\ClientController::class, 'add_client']); 
            Route::get("/rfa/get-my-clients",[App\Http\Controllers\systems\rfa\user\ClientController::class, 'get_my_clients']); 
         //Transactions      
            Route::post("/rfa/add-rfa",[App\Http\Controllers\systems\rfa\user\ClientController::class, 'add_rfa']); 
            Route::post("/rfa/update-rfa",[App\Http\Controllers\systems\rfa\user\ClientController::class, 'update_rfa']); 
         //Referral
             Route::post("/rfa/update-referral",[App\Http\Controllers\systems\rfa\user\PendingController::class, 'update_referral']); 
             Route::get("/rfa/g-u-r-r",[App\Http\Controllers\systems\rfa\user\ReferredController::class, 'get_user_referred_rfa']); 
         //Action Taken
            Route::post("/rfa/view-action-taken",[App\Http\Controllers\systems\rfa\user\ReferredController::class, 'view_action_taken']); 
            Route::post("/rfa/accomplish-rfa",[App\Http\Controllers\systems\rfa\user\ReferredController::class, 'accomplish_rfa']); 
         
         

      
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
      //ADMIN 
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


                                 //Watchlisted

         //Dashboard
         Route::get("/watchlisted/dashboard",[ App\Http\Controllers\systems\watchlisted\admin\DashboardController::class, 'index']);
         Route::get("/watchlisted/to-approve",[ App\Http\Controllers\systems\watchlisted\admin\ToApproveController::class, 'index']);
         Route::get("/watchlisted/approved",[ App\Http\Controllers\systems\watchlisted\admin\ApprovedController::class, 'index']);
         Route::get("/watchlisted/restore",[ App\Http\Controllers\systems\watchlisted\admin\RemoveController::class, 'index']);
         Route::get("/watchlisted/add",[ App\Http\Controllers\systems\watchlisted\admin\AddController::class, 'index']);
         Route::get("/watchlisted/search",[ App\Http\Controllers\systems\watchlisted\admin\SearchController::class, 'index']);
         Route::get("/watchlisted/manage-program",[ App\Http\Controllers\systems\watchlisted\admin\ProgramController::class, 'index']);
         Route::get("/watchlisted/activity-logs",[ App\Http\Controllers\systems\watchlisted\admin\ActivityLogsController::class, 'index']);

         //View Profile
         Route::get("/watchlisted/view_profile/{id}",[ App\Http\Controllers\systems\watchlisted\admin\ViewController::class, 'index']);
         
                                 //RFA
         


         



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
         Route::get("/whip/g-p-p-m",[ App\Http\Controllers\systems\lls_whip\whip\admin\MonitoringController::class, 'get_pending_project_monitoring']);
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


                                    //Watchlisted
         //Dashboard
            Route::get("/watchlisted/data-per-barangay",[ App\Http\Controllers\systems\watchlisted\admin\DashboardController::class, 'data_per_barangay']);
            Route::post("/watchlisted/l-c-g-a",[ App\Http\Controllers\systems\watchlisted\admin\DashboardController::class, 'count_gender_active_chart']);

         //To Approved
            Route::get("/watchlisted/t-a-w",[ App\Http\Controllers\systems\watchlisted\admin\ToApproveController::class, 'to_approved_watchlisted']);
            Route::post("/watchlisted/a-w",[ App\Http\Controllers\systems\watchlisted\admin\ToApproveController::class, 'approved_watchlisted']);
         //Approved 
            Route::get("/watchlisted/g-a-w",[ App\Http\Controllers\systems\watchlisted\admin\ApprovedController::class, 'get_approved_watchlisted']);
         //Removed
            Route::get("/watchlisted/r-f-w",[ App\Http\Controllers\systems\watchlisted\admin\RemoveController::class, 'remove_from_watchlisted']);
         //Restore
             Route::post("/watchlisted/c-s",[ App\Http\Controllers\systems\watchlisted\admin\ApprovedController::class, 'change_status']);
         //Manage Program
            Route::post("/watchlisted/i-u-p",[ App\Http\Controllers\systems\watchlisted\admin\ProgramController::class, 'insert_update_program']);
            Route::get("/watchlisted/get-programs",[ App\Http\Controllers\systems\watchlisted\admin\ProgramController::class, 'get_programs']);
            Route::post("/watchlisted/delete-program",[ App\Http\Controllers\systems\watchlisted\admin\ProgramController::class, 'delete_program']);
            Route::get("/watchlisted/get-act-logs",[ App\Http\Controllers\systems\watchlisted\admin\ActivityLogsController::class, 'get_activity_logs']);
         //Save Person Programs
            Route::post('/watchlisted/s-p-p', [App\Http\Controllers\systems\watchlisted\admin\ViewController::class, 'save_record_program']);
         //Update Information
             Route::post('/watchlisted/update-info', [App\Http\Controllers\systems\watchlisted\admin\ViewController::class, 'update_information']);

         
});         