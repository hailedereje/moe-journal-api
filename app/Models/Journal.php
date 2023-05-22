<?php

namespace App\Models;

use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Journal extends Model
{
    use HasFactory;
    protected $fillable = [
        'application_letter',
        'journal_title',
        'journal_zip_file',
        'department_id',
        'journal_description',
        'contributors'
    ];

    public function department() {
        return $this->hasOne(Department::class);
    }
    public function journalAppeals(){
        return $this->hasMany(Appeal::class);
    }
}
