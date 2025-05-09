@extends('layouts.app')

@section('content')

<div class="bg-gradient-to-tr from-blue-100 via-white to-blue-100 rounded-xl shadow-xl overflow-hidden mt-8">
    <div class="w-full max-w-5xl mx-auto px-8 py-10">
        <h2 class="text-2xl font-extrabold text-gray-800 mb-6 border-b border-blue-300 pb-2">
            🎓 Course Outline
        </h2>

        <!-- Attendance Section -->
        <h3 class="text-xl font-bold text-blue-700 mb-4">📅 Course Outline</h3>
        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="min-w-full text-left text-gray-700 border-collapse">
                <thead class="bg-blue-50 text-blue-700">
                    <tr>
                        <th class="px-4 py-2 font-semibold">Date</th>
                        <th class="px-4 py-2 font-semibold">Class</th>
                        <th class="px-4 py-2 font-semibold">Teacher</th>
                        <th class="px-4 py-2 font-semibold text-right">Status</th>
                    </tr>
                </thead>
                <tbody>
                    {{ $groupedSubjects }}
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
