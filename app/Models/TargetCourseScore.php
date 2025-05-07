<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetCourseScore extends Model
{
    protected $table = 'target_course_scores';

    public function target()
    {
        return $this->belongsTo(Target::class, 'target_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
