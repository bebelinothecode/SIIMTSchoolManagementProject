<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'user_id',
        'position',
        'phone_number',
        'employment_type',
        'email',
        'address',
        'gender',
        'date_of_birth',
        'start_employment_date',
        'end_employment_date',
        'status',
    ];

    protected $casts = [
    'date_of_birth' => 'date',
    'start_employment_date' => 'date',
    'end_employment_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function salaries()
    {
        return $this->hasMany(StaffSalary::class);
    }
}