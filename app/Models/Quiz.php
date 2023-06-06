<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;


// class Quiz extends Model
// {
//     use HasFactory;

//     public function category() {
//         return $this->hasMany(Category::class, 'id');
//     }
// }


//jorian
class Quiz extends Model
{
    protected $fillable = ['subject', 'num_questions'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
