<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\QuizAttachment;
use App\Models\QuizEmailContent;


class Quiz extends Model
{
    protected $table = 'quizzes';

    public function attachment()
    {
        return $this->belongsTo(QuizAttachment::class, 'quiz_attachment_id', 'id'); 
    }

    public function emailContent(){
        return $this->belongsTo(QuizEmailContent::class, 'quiz_email_content_id', 'id');
    }

    public function option()
    {
        return $this->belongsTo(Option::class, 'option_id', 'id');
    }
}
