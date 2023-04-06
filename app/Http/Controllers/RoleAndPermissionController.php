<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionController extends Controller
{
    
    public function createRole(Request $request)
    {
        $request->validate(['name'=>'required','permission'=>'required|array']);
        $permissions = $request->permission;

        foreach($permissions as $per){
            try{

                Permission::findByName($per);
            }
            catch(\Exception $e){

                return response()->json(['message'=>$e->getMessage()],404);
            }
        }
        $role = Role::create(['name'=>$request->name]);
        $role->givePermissionTo($permissions);

        return response()->json(['role'=>$role]);
    }

    
    public function getRoles()
    {
        return response()->json(['roles'=>Role::all()]);
    }

    public function getSingleRole(Request $request)
    {
        return Role::findById($request->id);
    }
    
    public function updateRole(Request $request)
    {
        $role = Role::findById($request->id);

        $request->validate([
            'name'=>'required',
            'permissions'=>'required|array'
        ]);

        $permissions = $request->permissions;

        foreach($permissions as $per){
            try{

                Permission::findByName($per);
            }
            catch(\Exception $e){

                return response()->json(['message'=>$e->getMessage()],404);
            }
        }
        $role->update(['name'=>$request->name]);
        $role->syncPermissions($permissions);

        return response()->json([
            'message'=>'role updated successfully'
        ],200);

    
    }

    
    public function deleteRole(Request $request)
    {
        try{

            $role = Role::find($request->id);
            $per = $role->permissions()->pluck('name');

            foreach($per as $p){

                $role->revokePermissionTo($p);
            }

            $role->delete();

            return response()->json(['message'=>'ROLE DELETED'],200);
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    
        
    }

    public function createPermission(Request $request)
    {
        $request->validate(['name'=>'required']);

        $permission = Permission::create(['name'=>$request->name]);

        return response()->json(['role'=>$permission]);
    }

    
    public function getPermissions()
    {
        return response()->json(['roles'=>Permission::all()]);
    }

    public function getSinglePermission(Request $request)
    {
        return Permission::findById($request->id);
    }
    
    public function updatePermission(Request $request)
    {
        try{
        $permission = Permission::findById($request->id);
        $request->validate(['name'=>'required']);
        $permission->update(['name'=>$request->name]);
    
        return response()->json(['message'=>'permission updated successfully'],200);

        }   
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }

    
    }

    
    public function deletePermission(Request $request)
    {
        try{

            $permission = Permission::find($request->id);
            $permission->delete();
            return response()->json(['message'=>'permission DELETED'],200);
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    
        
    }

}
