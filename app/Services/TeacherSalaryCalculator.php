<?php

namespace App\Services;

use App\TeachingSession;
use App\Teacher;
use App\Attendance;
use App\TeacherPayment;
use Carbon\Carbon;


class TeacherSalaryCalculator
{
    private $rateWeekday = 120;
    private $rateWeekend = 250;
    private $rateOnline = 100;
    private $withholdingTaxRate = 0.03;

    public function generateSalaryReport($month, $year)
    {
        $teachers = Teacher::with(['attendances' => function($query) use ($month, $year) {
            $query->whereYear('attendence_date', $year)
                  ->whereMonth('attendence_date', $month)
                  ->where('attendence_status', 'present');
        }])->get();

        $report = [];
        $totals = [
            'weekday_sessions' => 0,
            'weekend_sessions' => 0,
            'online_sessions' => 0,
            'total_amount' => 0,
            'withholding_tax' => 0,
            'amount_after_tax' => 0
        ];

        foreach ($teachers as $teacher) {
            $teacherData = $this->calculateTeacherSalary($teacher, $month, $year);
            // $report[] = $teacherData;

            $alreadyPaid = TeacherPayment::where('teacher_id', $teacher->id)
                ->whereYear('paid_at', $year)
                ->whereMonth('paid_at', $month)
                ->where('already_paid',true)
                ->exists();

            $teacherData['already_paid'] = (bool) $alreadyPaid;
            $attendanceCount = $teacher->attendances->count();
            $teacherData['attendance_count'] = $attendanceCount;

            $report[] = $teacherData;
            // Update totals
            $totals['weekday_sessions'] += $teacherData['weekday_sessions'];
            $totals['weekend_sessions'] += $teacherData['weekend_sessions'];
            $totals['online_sessions'] += $teacherData['online_sessions'];
            $totals['total_amount'] += $teacherData['total_amount'];
            $totals['withholding_tax'] += $teacherData['withholding_tax'];
            $totals['amount_after_tax'] += $teacherData['amount_after_tax'];
        }

        return [
            'report' => $report,
            'totals' => $totals,
            'month_year' => Carbon::create($year, $month, 1)->format('F Y')
        ];
    }

    public function calculateTeacherSalary($teacher, $month, $year)
    {
        $attendances = $teacher->attendances->groupBy('type');

        $weekdaySessions = $attendances->get('Weekday', collect())->count();
        $weekendSessions = $attendances->get('Weekend', collect())->count();
        $onlineSessions = $attendances->get('Online', collect())->count();

        $weekdayAmount = $weekdaySessions * $this->rateWeekday;
        $weekendAmount = $weekendSessions * $this->rateWeekend;
        $onlineAmount = $onlineSessions * $this->rateOnline;

        $totalAmount = $weekdayAmount + $weekendAmount + $onlineAmount;
        $withholdingTax = $totalAmount * $this->withholdingTaxRate;
        $amountAfterTax = $totalAmount - $withholdingTax;

        $teacher->load('subjectAssignments.subject');
        $assignedSubjects = $teacher->subjectAssignments;
        $attendancesData = $teacher->attendances->toArray();

        return [
            'teacher_id' => $teacher->id,
            'employee_name' => $teacher->user->name ?? 'N/A',
            'course_assignments' => $assignedSubjects ?: 'No Assignment',
            'attendances' => $attendancesData,
            'weekday_sessions' => $weekdaySessions,
            'weekend_sessions' => $weekendSessions,
            'online_sessions' => $onlineSessions,
            'total_amount' => $totalAmount,
            'withholding_tax' => $withholdingTax,
            'amount_after_tax' => $amountAfterTax,
        ];
    }

    public function processPayment($teacherId, $month, $year, $method = null)
    {
        $teacher = Teacher::with(['attendances' => function($query) use ($month, $year) {
            $query->whereYear('attendence_date', $year)
                ->whereMonth('attendence_date', $month)
                ->where('attendence_status', 'present');
        }])->findOrFail($teacherId);

        $existingPayment = TeacherPayment::where('teacher_id', $teacherId)
            ->whereYear('paid_at', $year)
            ->whereMonth('paid_at', $month)
            ->where('already_paid',true)
            ->first();

        if ($existingPayment) {
            throw new \Exception('Payment has already been processed for this teacher for the selected month.');
        }

        $salaryData = $this->calculateTeacherSalary($teacher, $month, $year);
        
        $attendanceIds = $teacher->attendances->pluck('id');

        $payment = TeacherPayment::create([
            'teacher_id' => $teacherId,
            'receipt_number' => $this->generateReceiptNumber(),
            'gross_amount' => $salaryData['total_amount'],
            'withholding_tax' => $salaryData['withholding_tax'],
            'net_amount' => $salaryData['amount_after_tax'],
            'method' => $method,
            'session_ids' => $attendanceIds,
            'paid_at' => now(),
            'already_paid' => true
        ]);

        return $payment;
    }


    private function generateReceiptNumber()
    {
        return 'REC-' . date('Ymd') . '-' . str_pad(TeacherPayment::count() + 1, 4, '0', STR_PAD_LEFT);
    }
}