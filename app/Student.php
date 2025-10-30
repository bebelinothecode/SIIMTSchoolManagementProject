<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    // use SoftDeletes;
    protected $fillable = [
        // 'user_id',
        // 'parent_id',
        // 'class_id',
        'level',
        'gender',
        'phone',
        'dateofbirth',
        'current_address',
        'attendance_time',
        'dateofbirth',
        'student_parent',
        'parent_phonenumber',
        'student_category',
        'course_id_prof',
        'currency_prof',
        'fees_prof',
        'duration_prof',
        'course_id',
        'currency',
        'fees',
        'level',
        'session',
        'academicyear',
        'Scholarship',
        'Scholarship_amount',
        'index_number',
        'balance',
        'last_level',
        'last_session',
        'branch',
        'status',
        'student_type',
        'admission_cycle'
    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function deletedUsers() 
    {
        return $this->belongsTo(User::class)->withTrashed();
    }


    public function parent() 
    {
        return $this->belongsTo(Parents::class, 'parent_id');
    }

    public function course() 
    {
        return $this->belongsTo(Grade::class, 'course_id');
    }

    public function diploma()
    {
        return $this->belongsTo(Diploma::class,'course_id_prof');
    }

    public function attendances() 
    {
        return $this->hasMany(Attendance::class);
    }

    public function borrow() 
    {
        return $this->hasMany(Book::class);
    }

    public function submissions()
    {
        return $this->hasMany(LecturerEvaluationSubmission::class);
    }

    public function transactions()
    {
        return $this->hasMany(FeesPaid::class);
    }

    public function paymentPlans()
    {
        return $this->hasMany(PaymentPlan::class, 'student_id');
    }

    public function getDueInstallments()
    {
        $today = now()->format('Y-m-d');
        $dueInstallments = [];
        
        foreach ($this->paymentPlans as $paymentPlan) {
            foreach ($paymentPlan->installments as $installment) {
                // Check if installment is not paid and due date is today or past
                if ($installment->is_paid !== 'Yes' && $installment->due_date <= $today) {
                    $dueInstallments[] = $installment;
                }
            }
        }
        
        return $dueInstallments;
    }

    public function hasDueInstallments()
    {
        return count($this->getDueInstallments()) > 0;
    }

    public function getOverdueInstallments()
    {
        $today = now()->format('Y-m-d');
        $overdueInstallments = [];
        
        foreach ($this->paymentPlans as $paymentPlan) {
            foreach ($paymentPlan->installments as $installment) {
                // Check if installment is not paid and due date is in the past
                if ($installment->is_paid !== 'Yes' && $installment->due_date < $today) {
                    $overdueInstallments[] = $installment;
                }
            }
        }
        
        return $overdueInstallments;
    }

    public function hasOverdueInstallments()
    {
        return count($this->getOverdueInstallments()) > 0;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($student) {
            // Get current year
            $year = now()->year;

            // Determine registration period (2 for Jan–Feb, 8 for Aug–Sep)
            $month = now()->month;
            $period = ($month >= 1 && $month <= 2) ? 2 : (($month >= 8 && $month <= 9) ? 8 : null);

            // if (!$period) {
            //     throw new \Exception("Registration period is closed. Only Jan–Feb or Aug–Sep allowed.");
            // }

            // Define the course prefix — could also come from $student->course->code
            $prefix = $student->course->course_code;

            // Build the prefix pattern (e.g., "BSCIT/2025/8/")
            $basePrefix = "{$prefix}/{$year}/{$period}/";

            // Find the last student within same prefix (same course, year, and period)
            $lastStudent = self::where('index_number', 'LIKE', "{$basePrefix}%")
                                ->orderByDesc('id')
                                ->first();

            if ($lastStudent && preg_match('/\/(\d+)$/', $lastStudent->index_number, $matches)) {
                $number = intval($matches[1]) + 1;
            } else {
                $number = 141; // start fresh if none found
            }

            // Final index number
            $student->index_number = $basePrefix . $number;
        });
    }
}
