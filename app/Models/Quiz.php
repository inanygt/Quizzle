<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;


class Quiz extends Model
{
    use HasFactory;

// //     public function category() {
// //         return $this->hasMany(Category::class, 'id');
// //     }
// // }


// //jorian
// class Quiz extends Model
// {
//     protected $fillable = ['subject', 'num_questions', 'score'];

//     public function questions()
//     {
//         return $this->hasMany(Question::class);
//     }
// }


//jorian
// class Quiz extends Model
// {
//     use HasFactory;

//     protected $fillable = ['subject', 'num_questions', 'time_per_question', 'language'];

    protected $fillable = ['name', 'approved', 'category_id', 'subject', 'num_questions', 'time_per_question', 'language', 'count', 'rating'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    // Get most played quizles
    public function getMostPlayedQuizzes()
    {
    return $this->orderBy('count', 'desc')
                ->limit(4)
                ->get();
    }

    // Best raded quizles

    public function bestRadedQuizzes()
    {
        return $this->orderBy('rating', 'desc')
                ->limit(4)
                ->get();
    }
}

