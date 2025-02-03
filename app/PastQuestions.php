<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PastQuestions extends Model
{
    protected $table = 'past_questions';

    protected $fillable = [
        'year_of_exams',
        'course_name',
        'exams_paper'
    ];

    use HasFactory;
}
