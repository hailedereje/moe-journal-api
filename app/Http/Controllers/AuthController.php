<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
   
    public function login(Request $request){

        $user = User::get()->where('email',$request->email)->first();

    if ($user->password == $request->password) {
        $token = $this->generateToken($user);
        $roles = $user->roles;
        
        foreach($roles as $role){
            echo $role;
        }

        return response()->json(['token' => $role->permissions->pluck('name')]);
    } else {
        return response()->json(['error' => 'Invalid credentials'], 401);
    }
    }
    public function users(Request $request)
    {       
            $user = ['users'=>User::all()];
            // $user->roles
            return response()->json($user);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::create($request->all());
        $user->assignRole('MOE');
        return response()->json(['user'=>$user],201);
    }
    // $permissions = $roles->flatMap(function ($role) {
    //     return $role->permissions;
    // })->pluck('name')->unique();
    public function generateToken(User $user){
        // $user->assign
        return $user->createToken('accesstoken')->plainTextToken;
    }
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function deleteAllUser(Request $request){
        User::truncate();
        return response()->json([
            'status'=>200,
            'deleted'=>'deleted'
        ]);
    }
}
