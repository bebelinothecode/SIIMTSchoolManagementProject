<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;

    protected $table = 'expenses';

    protected $fillable = [
        'source_of_expense',
        'description_of_expense',
        'category',
        'currency',
        'amount',
        'mode_of_payment',
        'mobile_money_details',
        'cash_details',
        'bank_details',
        'cash_details',
        'BackDate',
        'branch',
        'expensecategory_id'
    ];

    // public function setNameAttribute($value)
    // {
    //     $this->attributes['category'] = strtoupper($value);
    // }

    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expensecategory_id');
    }

}
