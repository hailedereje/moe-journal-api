<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Js;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class Jhi extends Model
{
    use HasFactory,HasApiTokens,HasRoles,HasPermissions;

    protected $fillable = [
        'institution_name',
        'institution_email',
        
        // 'institution_phoneNumber',
        // 'application_letter',
        // 'valid_credential',
    
        'password'
    ];

    protected $hidden = [
        'password'
    ];

    
    // public function departments(){
    //     return $this->belongsToMany(Department::class);
    // }

    public static function findByEmail(string $email){
       
        return Jhi::where('institution_email',$email)->first();
    }

    public static function getUsers(){   
            return Jhi::all();
    }
    public static function deleteUser(string $id){
        Jhi::find($id)->delete();
    }
    public static function deleteAll(){
        Jhi::truncate();
        
    }

   
}
