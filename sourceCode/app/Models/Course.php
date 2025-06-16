<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = [
        'name',
        'description',
        'created_at',
        'updated_at',
    ];
 

    public function courseQuizMaterial()
    {
        return $this->hasMany(CourseQuizMaterial::class);
    }

    public function quiz()
    {
        return $this->hasMany(Quiz::class);
    }
    public function material()
    {
        return $this->hasMany(Material::class);
    }

    public function thumbnail(){
        return $this->belongsTo(CourseThumbnail::class, 'course_thumbnail_id', 'id');   
    }
}
