<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function correct_answer()
    {
        // Ensure that 'correct_answer' is a column in your 'questions' table that stores the ID of the correct answer
        return $this->belongsTo(Answer::class, 'correct_answer');
    }
}
