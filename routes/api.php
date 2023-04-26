<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JhiUserController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfessionController;
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

Route::post('/add',[AuthController::class,'registerUser']);

Route::middleware(['auth:sanctum', 'role:MOE'])->group(function () {

    //register users
// Route::post('/add',[AuthController::class,'registerUser']);



    // Routes for department section
Route::post('/department', [DepartmentController::class, 'newDepartment']);
Route::get('/departments', [DepartmentController::class, 'getAllDepartments']);
Route::patch('/department/edit/{id}', [DepartmentController::class, 'editDepartment']);
Route::delete('/department/{id}', [DepartmentController::class, 'deleteDepartment']); 
});


   // Routes for the assigning the role and permission to the user
Route::post('/users/{user}/roles/{role}', [RoleAndPermissionController::class, 'assignRole']); // Assign a role to a user
Route::post('/users/{user}/permissions/{permission}', [RoleAndPermissionController::class, 'assignPermission']); // Assign a permission to a user
Route::delete('/users/{user}/roles/{role}', [RoleAndPermissionController::class, 'revokeRole']); // Revoke a role from a user
Route::delete('/users/{user}/permissions/{permission}', [RoleAndPermissionController::class, 'revokePermission']); // Revoke a permission from a user

  // Routes to assign or revoke the permission to/from the role model
Route::post('/roles/{role}/permissions/{permission}', [RoleAndPermissionController::class, 'assignPermissionToRole']); // Assign a permission to a role
Route::delete('/roles/{role}/permissions/{permission}', [RoleAndPermissionController::class, 'revokePermissionFromRole']); // Revoke a permission from a role



// Journal Routes
Route::post('/journals', [JournalController::class, 'savePost']); // Submit a journal
// Route::get('/journals/{institution_id}', [JournalController::class, 'indexByInstitution']); // Get journals by institution ID
// Route::get('journals/{id}/search', [JournalController::class, 'searchByJHI']); // Search journals by JHI
Route::get('/journals', [JournalController::class, 'index']); // Get all journals

Route::delete('journals/{id}', [JournalController::class, 'destroy']); // Delete a journal
Route::get('journals/{id}', [JournalController::class,'show']); // Get details about a journal
// Route::get('journals/search', [JournalController::class, 'search']); // Search all journals

   // Routes for profession 
   Route::post('/profession', [ProfessionController::class, 'newProfession']);
   Route::get('/professions', [ProfessionController::class, 'getAllProfessions']);
   Route::patch('/profession/edit/{id}', [ProfessionController::class, 'editProfession']);
   Route::delete('/profession/{id}', [ProfessionController::class, 'deleteProfession']); 

    //attaching and detaching Profession from the user
    Route::post('/users/{userId}/professions/{professionId}', [ProfessionController::class,'attachProfessionToUser']);
    Route::delete('/users/{userId}/professions/{professionId}', [ProfessionController::class,'detachProfessionFromUser']);
    


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

