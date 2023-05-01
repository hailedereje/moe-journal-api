<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $fillable = ["name"];

    public static function getStatus(string $id){

        $res = Status::findOrFail($id);
        return response()->json(["status"=>$res],200);
    }

    public static function setStatus(Status $status){
        Status::create($status);
    }
}
