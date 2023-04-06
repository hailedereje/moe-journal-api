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
            'status'
    ];

    public function jhi(){
        $this->belongsTo(Jhi::class);
    }
}
