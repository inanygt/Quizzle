<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class AiQuiz extends Model
{
    protected $fillable = ['subject', 'num_questions'];

    public function questions()
    {
        return $this->hasMany(AiQuestion::class);
    }
}
