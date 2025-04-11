<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'materials';

    public function courseQuizMaterials()
    {
        return $this->hasMany(CourseQuizMaterial::class);
    }
}
