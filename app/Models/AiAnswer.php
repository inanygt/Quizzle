<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['question_id', 'text', 'is_correct'];

    public function question()
    {
        return $this->belongsTo(AiQuestion::class);
    }
}

