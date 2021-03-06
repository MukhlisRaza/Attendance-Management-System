<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::prefix('/admin')->namespace('Admin')->group(function () {

    Route::match(['get', 'post'], '/', [App\Http\Controllers\Admin\AdminController::class, 'login']);
    Route::get("logout", [App\Http\Controllers\Admin\AdminController::class, 'logout']);

    Route::group(['middleware' => ['admin']], function () {
        Route::get('dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard']);
        Route::get('profile', [App\Http\Controllers\Admin\AdminController::class, 'profile']);
        Route::match(['get', 'post'], 'update-admin-image', [App\Http\Controllers\Admin\AdminController::class, 'updateAdminImage']);
        Route::get('view-students', [App\Http\Controllers\Admin\AdminController::class, 'viewStudents']);
        Route::get("student-detail/{id}", [App\Http\Controllers\Admin\AdminController::class, 'singleStudentDetails']);
        Route::get("student-attendance", [App\Http\Controllers\Admin\AdminController::class, 'studentAttendance']);
        Route::post('markAttendance', [App\Http\Controllers\Admin\AdminController::class, 'adminMarkAttendance']);
        Route::get("student-leave", [App\Http\Controllers\Admin\AdminController::class, 'studentLeave']);
        Route::post('markLeave', [App\Http\Controllers\Admin\AdminController::class, 'adminLeaves']);
        Route::get("student_report", [App\Http\Controllers\Admin\AdminController::class, 'studentReport']);
        Route::post('studentReport', [App\Http\Controllers\Admin\AdminController::class, 'singleStudentReport']);
        Route::get("system_report", [App\Http\Controllers\Admin\AdminController::class, 'systemReport']);
        Route::post('systemReport', [App\Http\Controllers\Admin\AdminController::class, 'allSystemReport']);
        Route::get("student_grading", [App\Http\Controllers\Admin\AdminController::class, 'studentGrading']);
        Route::post('studentGrade', [App\Http\Controllers\Admin\AdminController::class, 'studentGrade']);
    });
});


Route::namespace('Front')->group(function () {
    //Home Page Route

    Route::get('/', [App\Http\Controllers\Front\IndexController::class, 'login']);
    Route::post('/login', [App\Http\Controllers\Front\IndexController::class, 'userlogin']);
    Route::get('userRegister', [App\Http\Controllers\Front\IndexController::class, 'register']);
    Route::post('user-register', [App\Http\Controllers\Front\IndexController::class, 'userRegister']);
    Route::get('studentlogout', [App\Http\Controllers\Front\IndexController::class, 'logout']);


    // Middleware
    Route::group(['middleware' => ['auth']], function () {
        Route::match(['get', 'post'], 'studentdashboard', [App\Http\Controllers\Front\IndexController::class, 'dashboard']);
        Route::get('profile', [App\Http\Controllers\Front\IndexController::class, 'profile']);
        Route::match(['get', 'post'], 'update-student-image', [App\Http\Controllers\Front\IndexController::class, 'updateStudentImage']);
        Route::get('attendance', [App\Http\Controllers\Front\IndexController::class, 'attendance']);
        Route::post('mark-attendance', [App\Http\Controllers\Front\IndexController::class, 'markAttendance']);
        Route::get('view-attendance', [App\Http\Controllers\Front\IndexController::class, 'viewAttendance']);
        Route::get('leave', [App\Http\Controllers\Front\IndexController::class, 'leave']);
        Route::get('request-leave', [App\Http\Controllers\Front\IndexController::class, 'requestLeave']);
        Route::post('request-form', [App\Http\Controllers\Front\IndexController::class, 'requestForm']);
    });
});
