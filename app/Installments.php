<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installments extends Model
{
    use HasFactory;

    protected $table = 'installments';

    protected $fillable = [
        'due_date',
        'amount',
        'currency',
        'payment_method',
        'notes',
        'payment_plan_id',
        'installments_num',
        'is_paid',
        'paid_on',
    ];

    public function paymentPlan()
    {
        return $this->belongsTo(PaymentPlan::class, 'plan_id');
    }
}
