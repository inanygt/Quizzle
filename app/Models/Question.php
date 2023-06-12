<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// class Question extends Model
// {
//     use HasFactory;
// }

//jorian
// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class Question extends Model
// {
//     protected $fillable = ['text', 'quiz_id'];

//     public function quiz()
//     {
//         return $this->belongsTo(Quiz::class);
//     }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

     public function answers()
    {
        return $this->hasMany(Answer::class) ;
    }
}
