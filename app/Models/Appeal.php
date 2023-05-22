<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appeal extends Model
{
    use HasFactory;
    protected $fillable = [
        "Introduction",
        "body"
    ];

    public function journal(){
        return $this->belongsTo(Journal::class);
    }
}
