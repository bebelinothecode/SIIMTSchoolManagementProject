@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-6">
    <h1 class="text-2xl font-bold text-gray-700">Teachers Reports</h1>

    <!-- Report Generation Form -->
<div class="mt-8 p-6 bg-white rounded-lg shadow">
    <h2 class="text-xl font-bold text-gray-700 mb-4">Generate Reports</h2>
    <form action="{{route('teacher.report')}} " method="GET" class="space-y-4">
        <!-- Date Range -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        </div>

        <!-- Level and Semester -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="level" class="block text-sm font-medium text-gray-700">Level</label>
                <select 
                    name="level" 
                    id="level" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                >
                            <option value="">Select Level</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                            <option value="300">300</option>
                            <option value="400">400</option>
                        </select>
                    </div>
            <div>
                <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                <select 
                    name="semester" 
                    id="semester" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                >
                    <option value="">Select Semester</option>
                    <option value="1">Semester 1</option>
                    <option value="2">Semester 2</option>
                </select>
                </div>
            <div>
                <label for="subjects" class="block text-sm font-medium text-gray-700">Subjects</label>
                <select 
                    name="subjectID" 
                    id="subjectID" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                >
                <option value="">--Select Subject--</option>
                                @foreach ($subjects as $subject)
                                     <option value="{{$subject->id}}">{{ $subject->subject_code }}-{{$subject->subject_name}}</option>
                                @endforeach
                    {{-- <option value="">Select Student Category</option>
                    <option value="Academic">Academic</option>
                    <option value="Professional">Professional</option> --}}
                            </select>
                    </div>
            {{-- <div>
                <label for="attendance_time" class="block text-sm font-medium text-gray-700">Attendance Time</label>
                <select 
                    name="attendance_time" 
                    id="attendance_time" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                >
                    <option value="">Select Attendance Time</option>
                    <option value="weekday">Weekday</option>
                    <option value="weekend">Weekend</option>
                            </select>
            </div> --}}
                        </div>

        <!-- Gender and Local/Foreign -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                <select 
                    name="gender" 
                    id="gender" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                >
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
                    </div>
            {{-- <div>
                <label for="is_local" class="block text-sm font-medium text-gray-700">Status</label>
                <select 
                    name="is_local" 
                    id="is_local" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                >
                    <option value="">Select Status</option>
                    <option value="1">Local</option>
                    <option value="0">Foreign</option>
                </select>
            </div> --}}
                </div>

        <!-- Submit Button -->
        <div>
            <button 
                type="submit" 
                class="my-2 px-6 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
            >
                            Generate Report
                        </button>
                    </div>
            </form>        
        </div>

    <!-- Search Form -->
    {{-- <form action="{{ route('student.index')}}" method="GET" class="flex items-center mt-4 space-x-4">
        <input 
            type="text" 
            name="search" 
            placeholder="Search Student" 
            value="{{ request('search') }}"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
        >
        <button 
            type="submit" 
            class="px-4 py-2 m-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
        >
            Search
        </button>
    </form> --}}
    
    <!-- Students Table -->
    {{-- <div class="mt-6 bg-white rounded-lg shadow">
        <table class="w-full table-auto">
            <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">Course/Diploma</th>
                    <th class="py-3 px-6 text-left">Index Number</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse ($students as $student)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $student->user->name }}</td>
                    <td class="py-3 px-6 text-left">{{ $student->user->email }}</td>
                    <td class="py-3 px-6 text-left">{{ $student->course->course_name ?? $student->diploma->name ?? 'N/A' }}</td>
                    <td class="py-3 px-6 text-left">{{ $student->index_number }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-3 px-6 text-center text-gray-500">No students found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div> --}}

    <!-- Pagination -->
    {{-- <div class="mt-8">
        {{ $students->links() }}
    </div> --}}
    </div>
@endsection
