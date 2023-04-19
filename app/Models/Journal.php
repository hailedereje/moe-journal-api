<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Journal extends Model
{
    use HasFactory;
    protected $fillable = [
            'title',
            'department_id',
            'institution',
            'contributors',
            'journal_file',
            'status'
    ];

    public function getJournals(){
        return response()->json(["journals"=>Journal::all()],200);
    }

    public function getJournalById(string $id){
        try
        {
            $journal = Journal::findOrFail($id);
            return response()->json(["journal"=>$journal],200);
        }
        catch(\Exception $e){
            return response()->json(["error"=>$e->getMessage()]);
        }
        
    }

    public function createJournal(Request $request){
        try
        {
            $request->validate([
                'title'=>'required',
                'department_id'=>'required',
                'institution'=>'required',
                'contributors'=>'required',
                'journal_file'=>'required',
                'status'=>'required'
            ]);

            Journal::create($request->all());
            return response()->json(["status"=>"successfully created"],201);
        }
        catch(\Exception $e){
            return response()->json(["error"=>$e->getMessage()]);
        }
    }

    public function updateJournal(Request $request){
        try
        {
            $request->validate([
                'title'=>'required',
                'department_id'=>'required',
                'institution'=>'required',
                'contributors'=>'required',
                'journal_file'=>'required',
                'status'=>'required'
            ]);
            Journal::update($request->all());
            return response()->json(["status"=>"successfully updated"],201);
        }
        catch(\Exception $e){
            return response()->json(["error"=>$e->getMessage()]);
        }
    }

    public function deleteJournal(string $id){
        try{
            Journal::find($id)->delete();
            return response()->json(["status"=>"successfully deleted"],200);
        }
        catch(\Exception $e){
            return response()->json(["error"=>$e->getMessage()]);
        }
    }
}
