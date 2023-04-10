<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\response;
use App\Http\Requests\DeleteDepartmentRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DepartmentController extends Controller
{
    // add new dep
    public function newDepartment(Request $request){
      
      

        try {
            $depData = $request->validate([
                'name' => 'required|unique:departments,name'
            ]);
            
            $department = Department::create($depData);
        
            $response = [
                'status' => 1,
                'message' => 'Department added successfully!',
                'department' => $department
            ];
        
            return response()->json($response, 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $response = [
                'status' => 0,
                'message' => 'Validation error',
                'errors' => $e->validator->getMessageBag()
            ];
        
            return response()->json($response, 422);
        } catch (\Exception $e) {
            $response = [
                'status' => 0,
                'message' => 'Failed to add department',
                'error' => $e->getMessage()
            ];
        
            return response()->json($response, 500);
        }
    }

    //get all depatment
    public function getAllDepartments()
{
    try {
        $departments = Department::all();
        $response = [
            'status' => 1,
            'message' => 'All departments retrieved successfully!',
            'departments' => $departments
        ];
        return response()->json($response, 200);
    } catch (\Exception $e) {
        $response = [
            'status' => 0,
            'message' => 'Failed to retrieve departments',
            'error' => $e->getMessage()
        ];
        return response()->json($response, 500);
    }
}

   //edit department

public function editDepartment(Request $request, $id)
{
    try {
        $dep = Department::findOrFail($id);
        $dep->update($request->all());
        $response = [
            'status' => 1,
            'message' => 'Department updated successfully!',
            'department' => $dep
        ];
        return response()->json($response, 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        $response = [
            'status' => 0,
            'message' => 'Department not found!',
            'error' => $e->getMessage()
        ];
        return response()->json($response, 404);
    } catch (\Exception $e) {
        $response = [
            'status' => 0,
            'message' => 'Failed to update department',
            'error' => $e->getMessage()
        ];
        return response()->json($response, 500);
    }
}


public function deleteDepartment(Request $request, string $id) {
        try {
            
            Department::findOrFail($id)->delete();
            return response()->json([
                'status' => 1,
                'message' => 'Department Deleted',
                'code' => 200
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Department not found',
                'code' => 404
            ]);
        }


}
}
