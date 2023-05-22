<?php

namespace App\Http\Controllers;

use App\Models\Appeal;
use Exception;
use Illuminate\Http\Request;

class AppealController extends Controller
{
    public function getAppeals(Request $request){
        try {
            $appeals = Appeal::all();
            $response = [
                'status' => 1,
                'message' => 'All Appeals retrieved successfully!',
                'departments' => $appeals
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = [
                'status' => 0,
                'message' => 'Failed to retrieve appeals',
                'error' => $e->getMessage()
            ];
            return response()->json($response, 500);
        }
        
    }
    public function getAppealById(string $id){
        $appeal = Appeal::findOrFail($id);
        return $appeal;
    }

    public function AddAppeal(Request $request){
        try {
            $appealData = $request->validate([
                'introduction' => 'required|unique:appeals,introduction',
                'body'=>'required'
            ]);
            
            $appeal = Appeal::create($appealData);
        
            $response = [
                'status' => 1,
                'message' => 'Appeal added successfully!',
                'department' => $appeal
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
                'message' => 'Failed to add appeal',
                'error' => $e->getMessage()
            ];
        
            return response()->json($response, 500);
        }
    }

    public function editeAppeal(Request $request, $id)
{
    try {
        $appeal = Appeal::findOrFail($id);
        $appeal->update($request->all());
        $response = [
            'status' => 1,
            'message' => 'appeal updated successfully!',
            'department' => $appeal
        ];
        return response()->json($response, 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        $response = [
            'status' => 0,
            'message' => 'appeal not found!',
            'error' => $e->getMessage()
        ];
        return response()->json($response, 404);
    } catch (\Exception $e) {
        $response = [
            'status' => 0,
            'message' => 'Failed to update appeal',
            'error' => $e->getMessage()
        ];
        return response()->json($response, 500);
    }
}

public function deleteAppeal(Request $request, string $id) {
    try {
        
        Appeal::findOrFail($id)->delete();
        return response()->json([
            'status' => 1,
            'message' => 'Department Deleted',
            'code' => 200
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status' => 0,
            'message' => 'Appeal not found',
            'code' => 404
        ]);
    }


}
}
