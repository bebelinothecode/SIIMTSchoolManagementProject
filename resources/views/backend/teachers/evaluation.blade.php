@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-4">Lecturer Evaluations - Submissions</h2>

    <table class="w-full border">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2 border">Student</th>
                <th class="p-2 border">Course</th>
                <th class="p-2 border">Level</th>
                <th class="p-2 border">Semester</th>
                <th class="p-2 border">Submitted At</th>
                <th class="p-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($submissions as $submission)
                <tr>
                    <td class="p-2 border">{{ $submission->student->full_name ?? 'N/A' }}</td>
                    <td class="p-2 border">{{ $submission->course_name }}</td>
                    <td class="p-2 border">{{ $submission->level }}</td>
                    <td class="p-2 border">{{ $submission->semester }}</td>
                    <td class="p-2 border">{{ $submission->created_at->format('Y-m-d H:i') }}</td>
                    <td class="p-2 border">
                        <a href=" " 
                           class="text-blue-500 hover:underline">View Details</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $submissions->links() }}
    </div>
</div>
@endsection
