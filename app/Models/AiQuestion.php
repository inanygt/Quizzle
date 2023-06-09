<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiQuestion extends Model
{
    protected $fillable = ['text', 'quiz_id'];

    public function quiz()
    {
        return $this->belongsTo(AiQuiz::class);
    }

    public function answers()
    {
        return $this->hasMany(AiAnswer::class);
    }
}
