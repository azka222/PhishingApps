<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizEmailContent extends Model
{
    protected $table = 'quiz_email_contents';

    // protected $fillable = [
    //     'subject',
    //     'body',
    //     'footer',
    //     'created_at',
    //     'updated_at',
    // ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
