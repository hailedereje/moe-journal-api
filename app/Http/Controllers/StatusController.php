<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    private $fillable = ["name"];

    static function getStatus(string $id){

        $res = Status::findOrFail($id);
        return response()->json(["status"=>$res],200);
    }

    static function setStatus(Status $status){
        Status::create($status);
    }

}
