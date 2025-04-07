<?php

namespace App\Imports;

// class StudentsImport implements WithHeadingRow, ToCollection
// {
//     public function collection(Collection $rows)
//     {
//         foreach($rows as $row) {
//             $user = User::create([
//                 'name' => $row['name'] ?? "name",
//                 'email' => $row['email'] ?? "email",
//                 'password' => Hash::make('defaultpassword'),
//                 'profile_picture' => 'avatar.png', // Default avatar
//             ]);

//             $studentData = [
//                 isset($row['phone']) ? $row['phone'] : null,
//                 'gender' => $row['gender'],
//                 'attendance_time' => $row['attendance_time'],
//                 'dateofbirth' => $this->formatDate($row['dateofbirth']),
//                 'current_address' => $row['current_address'],
//                 'index_number' => $row['index_number'],
//                 'student_parent' => $row['student_parent'],
//                 'parent_phonenumber' => $row['parent_phonenumber'],
//                 'student_category' => $row['student_category'],
//                 'scholarship' => $row['scholarship'],
//                 'scholarship_amount' => $row['scholarship'] === 'Yes' ? $row['scholarship_amount'] : null,
//             ];

//             if ($row['student_category'] === 'Professional') {
//                 $row['course_id_prof'] = ($row['course_id_prof'] === 'NULL') ? null : $row['course_id_prof'];                $studentData['currency_prof'] = $row['currency_prof'] ?? null;
//                 $studentData['fees_prof'] = $row['fees_prof'] ?? null;
//                 $studentData['duration_prof'] = $row['duration_prof'] ?? null;
//             } elseif ($row['student_category'] === 'Academic') {
//                 $studentData['course_id'] = $row['course_id'] ?? null;
//                 $studentData['currency'] = $row['currency'] ?? null;
//                 $studentData['fees'] = $row['fees'] ?? null;
//                 $studentData['level'] = $row['level'] ?? null;
//                 $studentData['session'] = $row['session'] ?? null;
//                 $studentData['academicyear'] = $row['academicyear'] ?? null;
//             }

//             $user->student()->create($studentData);

//             // Assign student role
//             $user->assignRole('Student');
//         }
        
//     }

//     private function formatDate($dateString)
//     {
//         // Handle different date formats from Excel
//         try {
//             return Carbon::parse($dateString)->format('Y-m-d');
//         } catch (\Exception $e) {
//             return Carbon::now()->format('Y-m-d');
//         }
//     }
// }



use App\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements WithHeadingRow, ToCollection
{
    public function collection(Collection $rows)
    {
        // Uncomment to debug headers
        // dd($rows->first());
        
        foreach($rows as $row) {
            // Normalize the row keys by trimming and converting to lowercase
            $normalizedRow = collect($row)->mapWithKeys(callback: function ($value, $key) {
                return [strtolower(trim($key)) => $value];
            });
            
            $user = User::create([
                'name' => $this->getValue($normalizedRow, ['name', 'student name', 'fullname'], 'Unknown'),
                'email' => $this->getValue($normalizedRow, ['email', 'email address'], 'default@example.com'),
                'password' => Hash::make('defaultpassword'),
                'profile_picture' => 'avatar.png',
            ]);

            $studentData = [
                'phone' => $this->getValue($normalizedRow, ['phone', 'phone number', 'mobile']),
                'gender' => $this->getValue($normalizedRow, ['gender', 'sex']),
                'attendance_time' => $this->getValue($normalizedRow, ['attendance_time', 'attendance time', 'time']),
                'dateofbirth' => $this->formatDate($this->getValue($normalizedRow, ['dateofbirth', 'birthdate', 'dob'])),
                'current_address' => $this->getValue($normalizedRow, ['current_address', 'address', 'current address']),
                'index_number' => $this->getValue($normalizedRow, ['index_number', 'index number', 'id']),
                'student_parent' => $this->getValue($normalizedRow, ['student_parent', 'parent', 'guardian']),
                'parent_phonenumber' => $this->getValue($normalizedRow, ['parent_phonenumber', 'parent phone', 'guardian phone']),
                'student_category' => $this->getValue($normalizedRow, ['student_category', 'category', 'type']),
                'Scholarship' => $this->getValue($normalizedRow, ['scholarship', 'financial aid']),
                'Scholarship_amount' => $normalizedRow->get('Scholarship') === 'Yes' 
                    ? $this->getValue($normalizedRow, ['scholarship_amount', 'scholarship amount']) 
                    : null,
            ];

            if ($studentData['student_category'] === 'Professional') {
                $studentData['course_id_prof'] = $this->getValue($normalizedRow, ['course_id_prof', 'professional course']);
                $studentData['currency_prof'] = $this->getValue($normalizedRow, ['currency_prof', 'professional currency']);
                $studentData['fees_prof'] = $this->getValue($normalizedRow, ['fees_prof', 'professional fees']);
                $studentData['duration_prof'] = $this->getValue($normalizedRow, ['duration_prof', 'professional duration']);
            } elseif ($studentData['student_category'] === 'Academic') {
                $studentData['course_id'] = $this->getValue($normalizedRow, ['course_id', 'course']);
                $studentData['currency'] = $this->getValue($normalizedRow, ['currency', 'fee currency']);
                $studentData['fees'] = $this->getValue($normalizedRow, ['fees', 'course fees']);
                $studentData['level'] = $this->getValue($normalizedRow, ['level', 'year level']);
                $studentData['session'] = $this->getValue($normalizedRow, ['session', 'term']);
                $studentData['academicyear'] = $this->getValue($normalizedRow, ['academicyear', 'academic year']);
            }

            $user->student()->create($studentData);
            $user->assignRole('Student');
        }
    }

    private function formatDate($dateString)
    {
        if (empty($dateString)) {
            return null;
        }

        try {
            return Carbon::parse($dateString)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
    
    private function getValue($collection, $possibleKeys, $default = null)
    {
        if (!is_array($possibleKeys)) {
            $possibleKeys = [$possibleKeys];
        }
        
        foreach ($possibleKeys as $key) {
            if ($collection->has($key)) { // Fixed missing parenthesis
                $value = $collection->get($key); // Fixed missing semicolon
                if ($value !== null && $value !== '') {
                    return $value;
                }
            }
        }
        
        return $default;
    }
}
