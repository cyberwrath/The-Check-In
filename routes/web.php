<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TwilioSMSController;

/*
|--------------------------------------------------------------------------
| Web Routes
|------------ --------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
| 
*/
 
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Auth::routes();
Route::get('sendSMS', [TwilioSMSController::class, 'sendSMS']);
Route::post('/webhook', [TwilioSMSController::class, 'handleIncomingMessage']);
Route::get('/webhookk', [TwilioSMSController::class, 'handleIncomingMessage_get']); 
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::prefix('admin')->group(function() {
Route::group(['prefix' => 'admin', 'middlewareGroups' => ['role:admin', 'web']], function() {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/admin', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/friends/', [App\Http\Controllers\UserController::class, 'index'])->name('developers');
    Route::get('/friends/addDeveloper/{id}', [App\Http\Controllers\UserController::class, 'addDeveloper'])->name('addDeveloper');

    Route::post('/createDeveloper/{id}', [App\Http\Controllers\UserController::class, 'create'])->name('createDeveloper');
    Route::delete('/deleloper/delete/{id}', [App\Http\Controllers\UserController::class, 'deleteDeveloper'])->name('deleteDeveloper');

    // Groups
    Route::get('/addGroups/', [App\Http\Controllers\AdminController::class, 'addGroups'])->name('addGroups');
    Route::get('/Group/{id}', [App\Http\Controllers\AdminController::class, 'GroupDetail'])->name('GroupDetail');
    Route::post('/createGroup', [App\Http\Controllers\AdminController::class, 'createGroup'])->name('createGroup');
    Route::post('/assignFriends', [App\Http\Controllers\AdminController::class, 'assignFriends'])->name('assignFriends');
    Route::delete('/company/delete/{id}', [App\Http\Controllers\AdminController::class, 'deleteCompany'])->name('deleteCompany');
    Route::delete('/friends/delete/{user_id}/{group_id}', [App\Http\Controllers\UserController::class, 'deleteAssignedFriend'])->name('deleteAssignedFriend');
 
    // projects
    Route::get('/project/', [App\Http\Controllers\AdminController::class, 'ViewProject'])->name('project');
    Route::get('/project/addProject/{id}', [App\Http\Controllers\AdminController::class, 'addProject'])->name('addProject');
    Route::post('/createProject', [App\Http\Controllers\AdminController::class, 'createProjects'])->name('createProject');
    Route::delete('/project/delete/{id}', [App\Http\Controllers\AdminController::class, 'deleteProject'])->name('deleteProject');
     

    // Tasks
    Route::get('/tasks', [App\Http\Controllers\AdminController::class, 'tasks'])->name('tasks');
    Route::get('/taskdetail/{id}', [App\Http\Controllers\DeveloperController::class, 'ViewTaskDetail'])->name('adminviewtaskdetail');
    Route::get('/task/addTask/{company}/{project}/{id}', [App\Http\Controllers\AdminController::class, 'addTask'])->name('addTask');
    Route::post('/createTask', [App\Http\Controllers\AdminController::class, 'createTask'])->name('createTask');
    Route::delete('/task/delete/{id}', [App\Http\Controllers\AdminController::class, 'deleteTask'])->name('deleteTask');

    Route::get('/completedTask', [App\Http\Controllers\AdminController::class, 'ViewCompletedTask'])->name('adminCompletedTask');

    Route::post('/taskattachments', [App\Http\Controllers\AdminController::class, 'UploadTaskAttachemnt'])->name('taskattachments'); 
    Route::post('/RemoveTaskAttachment', [App\Http\Controllers\AdminController::class, 'RemoveTaskAttachment'])->name('RemoveTaskAttachment');

    // credentials
    Route::get('/credentials', [App\Http\Controllers\AdminController::class, 'LoginCredentials'])->name('credentials');

    //Payment records
     Route::get('/paymentRecords', [App\Http\Controllers\AdminController::class, 'paymentRecords'])->name('paymentRecords');
     Route::get('/payment/addPyment', [App\Http\Controllers\AdminController::class, 'addPyment'])->name('addPyment');
     Route::post('/payment/createPaymentRecord', [App\Http\Controllers\AdminController::class, 'createPaymentRecord'])->name('createPaymentRecord');
     Route::delete('/payment/delete/{id}', [App\Http\Controllers\AdminController::class, 'deletePaymentRecord'])->name('deletePaymentRecord');

    //developer notice
    Route::get('/notices', [App\Http\Controllers\AdminController::class, 'DeveloperNotices'])->name('notices');
    Route::get('/Addnotice', [App\Http\Controllers\AdminController::class, 'AddNoticeForm'])->name('Addnotice');
    Route::post('/createNotice', [App\Http\Controllers\AdminController::class, 'createNotice'])->name('createNotice');
    Route::delete('/notices/delete/{id}', [App\Http\Controllers\AdminController::class, 'deleteNotice'])->name('deleteNotice');

    // Ajax calls 

    Route::post('/getProjects', [App\Http\Controllers\AjaxController::class, 'getProjectsOfCompany'])->name('getProjects');
    Route::post('/UpdatePaymentStatus', [App\Http\Controllers\AjaxController::class, 'UpdatePaymentStatus'])->name('UpdatePaymentStatus');
    Route::post('/UpdateToDosOrder', [App\Http\Controllers\AjaxController::class, 'UpdateToDosOrder'])->name('UpdateToDosOrder');
});


Route::post('/UpdateTaskDiscussion', [App\Http\Controllers\AdminController::class, 'UpdateTaskDiscussion'])->name('UpdateTaskDiscussion'); 
Route::post('/UpdateNotification', [App\Http\Controllers\AjaxController::class, 'UpdateNotificationAsRead'])->name('UpdateNotification');
Route::post('/UpdatePaymentNotification', [App\Http\Controllers\AjaxController::class, 'UpdatePaymentNotificationAsRead'])->name('UpdatePaymentNotification');
Route::post('/UpdateNotice', [App\Http\Controllers\AjaxController::class, 'UpdateNoticeAsDismiss'])->name('UpdateNotice');


 Route::prefix('developer')->group(function(){
// Route::group(['prefix' => 'developer', 'middlewareGroups' => ['role:developer', 'web']], function() {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('devhome');
    Route::get('/taskdetail/{id}', [App\Http\Controllers\DeveloperController::class, 'ViewTaskDetail'])->name('viewtaskdetail');
    Route::get('/completedTask', [App\Http\Controllers\DeveloperController::class, 'ViewCompletedTask'])->name('developerCompletedTask');
    
    Route::get('/credentials', [App\Http\Controllers\DeveloperController::class, 'DevLoginCredentials'])->name('devcredentials');

    //////////////////
    // payments

    Route::get('/paymentRecords', [App\Http\Controllers\DeveloperController::class, 'paymentRecordsDev'])->name('paymentRecordsdev');
    
     // Ajax calls 
     Route::post('/getProjects', [App\Http\Controllers\AjaxController::class, 'getProjectsOfCompany'])->name('getProjects');
     Route::post('/UpdateTaskStatus', [App\Http\Controllers\AjaxController::class, 'UpdateTaskStatus'])->name('UpdateTaskStatus');
     
     
     
});



Route::post('/getTaskDetail', [App\Http\Controllers\AjaxController::class, 'getTaskDetail'])->name('getTaskDetail');
Route::post('/getTaskDetailField', [App\Http\Controllers\AjaxController::class, 'getTaskDetailField'])->name('getTaskDetailField');


