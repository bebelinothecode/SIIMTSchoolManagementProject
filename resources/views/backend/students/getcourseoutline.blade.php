@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <h2 class="text-3xl font-bold text-blue-700 mb-8">📚 Subjects Grouped by Level & Semester</h2>

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Course Outline</h1>
        <div class="flex space-x-4">
            @if ($student->student_category === 'Academic')
                <a href="{{ route('registration.course') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Register Course
                </a>
            @endif
        </div>
    </div>

    @php
        // Group data by level
        $groupedByLevel = collect($formatted)->groupBy('level_name');
    @endphp

    @foreach($groupedByLevel as $levelName => $semesters)
        <!-- Level Card -->
        <div class="bg-white shadow-xl rounded-2xl mb-10 overflow-hidden border border-gray-200">
            <!-- Level Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 text-white px-6 py-5">
                <h3 class="text-2xl font-semibold">Level: {{ $levelName }}</h3>
            </div>

            <!-- Semester Tables -->
            <div class="p-6 space-y-8">
                @foreach($semesters->groupBy('semester_name') as $semesterName => $courses)
                    @php
                        $allSubjects = collect($courses)->pluck('subjects')->flatten(1);
                        $totalSubjects = $allSubjects->count();
                        $totalCredits = $allSubjects->sum('credit_hours');
                    @endphp

                    <div class="border border-gray-100 rounded-xl shadow-sm overflow-hidden">
                        <!-- Semester Header -->
                        <div class="bg-gray-100 px-6 py-3 flex justify-between items-center">
                            <h4 class="text-lg font-semibold text-gray-800">Semester: {{ $semesterName }}</h4>
                            <div class="flex gap-2">
                                <span class="bg-blue-200 text-blue-900 text-xs font-semibold px-3 py-1 rounded-full shadow">
                                    {{ $totalSubjects }} Subjects
                                </span>
                                <span class="bg-green-200 text-green-900 text-xs font-semibold px-3 py-1 rounded-full shadow">
                                    {{ $totalCredits }} Credits
                                </span>
                            </div>
                        </div>

                        <!-- Subjects Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-700">
                                <thead class="bg-gray-50 uppercase text-xs font-semibold text-gray-600">
                                    <tr>
                                        <th class="px-6 py-3">Level</th>
                                        <th class="px-6 py-3">Course Name</th>
                                        <th class="px-6 py-3">Subject Name</th>
                                        <th class="px-6 py-3 text-center">Credit Hours</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($courses as $course)
                                        @foreach($course['subjects'] as $subject)
                                            <tr class="border-b last:border-none hover:bg-gray-50 transition">
                                                <td class="px-6 py-3 font-medium text-gray-900">{{ $levelName }}</td>
                                                <td class="px-6 py-3 font-medium text-gray-900">{{ $course['course_name'] }}</td>
                                                <td class="px-6 py-3">{{ $subject['subject_name'] }}</td>
                                                <td class="px-6 py-3 text-center">{{ $subject['credit_hours'] }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
@endsection
