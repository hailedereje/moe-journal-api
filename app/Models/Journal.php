<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;
    protected $fillable = [
            'title',
            'department_id',
            'institution',
            'contributers',
            'journal_file',
            'status'
    ];
}
