<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Profession;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
       'first_name',
       'last_name',
       'middle_name',
       'email',
       'phone_number',
       'address',
       'role_id',
       'password',
    //    'remember_token',
    //    'email_verified_at',
    //    'confirm_password'

    ];

    protected $hidden = ['password','remember_token',];
    protected $casts = ['email_verified_at' => 'datetime',];

    

    public static function findByEmail(string $email){
       
        return User::get()->where('email',$email);
    }

    public static function getUsers(){   
            return User::all();
    }
    public static function deleteUser(string $id){
        User::find($id)->delete();
    }
    public static function deleteAll(){
        User::truncate();
        
    }
    public function professions()
    {
        return $this->belongsToMany(Profession::class);
    }
}
