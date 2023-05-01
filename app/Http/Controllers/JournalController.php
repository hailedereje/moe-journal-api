<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class JournalController extends Controller
{
   /**
     * Store a newly created journal in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function savePost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'institution' => 'required',
            'contributers' => 'required',
            'journal_file' => 'required',
            'status' => 'required',
            'department_id' => 'required'

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $journal = Journal::create($request->all());

        return response()->json(['data' => $journal], 201);
    }
    

   

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $journals = Journal::all();

        return response()->json(['data' => $journals], 200);
    }

    /**
     * Remove the specified journal from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $journal = Journal::find($id);

        if (!$journal) {
            return response()->json(['error' => 'Journal not found'], 404);
        }

        $journal->delete();

        return response()->json([], 204);
    }

    /**
     * Display the specified journal.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $journal = Journal::find($id);

        if (!$journal) {
            return response()->json(['error' => 'Journal not found'], 404);
        }

        return response()->json(['data' => $journal], 200);
    }

    
    
}
