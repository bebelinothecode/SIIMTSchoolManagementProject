<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    use HasFactory;

    protected $table = 'expense_category';

    protected $fillable = [
        'expense_category',
    ];

     public function setNameAttribute($value)
    {
        $this->attributes['expense_category'] = strtoupper($value);
    }
}
