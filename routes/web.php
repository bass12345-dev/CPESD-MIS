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


//USER SECTION WHIP
Route::middleware([SessionGuard::class])->prefix('/user')->group(function () {
   //LLS
      //Dashboard
         Route::get("/whip/dashboard",[ App\Http\Controllers\systems\lls_whip\whip\user\DashboardController::class, 'index']);
      //Contractors
      Route::get("/whip/add-new-contractor",[ App\Http\Controllers\systems\lls_whip\whip\both\ContractorsController::class, 'add_new_contractor']);
      
});


//ADMIN SECTION WHIP
Route::middleware([SessionGuard::class,AdminCheck::class])->prefix('/admin')->group(function () {
   //WHIP
      //Dashboard
         Route::get("/whip/dashboard",[ App\Http\Controllers\systems\lls_whip\whip\admin\DashboardController::class, 'index']);
      //Contractors
         Route::get("/whip/add-new-contractor",[ App\Http\Controllers\systems\lls_whip\whip\both\ContractorsController::class, 'add_new_contractor']);
         Route::get("/whip/contractors-list",[ App\Http\Controllers\systems\lls_whip\whip\both\ContractorsController::class, 'contractors_list']);
   
});