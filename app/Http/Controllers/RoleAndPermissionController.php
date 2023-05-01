<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    
    public function createRole(Request $request)
    {
        try{
            $request->validate(['name'=>['required','unique:roles,name']]);
            $role = Role::create($request->all());
            return response()->json(['message'=>$role]);
        }catch(\Exception $e){
            return response()->json(['message'=>$e->getMessage()]);
        }
    }

/**
 * Assign the specified role to the user.
 *
 * @param Request $request
 * @param User $user
 * @param Role $role
 * @return \Illuminate\Http\Response
 */
public function assignRole(Request $request, User $user, Role $role)
{
    try {
        $user->assignRole($role);
        return response()->json(['message' => 'Role assigned successfully']);
    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 500);
    }
}
/**
 * Assign the specified permission to the user.
 *
 * @param Request $request
 * @param User $user
 * @param Permission $permission
 * @return \Illuminate\Http\Response
 */
public function assignPermission(Request $request, User $user, Permission $permission)
{
    try {
        $user->givePermissionTo($permission);
        return response()->json(['message' => 'Permission assigned successfully']);
    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 500);
    }
}
/**
 * Revoke the specified role from the user.
 *
 * @param Request $request
 * @param User $user
 * @param Role $role
 * @return \Illuminate\Http\Response
 */
public function revokeRole(Request $request, User $user, Role $role)
{
    try {
        $user->removeRole($role);
        return response()->json(['message' => 'Role revoked successfully']);
    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 500);
    }
}

/**
 * Revoke the specified permission from the user.
 *
 * @param Request $request
 * @param User $user
 * @param Permission $permission
 * @return \Illuminate\Http\Response
 */
public function revokePermission(Request $request, User $user, Permission $permission)
{
    try {
        $user->revokePermissionTo($permission);
        return response()->json(['message' => 'Permission revoked successfully']);
    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 500);
    }
}
/**
 * Assign a permission to a role.
 *
 * @param Request $request
 * @param Role $role
 * @param Permission $permission
 * @return \Illuminate\Http\Response
 */
public function assignPermissionToRole(Request $request, Role $role, Permission $permission)
{
    try {
        $role->givePermissionTo($permission);
        return response()->json(['message' => 'Permission assigned successfully']);
    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 500);
    }
}

/**
 * Revoke the specified permission from the role.
 *
 * @param  \App\Models\Role  $role
 * @param  \Spatie\Permission\Models\Permission  $permission
 * @return \Illuminate\Http\Response
 */
public function revokePermissionFromRole(Role $role, Permission $permission)
{
    try {
        $role->revokePermissionTo($permission);
        return response()->json(['message' => 'Permission revoked successfully']);
    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 500);
    }
}

    
    public function show(string $id)
    {
        //
    }

    
    public function update(Request $request, string $id)
    {
        //
    }

    
    public function destroy(string $id)
    {
        //
    }
}
