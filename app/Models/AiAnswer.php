<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiAnswer extends Model
{
    use HasFactory;

    protected $table = 'aianswers'; // Add this line

    protected $fillable = ['aiquestion_id', 'text', 'is_correct'];

    public function question()
    {
        return $this->belongsTo(AiQuestion::class, 'aiquestion_id');
    }
}
