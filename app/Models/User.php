<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        // 'first_name',
        // 'last_name',
        // 'Email',
        // 'password',
        // 'photo',
        // 'city',
        // 'street',
        // 'house_number',
        // 'phone_number',
        // 'address',
        // 'Departement',
        // 'Bank_account'

    ];

    protected $hidden = ['password','remember_token',];
    protected $casts = ['email_verified_at' => 'datetime',];

    

    public static function findByEmail(string $email){
       
        return User::get()->where('email',$email)->first();
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
}
