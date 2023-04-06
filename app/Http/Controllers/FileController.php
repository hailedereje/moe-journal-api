<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public static function addFile($file){

        // $filename =$file->getClientOriginalName();
        $path = Storage::putFile('myfolder', $file);
        return $path;
        
    }
}
