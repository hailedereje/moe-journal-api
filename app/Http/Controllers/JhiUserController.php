<?php

namespace App\Http\Controllers;

use App\Models\Jhi;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;

class JhiUserController extends Controller
{
    public function registerJhiUser(Request $request)
    {
        
            try{
                
                $request->validate([
                    'institution_name'=>'required',
                    'institution_email'=>'required|unique:Jhis,institution_email',
                    'password'=>'required'
                ]);

                $user = Jhi::create($request->all());
                return response()->json(['user'=>$user]);

                }catch(\Exception $e){
                    return response()->json([
                        'message'=>$e->getMessage()
                    ],400);
            }
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $email = $request->email;
        $users = Jhi::query()
                            ->where('institution_name','like','%'.$keyword.'%')
                            ->orWhere('institution_name','<','%'.$keyword.'%')
                            ->orWhere('institution_email','like','%'.$email.'%')
                            ->orWhere('institution_email','<','%'.$email.'%')
                            ->get();
                            // ->pluck('name','email');
        return response()->json([
            'users'=>$users
        ]);
    }

    public function users(){
        return response()->json(Jhi::getUsers());
    }

    public function edite(Request $request ,string $id){
       
        try{
            $request->validate([
                'institution_name'=>'required',
                'institution_email'=>'required',
                'password'=>'required',  
            ]);

            $user  = Jhi::findOrFail($id);
            $user->update($request->all());

            return response()->json(['user'=>$user]);

        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
       
    }

    public function deleteJhi(string $id){
        try{
            Jhi::findOrFail($id)->delete();
            return response()->json(['message'=>'SUCCESSFULLY DELETED'],200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }

    }
}
