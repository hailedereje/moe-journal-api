<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Journal;

class JournalController extends Controller
{
    public function sendjournal(Request $request)
    {
        
        try{

            // $jhi = Jhi::find("1");
            // return $jhi->journals;
            $request->validate([
                                'title'=>'required',
                                'jhi_id'=>'required',
                                'contributers'=>'required',
                                'journal_file'=>'required',
                                'status'=>'required|in:passed,failed,pending'
                                ]);
            
            $journal = Journal::create($request->except('journal_file'));
            
            $path = FileController::addFile($request->journal_file);
            $journal->update(['journal_file'=>$path]);

            return response()->json(['prod'=>$journal]);

        }
            catch(\Exception $e){
                return response()->json(['error'=>$e->getMessage()]);
        }
    }
}
