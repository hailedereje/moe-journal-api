<?php

namespace App\Models;

use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Journal extends Model
{
    use HasFactory;
    protected $fillable = [
            'title',
            'department_id',
            'institution',
            'contributors',
            'journal_file',
            'status'
    ];

    public function department() {
        return $this->hasOne(Department::class);
    }
}
