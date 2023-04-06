<?php


// this files is practice file where I test out my codes.

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jhi;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;
use App\Models\Journal;

use Spatie\Permission\Models\Permission;


class PracticeController extends Controller
{
    
    public function practice(Request $request)
    {
        try{

            // $jhi = Jhi::find("1");
            // return $jhi->journals;
            $request->validate([
                'title'=>'required',
                'jhi_id'=>'required',
                'contributers'=>'required',
                // 'journal_file'=>'required',
                'status'=>'required|in:passed,failed,pending'
                ]);
            
            // $journal = Journal::create($request->except('journal_file'));
            
            // $path = FileController::addFile($request->journal_file);
            // $path = $request->file('journal_file')->store('myfolder');
            // $journal->update(['journal_file'=>$path]);


            // return response()->json(['prod'=>$path]);
            // $journal = Journal::find("1");

            $files = $request->file();
                foreach($files as $file){
                    $file->store('myfolder');
                }
                // $file = $request->file('journal_file')->all();
                // $path = $file->store('myfolder');
            // 
            return response()->json(['journals'=>'']);
            // is_file($request->file('journal_file'))

        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
        
    }
}
