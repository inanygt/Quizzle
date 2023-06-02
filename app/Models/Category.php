<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Quiz;

class Category extends Model
{
    use HasFactory;

    public function quiz(){
        return $this->belongsTo(Quiz::class);
    }
}
