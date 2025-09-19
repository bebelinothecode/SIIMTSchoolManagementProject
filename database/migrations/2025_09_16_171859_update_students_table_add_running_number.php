<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Add nullable first so it doesn't break existing rows
            $table->unsignedInteger('running_number')->nullable()->after('index_number');
        });

        // ✅ Backfill running_number for existing students
        $students = DB::table('students')
            ->select('id', 'student_category', 'course_id_prof', 'course_id')
            ->orderBy('created_at')
            ->get();

        $counters = [];

        foreach ($students as $student) {
            if ($student->student_category === 'Professional') {
                $groupKey = "prof_" . $student->course_id_prof;
            } elseif ($student->student_category === 'Academic') {
                $groupKey = "acad_" . $student->course_id;
            } else {
                $groupKey = "other";
            }

            if (!isset($counters[$groupKey])) {
                $counters[$groupKey] = 1;
            } else {
                $counters[$groupKey]++;
            }

            DB::table('students')
                ->where('id', $student->id)
                ->update(['running_number' => $counters[$groupKey]]);
        }
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('running_number');
        });
    }
};

