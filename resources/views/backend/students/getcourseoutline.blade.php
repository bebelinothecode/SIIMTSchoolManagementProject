@extends('layouts.app')

@section('title', 'Course Curriculum - BSc Information Systems')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">
            {{ $user->name }}  - Course Outline
        </h1>
        @if(!empty($formatted) && $formatted->isNotEmpty())
            <p class="text-gray-600">{{ $formatted->first()['course_name'] }} - Complete curriculum overview</p>
        @else
            <p class="text-gray-600">Course curriculum overview</p>
        @endif

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
    </div>

    @php
        // Group the data by level for better organization
        $groupedData = collect($formatted)->groupBy('level_name');
    @endphp

    @foreach($groupedData as $level => $semesters)
        <div class="mb-12">
            <!-- Level Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-t-lg p-4">
                <h2 class="text-2xl font-semibold">Level {{ $level }}</h2>
            </div>

            <div class="bg-white border border-gray-200 rounded-b-lg shadow-lg">
                @foreach($semesters as $index => $semesterData)
                    @if($index > 0)
                        <hr class="border-gray-200">
                    @endif
                    
                    <div class="p-6">
                        <!-- Semester Header -->
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-semibold text-gray-700">
                                Semester {{ $semesterData['semester_name'] }}
                            </h3>
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                {{ count($semesterData['subjects']) }} Subjects
                            </span>
                        </div>

                        <!-- Subjects Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($semesterData['subjects'] as $subject)
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                                    <div class="flex justify-between items-start">
                                        <h4 class="font-medium text-gray-800 flex-1 pr-2">
                                            {{ $subject['subject_name'] }}
                                        </h4>
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-medium whitespace-nowrap">
                                            {{ $subject['credit_hours'] }} Credits
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Semester Summary -->
                        @php
                            $totalCredits = collect($semesterData['subjects'])->sum(function($subject) {
                                return (int) $subject['credit_hours'];
                            });
                        @endphp
                        
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Total Credits for Semester {{ $semesterData['semester_name'] }}:</span>
                                <span class="text-blue-600 font-semibold">{{ $totalCredits }} Credits</span>
                            </p>
                        </div>
                    </div>
                @endforeach

                <!-- Level Summary -->
                @php
                    $levelTotalCredits = $semesters->sum(function($semester) {
                        return collect($semester['subjects'])->sum(function($subject) {
                            return (int) $subject['credit_hours'];
                        });
                    });
                    $levelTotalSubjects = $semesters->sum(function($semester) {
                        return count($semester['subjects']);
                    });
                @endphp
                
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    <div class="flex justify-between items-center text-sm">
                        <span class="font-medium text-gray-700">Level {{ $level }} Summary:</span>
                        <div class="space-x-4">
                            <span class="text-gray-600">{{ $levelTotalSubjects }} Total Subjects</span>
                            <span class="text-blue-600 font-semibold">{{ $levelTotalCredits }} Total Credits</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Overall Program Summary -->
    @php
        $programTotalCredits = collect($formatted)->sum(function($semester) {
            return collect($semester['subjects'])->sum(function($subject) {
                return (int) $subject['credit_hours'];
            });
        });
        $programTotalSubjects = collect($formatted)->sum(function($semester) {
            return count($semester['subjects']);
        });
    @endphp

    <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg p-6 shadow-lg">
        <h3 class="text-xl font-semibold mb-3">Program Overview</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center">
                <div class="text-2xl font-bold">{{ $groupedData->count() }}</div>
                <div class="text-green-100">Academic Levels</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold">{{ $programTotalSubjects }}</div>
                <div class="text-green-100">Total Subjects</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold">{{ $programTotalCredits }}</div>
                <div class="text-green-100">Total Credits</div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .hover\:shadow-md:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    .transition-shadow {
        transition-property: box-shadow;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .duration-200 {
        transition-duration: 200ms;
    }
</style>
@endsection