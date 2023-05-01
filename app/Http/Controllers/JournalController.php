<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class JournalController extends Controller
{
   /**
     * Store a newly created journal in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    
    
    public function saveJournal(Request $request)
    {
        $validatedData = $request->validate([
            'application_letter' => 'required',
            'journal_title' => 'required',
            'journal_zip_file' => 'required',
            'department_id' => 'required|exists:departments,id',
            'journal_description' => 'required',
            'contributors' => 'nullable'
        ]);
    
        // Upload and store the zip file
        $file = $request->file('journal_zip_file');
        $fileName = time().'_'.$file->getClientOriginalName();
        $filePath = $file->storeAs('uploads', $fileName, 'public');
    
        $journal = Journal::create([
            'application_letter' => $validatedData['application_letter'],
            'journal_title' => $validatedData['journal_title'],
            'department_id' => $validatedData['department_id'],
            'journal_description' => $validatedData['journal_description'],
            'contributors' => $validatedData['contributors'],
            'journal_zip_file' => $filePath
        ]);
    
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
