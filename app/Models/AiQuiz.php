<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiQuiz extends Model
{
    use HasFactory;

    protected $table = 'aiquizzes'; // Add this line

    protected $fillable = ['subject', 'num_questions'];

    public function questions()
    {
        return $this->hasMany(AiQuestion::class, 'aiquiz_id');
    }
}
