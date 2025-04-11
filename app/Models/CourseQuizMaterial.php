<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseQuizMaterial extends Model
{
    protected $table = 'course_quiz_materials';
    
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}


