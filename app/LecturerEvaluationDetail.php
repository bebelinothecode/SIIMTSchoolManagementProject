<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LecturerEvaluationDetail extends Model
{
    use HasFactory;

    protected $table = "lecturer_evaluation_details";

    protected $fillable = [
        'submission_id', 'subject_code', 'subject_name', 'lecturer_name',
        'clarity', 'knowledge', 'punctuality', 'comments'
    ];

    public function submission()
    {
        return $this->belongsTo(LecturerEvaluationSubmission::class, 'submission_id');
    }
}
