<?php

use Illuminate\Support\Facades\Route;
 use App\Http\Controllers\AdminController;
 use App\Http\Controllers\AuthController;
 use App\Http\Controllers\departmentController;
  use App\Http\Controllers\EmployeeController;
  use App\Http\Controllers\projectController;
    use App\Http\Controllers\userController;
     use App\Http\Controllers\ChapterController;
      use App\Http\Controllers\CommentController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[App\Http\Controllers\userController::class,'withoutlogincreateticket'])->name('home');
Route::post('/ticketfile',[App\Http\Controllers\AdminController::class,'createticketfile'])->name('ticketfile');
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-registration', [AuthController::class, 'Add'])->name('register.post'); 

Route::post('login', [AuthController::class, 'postLogin'])->name('login'); 
Route::get('logout', [AuthController::class, 'logouts'])->name('logout');

Route::get('registration', [AuthController::class, 'registration'])->name('register');


Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin', [AdminController::class, 'index'])
        ->middleware('admin')
        ->name('admin');

    Route::get('/tickets', [AdminController::class, 'index1'])->name('tickets');

Route::get('viewticket', [AdminController::class, 'viewtickets'])->name('viewticket');
    Route::get('/projects',[App\Http\Controllers\projectController::class,'projects'])->name('projects');
Route::POST('/projectstore',[App\Http\Controllers\projectController::class,'projectstore'])->name('projectstore');
Route::delete('/projectdestroy/{id}',[App\Http\Controllers\projectController::class,'projectdestroy'])->name('projectdestroy');
Route::put('/projectupdate/{id}',[App\Http\Controllers\projectController::class,'projectupdate'])->name('projectupdate');
Route::get('/update_project',[App\Http\Controllers\projectController::class,'status']);

Route::get('/createusers',[App\Http\Controllers\AdminController::class,'usersview'])->name('createusers');
Route::delete('/destroyuser/{id}',[App\Http\Controllers\AdminController::class,'destroyusers'])->name('destroyuser');
Route::put('/updateuser/{id}',[App\Http\Controllers\AdminController::class,'updateusers'])->name('updateuser');

Route::get('/department',[App\Http\Controllers\departmentController::class,'department'])->name('department');
Route::get('/departmentcreate',[App\Http\Controllers\departmentController::class,'departmentcreate']);
Route::get('/departmentedit,{id}',[App\Http\Controllers\departmentController::class,'departmentedit'])->name('departmentedit');


Route::POST('/departmentstore',[App\Http\Controllers\departmentController::class,'departmentstore']);
Route::delete('/departmentdestroy/{id}',[App\Http\Controllers\departmentController::class,'departmentdestroy'])->name('departmentdestroy');
Route::put('/departmentupdate/{id}',[App\Http\Controllers\departmentController::class,'departmentupdate'])->name('departmentupdate');

});
Route::group(['middleware' => ['auth']], function () {





Route::get('/create',[App\Http\Controllers\AdminController::class,'create']);
Route::get('/edit,{id}',[App\Http\Controllers\AdminController::class,'edit'])->name('edit');


Route::POST('/store',[App\Http\Controllers\AdminController::class,'store']);
Route::delete('/destroy/{id}',[App\Http\Controllers\AdminController::class,'destroy'])->name('destroy');
Route::put('/update/{id}',[App\Http\Controllers\AdminController::class,'update'])->name('update');


// Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 


// ------------------department----------------------------------------------




Route::get('/role',[App\Http\Controllers\EmployeeController::class,'role'])->name('role');
Route::get('/create_employee',[App\Http\Controllers\EmployeeController::class,'employee'])->name('employee');
Route::get('/employeelist',[App\Http\Controllers\EmployeeController::class,'employeelist'])->name('employeelist');


Route::get('/createticket',[App\Http\Controllers\AdminController::class,'createticket'])->name('createticket');

Route::get('/update_status',[App\Http\Controllers\departmentController::class,'status']);





Route::get('/member',[App\Http\Controllers\userController::class,'memberindex'])->name('member');
Route::get('/mytickets',[App\Http\Controllers\userController::class,'myticketslist'])->name('mytickets');
Route::get('addfilters',[App\Http\Controllers\userController::class,'filters'])->name('addfilters');
Route::get('viewfile',[App\Http\Controllers\AdminController::class,'allfiles'])->name('viewfile');
Route::delete('/deletetickets/{id}',[App\Http\Controllers\userController::class,'deleteticket'])->name('deletetickets');
Route::get('edit_ticket/{id}', [userController::class, 'editticket'])->name('edit_ticket');
;
Route::post('update-ticket', [userController::class, 'updateticket']);
Route::put('update-ticket/{id}', [userController::class, 'updateticket']);

Route::get('ticketdetails/{id}', [userController::class, 'ticketview'])->name('ticketdetails');


Route::get('/tickets_status',[App\Http\Controllers\AdminController::class,'tickets_status']);

Route::get('/notify/{id}',[App\Http\Controllers\AdminController::class,'markAsReads'])->name('notify');
Route::get('/notifies',[App\Http\Controllers\AdminController::class,'markAllRead'])->name('notifies');

Route::get('/deleteadmintickets/{id}',[App\Http\Controllers\AdminController::class,'deleteadminticket'])->name('deleteadmintickets');
// Route::post('/createticketfile',[App\Http\Controllers\userController::class,'createticketfiles'])->name('createticketfile');
Route::get('/files/{id}',[App\Http\Controllers\AdminController::class,'viewfile'])->name('files');
Route::get('/getUsers', [userController::class, 'getUsers']);
Route::get('/getUserbyid', [userController::class, 'getUserbyid']);
Route::post('image/delete',[AdminController::class,'fileDestroy']);
Route::get('logo_edit',[EmployeeController::class,'Editlogo'])->name('logo_edit');
Route::post('update_logo',[EmployeeController::class,'updatelogo'])->name('update_logo');


});
Route::GET('searchticket',[userController::class,'search_by_id'])->name('searchticket');
Route::get('/user_committee',[App\Http\Controllers\departmentController::class,'commiitteedata'])->name('user_committee');
Route::get('forget-password', [AuthController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [AuthController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [AuthController::class, 'submitResetPasswordForm'])->name('reset.password.post');
Route::get('chapters',[ChapterController::class,'viewchapter'])->name('chapters');
Route::delete('/chapterdestroy/{id}',[App\Http\Controllers\ChapterController::class,'chapterdestroy'])->name('chapterdestroy');

Route::post('chaptercreate',[App\Http\Controllers\ChapterController::class,'chaptercreate'])->name('chaptercreate');
Route::put('/chapterupdate/{id}',[App\Http\Controllers\ChapterController::class,'chapterupdate'])->name('chapterupdate');

Route::get('/reply/store',[App\Http\Controllers\CommentController::class,'store'])->name('reply.add');
Route::get('/delete_comments', [CommentController::class, 'commentDelete']);
Route::get('/deleteimages',[App\Http\Controllers\AdminController::class,'delete_images'])->name('deleteimages');
Route::get('/tickets_status_change',[App\Http\Controllers\AdminController::class,'status_change']);
Route::get('/image-upload', [userController::class, 'image_upload']);
Route::get('/removefilter', [AuthController::class, 'removesession']);
Route::post('post-reorder', [App\Http\Controllers\AdminController::class, 'reorder']);














