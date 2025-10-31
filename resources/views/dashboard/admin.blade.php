@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-800">📊 Dashboard Overview</h2>
            <p class="text-gray-500">Welcome back, {{ Auth::user()->name ?? 'Admin' }}</p>
        </div>
        <div class="text-right">
            <div class="text-sm text-gray-500">Updated: {{ now()->format('M d, Y') }}</div>
            <div class="mt-2 text-lg font-semibold">Total students: <span class="text-indigo-600">{{ $students->count() ?? 0 }}</span></div>
        </div>
    </div>

    @php
        // Academic breakdown using the students collection passed from controller
        $academicStudents = $students->where('student_category', 'Academic');
        $acadTotal = $academicStudents->count();
        $acadActive = $academicStudents->where('status', 'active')->count();
        $acadCompleted = $academicStudents->filter(function($s){
            return in_array(strtolower($s->status), ['completed','graduated']);
        })->count();
        $acadDeferred = $academicStudents->filter(function($s){
            return in_array(strtolower($s->status), ['defered','deferred','inactive']);
        })->count();

        // Professional breakdown
        $professionalStudents = $students->where('student_category', 'Professional');
        $profTotal = $professionalStudents->count();
        $profActive = $professionalStudents->where('status', 'active')->count();
        $profCompleted = $professionalStudents->filter(function($s){
            return in_array(strtolower($s->status), ['completed','graduated']);
        })->count();
        $profDeferred = $professionalStudents->filter(function($s){
            return in_array(strtolower($s->status), ['defered','deferred','inactive']);
        })->count();
    @endphp

    {{-- Main grid: Academic + Professional --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- ACADEMIC --}}
        <section class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Academic Students</h3>
                    <p class="text-sm text-gray-500 mt-1">Overview and status breakdown</p>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500">Total</div>
                    <div class="text-2xl font-extrabold text-blue-600">{{ $acadTotal }}</div>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="p-4 bg-blue-50 rounded-lg">
                    <div class="text-xs font-semibold text-blue-700 uppercase">Active</div>
                    <div class="mt-2 text-2xl font-bold text-blue-800">{{ $acadActive }}</div>
                </div>
                <div class="p-4 bg-green-50 rounded-lg">
                    <div class="text-xs font-semibold text-green-700 uppercase">Completed</div>
                    <div class="mt-2 text-2xl font-bold text-green-800">{{ $acadCompleted }}</div>
                </div>
                <div class="p-4 bg-yellow-50 rounded-lg">
                    <div class="text-xs font-semibold text-yellow-700 uppercase">Deferred</div>
                    <div class="mt-2 text-2xl font-bold text-yellow-800">{{ $acadDeferred }}</div>
                </div>
            </div>

            {{-- Optional small list or insights --}}
            <div class="mt-6 border-t pt-4">
                <h4 class="text-sm font-semibold text-gray-700">Quick insights</h4>
                <ul class="mt-3 text-sm text-gray-600 space-y-2">
                    <li>Most recent academic enrolment: <span class="font-medium text-gray-800">{{ $academicStudents->first()->name ?? 'N/A' }}</span></li>
                    <li>Programs offered: <span class="font-medium text-gray-800">{{ $academicStudents->pluck('course.course_name')->unique()->filter()->count() ?? 0 }}</span></li>
                </ul>
            </div>
        </section>

        {{-- PROFESSIONAL --}}
        <section class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Professional Students</h3>
                    <p class="text-sm text-gray-500 mt-1">Overview and status breakdown</p>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500">Total</div>
                    <div class="text-2xl font-extrabold text-green-600">{{ $profTotal }}</div>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="p-4 bg-green-50 rounded-lg">
                    <div class="text-xs font-semibold text-green-700 uppercase">Active</div>
                    <div class="mt-2 text-2xl font-bold text-green-800">{{ $profActive }}</div>
                </div>
                <div class="p-4 bg-purple-50 rounded-lg">
                    <div class="text-xs font-semibold text-purple-700 uppercase">Completed</div>
                    <div class="mt-2 text-2xl font-bold text-purple-800">{{ $profCompleted }}</div>
                </div>
                <div class="p-4 bg-amber-50 rounded-lg">
                    <div class="text-xs font-semibold text-amber-700 uppercase">Deferred</div>
                    <div class="mt-2 text-2xl font-bold text-amber-800">{{ $profDeferred }}</div>
                </div>
            </div>

            <div class="mt-6 border-t pt-4">
                <h4 class="text-sm font-semibold text-gray-700">Quick insights</h4>
                <ul class="mt-3 text-sm text-gray-600 space-y-2">
                    <li>Most recent professional enrolment: <span class="font-medium text-gray-800">{{ $professionalStudents->first()->name ?? 'N/A' }}</span></li>
                    <li>Programs offered: <span class="font-medium text-gray-800">{{ $professionalStudents->pluck('diploma.name')->unique()->filter()->count() ?? 0 }}</span></li>
                </ul>
            </div>
        </section>
    </div>

    {{-- Secondary metrics: fees & expenses --}}
    <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-amber-50 border border-amber-200 rounded-2xl shadow-md p-6 text-center">
            <h3 class="text-amber-600 uppercase font-bold mb-2">Total Fees Collected</h3>
            <span class="text-2xl font-extrabold text-amber-700">GHS {{ number_format($totalFeesCollected, 2) }}</span>
        </div>

        <div class="bg-rose-50 border border-rose-200 rounded-2xl shadow-md p-6 text-center">
            <h3 class="text-red-600 uppercase font-bold mb-2">Total Expenses Made</h3>
            <span class="text-2xl font-extrabold text-red-700">GHS {{ number_format($totalExpensesMade, 2) }}</span>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-2xl shadow-md p-6 text-center">
            <h3 class="text-blue-600 uppercase font-bold mb-2">Books</h3>
            <span class="text-2xl font-extrabold text-blue-700">{{ $books ?? 0 }}</span>
        </div>

        <div class="bg-gray-50 border border-gray-200 rounded-2xl shadow-md p-6 text-center">
            <h3 class="text-gray-600 uppercase font-bold mb-2">Teachers</h3>
            <span class="text-2xl font-extrabold text-gray-800">{{ $teachers->count() ?? 0 }}</span>
        </div>
    </div>

    {{-- Recent Activity --}}
    <div class="mt-10 bg-white border border-gray-200 rounded-2xl shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-700 uppercase">Recent Activity</h3>
            <span class="text-sm text-gray-500">Last updated: {{ now()->format('M d, Y') }}</span>
        </div>
        <ul class="divide-y divide-gray-200">
            <li class="py-3 flex items-center justify-between">
                <span>📘 New books were uploaded this week.</span>
                <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full">Update</span>
            </li>
            <li class="py-3 flex items-center justify-between">
                <span>🎓 {{ $students->count() }} students enrolled this semester.</span>
                <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full">Enrollment</span>
            </li>
        </ul>
    </div>
</div>
@endsection
