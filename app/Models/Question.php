<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'courses_questions', 'question_id', 'course_id');
    }

}
