<?php

namespace App;
use App\Installments;
use App\Student;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentPlan extends Model
{
    use HasFactory;

    protected $table = 'payment_plan';

    protected $fillable = [
        'total_fees_due',
        'amount_already_paid',
        'outstanding_balance',
        'currency',
        'student_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function installments()
    {
        return $this->hasMany(Installments::class, 'payment_plan_id');
    }
}
