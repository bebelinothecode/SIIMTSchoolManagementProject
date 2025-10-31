@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-10">
    <div class="bg-indigo-600 text-white px-6 py-5 rounded-t-2xl shadow-md flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold">
                All Subjects for {{ $student->user->name }}
            </h2>
            <p class="text-sm text-indigo-100">
                {{ $student->course->course_name ?? 'No course' }} • {{ $student->course->course_code }}
            </p>
        </div>

        {{-- Register Courses Button (Top Right Corner) --}}
        <a href="" 
           class="bg-white text-indigo-700 font-semibold px-4 py-2 rounded-lg shadow hover:bg-indigo-100 transition duration-200">
            Register Courses
        </a>
    </div>

    <div class="bg-white shadow-lg rounded-b-2xl border border-gray-200">
        <div class="p-6 space-y-10">
            @foreach($subjects as $level => $semesters)
                <div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4 border-b-2 border-indigo-500 inline-block pb-1">
                        Level {{ $level }}
                    </h3>

                    <div class="grid md:grid-cols-2 gap-6">
                        @foreach($semesters as $semester => $subjectList)
                            <div class="border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition duration-200">
                                <div class="bg-indigo-100 px-4 py-3 rounded-t-xl flex items-center justify-between">
                                    <h4 class="font-semibold text-indigo-800">Semester {{ $semester }}</h4>
                                    <span class="text-xs text-indigo-600 bg-indigo-200 px-2 py-1 rounded-full">
                                        {{ count($subjectList) }} Subjects
                                    </span>
                                </div>
                                <div class="p-4 overflow-x-auto">
                                    <table class="min-w-full text-sm text-gray-700">
                                        <thead>
                                            <tr class="bg-gray-50 text-gray-600 uppercase text-xs">
                                                <th class="px-3 py-2 text-left">#</th>
                                                <th class="px-3 py-2 text-left">Subject Name</th>
                                                <th class="px-3 py-2 text-left">Code</th>
                                                <th class="px-3 py-2 text-left">Credit Hours</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($subjectList as $index => $subject)
                                                <tr class="hover:bg-indigo-50 transition">
                                                    <td class="px-3 py-2 border-t">{{ $index + 1 }}</td>
                                                    <td class="px-3 py-2 border-t font-medium text-gray-900">{{ $subject->subject_name }}</td>
                                                    <td class="px-3 py-2 border-t">{{ $subject->subject_code }}</td>
                                                    <td class="px-3 py-2 border-t">{{ $subject->credit_hours }}</td>
                                                </tr>
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
    </div>
</div>
@endsection
