<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Spatie\
class Journal extends Model 
{
    use HasFactory;
    protected $fillable = [
            'title',
            'jhi_id',
            'institution',
            'contributers',
            'journal_file',
            'status',
            'department'
    ];

    public function jhi(){
        $this->belongsTo(Jhi::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }
}
