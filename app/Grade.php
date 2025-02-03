<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{   
    //This model is for the courses 
    protected $table = "grades";


    protected $fillable = [
        'course_code',          
        'course_name' ,        
        'course_description',          
        'currency',           
        'fees'
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function teacher() 
    {
        return $this->belongsTo(Teacher::class);
    }
}
