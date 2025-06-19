@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
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

    @if($subjects->isEmpty())
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6">
            <p>No subjects found for this course outline or you are offering a diploma/professional course.</p>
        </div>
    @else
        @php
            // Custom sorting function
            $sortedSubjects = $subjects->sortBy(function($group, $key) {
                // Extract level and semester from the group key
                preg_match('/Level (\d+) - Semester (\d+)/', $key, $matches);
                $level = $matches[1] ?? 0;
                $semester = $matches[2] ?? 0;
                
                // Create a sort key where level is primary and semester is secondary
                // Semester 4 (1st semester) comes before 2 (2nd semester)
                return ($level * 10) + ($semester == 4 ? 0 : 1);
            });
        @endphp

        <div class="space-y-12">
            @foreach($sortedSubjects as $levelSemester => $subjectGroup)
                @php
                    // Extract level and semester from the group key
                    preg_match('/Level (\d+) - Semester (\d+)/', $levelSemester, $matches);
                    $level = $matches[1] ?? '';
                    $semesterNumber = $matches[2] ?? '';
                    
                    // Map semester numbers to display names
                    $semesterDisplay = [
                        '4' => 'First Semester',
                        '2' => 'Second Semester'
                    ][$semesterNumber] ?? 'Semester ' . $semesterNumber;
                @endphp
<div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-800 text-white px-6 py-4">
                        <h2 class="text-xl font-semibold">Level {{ $level }} - {{ $semesterDisplay }}</h2>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Credit Hours</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Level</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($subjectGroup as $subject)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">
                                        {{ $subject->subject_code }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $subject->subject_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                            {{ $subject->credit_hours }} CH
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $semesterDisplay }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        Level {{ $subject->level }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection