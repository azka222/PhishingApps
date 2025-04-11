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
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
    public function materials()
    {
        return $this->hasMany(Material::class);
    }
}
