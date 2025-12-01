<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfSessionSalary extends Model
{
    use HasFactory;

    protected $table = 'prof_teachers_sessions_and_salaries';

    protected $fillable = [
        'teacher_id',
        'diploma_id',
        'session_type',
        'amount_per_session',
        'total_salary',
        'with_holding_tax',
        'amount_after_tax',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teaceher_id');
    }

    public function diploma()
    {
        return $this->belongsTo(Diploma::class, 'diploma_id');
    }
    
}
