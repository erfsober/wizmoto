<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'question', 'question_it',
        'answer', 'answer_it',
        'category', 'sort', 'is_active',
    ];

    public function getLocalizedQuestionAttribute()
    {
        return app()->getLocale() === 'it' && $this->question_it
            ? $this->question_it
            : $this->question;
    }

    public function getLocalizedAnswerAttribute()
    {
        return app()->getLocale() === 'it' && $this->answer_it
            ? $this->answer_it
            : $this->answer;
    }
}
