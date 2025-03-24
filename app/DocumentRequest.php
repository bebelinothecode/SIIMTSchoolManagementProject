<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentRequest extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'student_id',
        'document_type',
        'reason',
        'status', 
    ];

    public function students()
    {
        return $this->belongsTo(Student::class,'student_id');
    }
}
