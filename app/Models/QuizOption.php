<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizOption extends Model
{
    protected $table = 'quiz_options';

    // protected $fillable = [
    //     'quiz_id',
    //     'option_id',
    //     'is_answer',
    // ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}
