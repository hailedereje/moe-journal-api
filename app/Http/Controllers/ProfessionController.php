<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profession;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProfessionController extends Controller
{
    //
     // add new proffession
     public function newProfession(Request $request){
      
        try {
            $profData = $request->validate([
                'name' => 'required|unique:Professions,name'
            ]);
            
            $profession = Profession::create($profData);
        
            $response = [
                'status' => 1,
                'message' => 'Profession added successfully!',
                'profession' => $profession
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
                'message' => 'Failed to add Profession',
                'error' => $e->getMessage()
            ];
        
            return response()->json($response, 500);
        }

        
    }

    //get all profession
    public function getAllProfessions()
{
    try {
        $professions = Profession::all();
        $response = [
            'status' => 1,
            'message' => 'All Professions retrieved successfully!',
            'Professions' => $professions
        ];
        return response()->json($response, 200);
    } catch (\Exception $e) {
        $response = [
            'status' => 0,
            'message' => 'Failed to retrieve Professions',
            'error' => $e->getMessage()
        ];
        return response()->json($response, 500);
    }
}

   //edit Profession

public function editProfession(Request $request, $id)
{
    try {
        $prof = Profession::findOrFail($id);
        $prof->update($request->all());
        $response = [
            'status' => 1,
            'message' => 'Profession updated successfully!',
            'Profession' => $prof
        ];
        return response()->json($response, 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        $response = [
            'status' => 0,
            'message' => 'Profession not found!',
            'error' => $e->getMessage()
        ];
        return response()->json($response, 404);
    } catch (\Exception $e) {
        $response = [
            'status' => 0,
            'message' => 'Failed to update Profession',
            'error' => $e->getMessage()
        ];
        return response()->json($response, 500);
    }
}


public function deleteProfession(Request $request, string $id) {
        try {
            
            Profession::findOrFail($id)->delete();
            return response()->json([
                'status' => 1,
                'message' => 'Profession Deleted',
                'code' => 200
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Profession not found',
                'code' => 404
            ]);
        }


}

// attaching user to the profession
public function attachProfessionToUser(Request $request, $userId, $professionId)
{
    try {
        $user = User::findOrFail($userId);
        // $user->professions()->attach($professionId);
        $user->professions()->sync($professionId);

        return response()->json([
            'status' => 1,
            'message' => 'Profession attached to user',
            'code' => 200
        ]);
    } catch (ModelNotFoundException $e) {
        return response()->json([
            'status' => 0,
            'message' => 'User or Profession not found',
            'code' => 404
        ]);
    }
}

public function detachProfessionFromUser(Request $request, $userId, $professionId)
{
    try {
        $user = User::findOrFail($userId);
        $user->professions()->detach($professionId);

        return response()->json([
            'status' => 1,
            'message' => 'Profession detached from user',
            'code' => 200
        ]);
    } catch (ModelNotFoundException $e) {
        return response()->json([
            'status' => 0,
            'message' => 'User or Profession not found',
            'code' => 404
        ]);
    }
}

}
