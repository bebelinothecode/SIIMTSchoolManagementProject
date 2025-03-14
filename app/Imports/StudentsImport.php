<?php

namespace App\Imports;

use App\User;
use App\Grade;
use App\Diploma;
use App\Student;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements WithHeadingRow, ToCollection
{
    public function collection(Collection $rows)
    {
        foreach($rows as $row) {
            $user = User::create([
                'name' => $row['name'] ?? "name",
                'email' => $row['email'] ?? "email",
                'password' => Hash::make('defaultpassword'),
                'profile_picture' => 'avatar.png', // Default avatar
            ]);

            $studentData = [
                'phone' => $row['phone'],
                'gender' => $row['gender'],
                'attendance_time' => $row['attendance_time'],
                'dateofbirth' => $this->formatDate($row['dateofbirth']),
                'current_address' => $row['current_address'],
                'index_number' => $row['index_number'],
                'student_parent' => $row['student_parent'],
                'parent_phonenumber' => $row['parent_phonenumber'],
                'student_category' => $row['student_category'],
                'scholarship' => $row['scholarship'],
                'scholarship_amount' => $row['scholarship'] === 'Yes' ? $row['scholarship_amount'] : null,
            ];

            if ($row['student_category'] === 'Professional') {
                $studentData['course_id_prof'] = $row['course_id_prof'] ?? null;
                $studentData['currency_prof'] = $row['currency_prof'] ?? null;
                $studentData['fees_prof'] = $row['fees_prof'] ?? null;
                $studentData['duration_prof'] = $row['duration_prof'] ?? null;
            } elseif ($row['student_category'] === 'Academic') {
                $studentData['course_id'] = $row['course_id'] ?? null;
                $studentData['currency'] = $row['currency'] ?? null;
                $studentData['fees'] = $row['fees'] ?? null;
                $studentData['level'] = $row['level'] ?? null;
                $studentData['session'] = $row['session'] ?? null;
                $studentData['academicyear'] = $row['academicyear'] ?? null;
            }

            $user->student()->create($studentData);

            // Assign student role
            $user->assignRole('Student');
        }
        
    }

    private function formatDate($dateString)
    {
        // Handle different date formats from Excel
        try {
            return Carbon::parse($dateString)->format('Y-m-d');
        } catch (\Exception $e) {
            return Carbon::now()->format('Y-m-d');
        }
    }
    
}
