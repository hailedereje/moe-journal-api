<?php

namespace App\Models;

use App\Models\User;
use Laravel\Sanctum\HasApiTokens;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jhi extends Model
{
    use HasFactory,HasApiTokens,HasRoles,HasPermissions;

    protected $fillable = [
            'name' ,
            'code',
            'issues_per_year',
            'publications_per_year',
            'location' ,
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

    public function users()
    {
        return $this->hasMany(User::class);
    }

   
}
