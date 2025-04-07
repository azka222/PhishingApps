<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function questions()
    {
        return $this->belongsToMany(Question::class, 'courses_questions', 'course_id', 'question_id');
    }
}
