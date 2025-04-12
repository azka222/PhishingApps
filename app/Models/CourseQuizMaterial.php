<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\Material;

class CourseQuizMaterial extends Model
{
    protected $table = 'course_quiz_materials';
    


    public function model()
    {
        return $this->morphTo();
    }
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}


