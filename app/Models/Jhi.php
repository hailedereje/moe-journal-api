<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Jhi extends Model
{
    use HasFactory,HasApiTokens;

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

    public function departments(){
        return $this->belongsToMany(Department::class);
    }
}
