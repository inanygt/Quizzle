<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiQuestion extends Model
{
    use HasFactory;

    protected $table = 'aiquestions'; // Add this line

    protected $fillable = ['text', 'aiquiz_id'];

    public function quiz()
    {
        return $this->belongsTo(AiQuiz::class, 'aiquiz_id');
    }

    public function answers()
    {
        return $this->hasMany(AiAnswer::class, 'aiquestion_id');
    }
}
