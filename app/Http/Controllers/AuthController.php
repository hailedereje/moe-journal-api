<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
   
    public function login(Request $request){

        try{

                $request->validate(['email'=>'email|required','password'=>'required',]);
                
                $date = Carbon::now()->addDays(7);
                $user = User::get()->where('email',$request->email)->first();
                if ($user && Hash::check($request->password, $user->password))  {
                
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
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'middle_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone_number' => 'required|string|max:20',
                'address' => 'required|json',
                'role_id' => 'required|exists:roles,id',
                'password' => 'required|string|min:8',
            ]);
            
                // $userData = $request->all();
                // $userData['address'] = json_decode($userData['address'], true);
                // $userData['address'] = json_decode($request->input('address'), true);
                $userData['address'] = $request->input('address');
                $userData['password'] = bcrypt($userData['password']);


                // // $role = Role::findByName($request->role);
                // $role = Role::findByName('MOE','api');
                $user = User::create($userData);
                $user->assignRole($request->role_id);
              
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
