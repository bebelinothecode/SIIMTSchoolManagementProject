<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('students')->insert([
            [
                'level' => '100',
                'gender' => 'Male',
                'phone' => '0241234567',
                'dateofbirth' => '2005-04-12',
                'current_address' => 'Accra, Ghana',
                'attendance_time' => 'Morning',
                'student_parent' => 'John Mensah',
                'parent_phonenumber' => '0249876543',
                'student_category' => 'Regular',
                'course_id_prof' => 1,
                'currency_prof' => 'GHS',
                'fees_prof' => 1500.00,
                'duration_prof' => '1 Year',
                'course_id' => 2,
                'currency' => 'GHS',
                'fees' => 1200.00,
                'session' => '2025/2026',
                'academicyear' => '2025',
                'Scholarship' => 'Yes',
                'Scholarship_amount' => 500.00,
                'index_number' => 'SIIMT2025001',
                'balance' => 700.00,
                'last_level' => 'N/A',
                'last_session' => 'N/A',
                'branch' => 'Main',
                'student_type' => 'Local',
                'admission_cycle' => 'Regular',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
