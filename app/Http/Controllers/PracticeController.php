<?php


// this files is practice file where I test out my codes.

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;
use App\Models\Journal;

use Spatie\Permission\Models\Permission;


class PracticeController extends Controller
{
    
    public function practice(Request $request)
    {
       
        $path = FileController::addFile($request->journal_file);
        $product = Journal::create(array_merge($request->all(),['journal_file'=>$path]));
        return $product;
        
    }
}
