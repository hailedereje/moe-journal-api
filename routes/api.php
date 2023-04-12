<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JhiUserController;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RoleAndPermissionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login',[AuthController::class,'login'])->name('login');
Route::get('/users',[AuthController::class,'users']);
Route::delete('/delete',[AuthController::class,'deleteAllUser']);
// ->middleware('auth:sanctum');
Route::patch('/update',[AuthController::class,'update']);
Route::get('/logout',[AuthController::class,'logout']);
// ->middleware('auth:sanctum');

Route::post('/pra',[PracticeController::class,'practice']);

Route::post('/jhi/add',[JhiUserController::class,'registerJhiUser']);
Route::post('/jhi/search',[JhiUserController::class,'search']);
Route::get('/jhi/users',[JhiUserController::class,'users']);
Route::post('/jhi/edit/{id}',[JhiUserController::class,'edite']);
Route::delete('/jhi/delete/{id}',[JhiUserController::class,'deleteJhi']);


Route::middleware(['auth:sanctum', 'role:MOE'])->group(function () {

    //register users
Route::post('/add',[AuthController::class,'registerUser']);



    // Routes for department section
Route::post('/department', [DepartmentController::class, 'newDepartment']);
Route::get('/departments', [DepartmentController::class, 'getAllDepartments']);
Route::patch('/department/edit/{id}', [DepartmentController::class, 'editDepartment']);
Route::delete('/department/{id}', [DepartmentController::class, 'deleteDepartment']); 
});



// Assign a role to a user
Route::post('/users/{user}/roles/{role}', [RoleAndPermissionController::class, 'assignRole']);

// Assign a permission to a user
Route::post('/users/{user}/permissions/{permission}', [RoleAndPermissionController::class, 'assignPermission']);

// Revoke a role from a user
Route::delete('/users/{user}/roles/{role}', [RoleAndPermissionController::class, 'revokeRole']);

// Revoke a permission from a user
Route::delete('/users/{user}/permissions/{permission}', [RoleAndPermissionController::class, 'revokePermission']);


// Assign a permission to a role
Route::post('/roles/{role}/permissions/{permission}', [RoleAndPermissionController::class, 'assignPermissionToRole']);
// Revoke a permission from a role
Route::delete('/roles/{role}/permissions/{permission}', [RoleAndPermissionController::class, 'revokePermissionFromRole']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

