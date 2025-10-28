<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'question', 'question_en', 'question_it',
        'answer', 'answer_en', 'answer_it',
        'category', 'sort', 'is_active'
    ];

    public function getLocalizedQuestionAttribute()
    {
        $locale = app()->getLocale();
        $column = "question_{$locale}";
        return $this->$column ?? $this->question_en ?? $this->question;
    }

    public function getLocalizedAnswerAttribute()
    {
        $locale = app()->getLocale();
        $column = "answer_{$locale}";
        return $this->$column ?? $this->answer_en ?? $this->answer;
    }
}
