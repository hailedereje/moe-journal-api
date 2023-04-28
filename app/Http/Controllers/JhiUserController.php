<?php

namespace App\Http\Controllers;

use App\Models\Jhi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class JhiUserController extends Controller
{
    // registering JHI
    public function registerJhi(Request $request)
    {
     
        
            try{
                $request->validate([
                'name' => 'required',
                'code' => 'required|unique:jhis,code',
                'issues_per_year' => 'required',
                'publications_per_year' => 'required',
                'location' => 'required',

                ]);

                $newJhi = Jhi::create($request->all());
                return response()->json([
                'jhi' => $newJhi]);

                }catch(\Exception $e){
                    return response()->json([
                        'message'=>$e->getMessage()
                    ],400);
            }
    }
// search JHI
    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $users = Jhi::query()
                            ->where('name','like','%'.$keyword.'%')
                            ->orWhere('name','<','%'.$keyword.'%')
                            ->get();
        return response()->json([
            'users'=>$users
        ]);
    }
// list of JHI
    public function jhis(){
        return response()->json(Jhi::all());
    }
// edit the JHI
    public function editJhi(Request $request ,string $id){
       
        try{

            $jhi  = Jhi::findOrFail($id);
            $jhi->update($request->all());

            return response()->json(['jhi'=>$jhi]);

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



    // attaching user to the profession
public function attachJhiToUser(Request $request, $userId, $jhiId)
{
    try {
        $user = User::findOrFail($userId);
        $jhi = Jhi::findOrFail($jhiId);

        $user->jhi()->associate($jhi);
        $user->save();

        return response()->json([
            'status' => 1,
            'message' => 'JHI attached to user',
            'code' => 200
        ]);
    } catch (ModelNotFoundException $e) {
        return response()->json([
            'status' => 0,
            'message' => 'User or JHI not found',
            'code' => 404
        ]);
    }
}

public function detachJhiFromUser(Request $request, $userId, $jhiId)
{
    try {
        $user = User::findOrFail($userId);
        $user->jhis()->detach($jhiId);

        return response()->json([
            'status' => 1,
            'message' => 'JHI detached from user',
            'code' => 200
        ]);
    } catch (ModelNotFoundException $e) {
        return response()->json([
            'status' => 0,
            'message' => 'User or JHI not found',
            'code' => 404
        ]);
    }
}
}
