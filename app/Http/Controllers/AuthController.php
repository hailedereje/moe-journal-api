<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
   
    public function login(Request $request){

        try{

                $request->validate(['email'=>'email|required','password'=>'required',]);
                
                $date = Carbon::now()->addDays(7);
                $user = User::get()->where('email',$request->email)->first();
                if ($user->password == $request->password) {
                
                    // getting user permissions as array
                    // $role = User::findByEmail($request->email)->roles()->first();
                    // $rolePermissions = $role->permissions()->pluck('name');
                    // $permissions = [];

                    // foreach($rolePermissions as $per){
                    //     array_push($permissions,$per);
                    // }
                    
                    // $token = $user->createToken('token',$permissions,$date)->plainTextToken;
                    $token = $user->createToken('token',['app-scope'],$date)->plainTextToken;
                    
                    return response()->json(['token' => $token,'user'=>$user]);
                }     
                return response()->json(['error' => 'Invalid credentials'], 401);

            }
            catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],400);
        }
        
}
    public function logout(Request $request){

        $user = $request->user();
        $user->tokens()->delete();
        return response()->json(['message'=>'SUCCESSFULLY LOGGED OUT'],200);
    }
        
    public function registerUser(Request $request)
    {
        try{
                $userData = $request->validate([
                    'name'=>'required',
                    'email'=>'required|unique:users,email',
                    'password'=>'required',
                    'role'=>'required'
                ]) ;

                // $role = Role::findByName($request->role);
                $role = Role::findByName('MOE','api');
                $user = User::create($userData);
                $user->assignRole($role);
                // $user->assignRole($role);
                return response()->json(['message'=>'user '.$user->name.' created','user'=>$user],201);
            }
                catch(\Exception $e){
                    return response()->json(['error'=>$e->getMessage()],400);
            }
        
       
    }
   
    
    
    public function deleteUser(Request $request,string $id){
    
        if($request->user()->hasRole("MOE")){
            
            User::deleteAll();
            PersonalAccessToken::truncate();
            return response()->json([
                'status'=>200,
                'role'=>$request->user()->getRoleNames(),
                'deleted'=>'deleted'
            ]);
        }
        return response()->json(['message'=>'NOT ALLOWED'],401);
    }

    public function users(){
        $user = User::getUsers();
        return response()->json(['users'=>$user],200);
    }

    public function search(Request $request)
    {
        
        $keyword = $request->keyword;
        $email = $request->email;
        $users = User::query()
                            ->where('name','like','%'.$keyword.'%')
                            ->orWhere('name','<','%'.$keyword.'%')
                            ->orWhere('email','like','%'.$email.'%')
                            ->orWhere('email','<','%'.$email.'%')
                            ->get()->pluck('name','email');
        
        return response()->json([
            'jhi\'s '=>$users
        ]);

    }
}
