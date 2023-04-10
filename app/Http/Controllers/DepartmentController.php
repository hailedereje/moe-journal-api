<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function store(Request $request){
        try{
            $request->validate([
                'name'=>'required|unique:departments,name,except,id'
            ]);
            $department = Department::create($request->all());
            return response()->json(["message"=>"department created","department"=>$department],200);

        }catch(\Exception $e){
            return response()->json(["error"=>$e->getMessage()]);
        }
    }
}
