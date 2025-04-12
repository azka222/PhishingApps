<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAttachment extends Model
{
    protected $table = 'quiz_attachments';

    protected $fillable = [
        'name',
        'path',
    ];

}
