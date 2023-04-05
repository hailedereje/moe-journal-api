<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Redis;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rull;
use Spatie\Permission\Models\Permission;

class PracticeController extends Controller
{
    public function __construct(){
        // try{
        //     $this->middleware(['auth:api']);

        // }catch(\Exception $e){
        //     return response()->json(['error'=>$e->getMessage()]);
        // }
    }
    
    public function practice_1(Request $request){

        // $user = User::findByEmail('haile@gmail.com');
        // $r = Role::findById("1");
        // $per = $r->permissions()->pluck('name');
        // $user = User::findByEmail('MOE')->get();
        // $r = Role::find("1");
        // $r->permissions()->pluck('name');
        // Permission::findByName("Register_users");
        // $roles = $request->roles;
        $Role = Role::all()->pluck('name');
        // foreach($roles as $role){
        //     Rull::in($Role);
        // }
        
        return $request;
    }

    public function practice(Request $request){

        
            $request->validate(['name'=>'required','permission'=>'required|array']);
            $permissions = $request->permission;

            foreach($permissions as $per){
                try{

                    Permission::findByName($per);
                }
                catch(\Exception $e){

                    return response()->json(['message'=>$e->getMessage()]);
                }
            }
            $role = Role::create(['name'=>$request->name]);
            $role->givePermissionTo($permissions);


            
            // 

        //     return response()->json(['message'=>$role]);
        // }catch(\Exception $e){
            // return response()->json(['message'=>$e->getMessage()]);
        // }
    }
    
}
