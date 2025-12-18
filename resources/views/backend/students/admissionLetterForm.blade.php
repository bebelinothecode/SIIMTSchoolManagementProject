@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-10 px-4">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Admission Letter Details</h1>
        <p class="text-gray-600 mb-6">Please fill in the details that will appear on the admission letter for <strong>{{ $student->user->name }}</strong></p>

        <form action="{{ route('student.print.preview', $student->id) }}" method="POST" class="space-y-6">
            @csrf

            <!-- Academic Year -->
            <div>
                <label for="academic_year" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="text-red-500">*</span> Academic Year
                </label>
                <input 
                    type="text" 
                    id="academic_year" 
                    name="academic_year" 
                    placeholder="e.g., 2024/2025"
                    value="{{ $academicyear->startyear }}/{{ $academicyear->endyear }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required
                >
                <p class="mt-1 text-xs text-gray-500">Format: YYYY/YYYY</p>
            </div>

            <!-- Resumption Date -->
            <div>
                <label for="resumption_date" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="text-red-500">*</span> School Resumption Date
                </label>
                <input 
                    type="date" 
                    id="resumption_date" 
                    name="resumption_date"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required
                >
                <p class="mt-1 text-xs text-gray-500">e.g., 17 February 2025</p>
            </div>

            <!-- Registration Start Date -->
            <div>
                <label for="registration_start_date" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="text-red-500">*</span> Registration Start Date
                </label>
                <input 
                    type="date" 
                    id="registration_start_date" 
                    name="registration_start_date"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required
                >
            </div>

            <!-- Registration End Date -->
            <div>
                <label for="registration_end_date" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="text-red-500">*</span> Registration End Date
                </label>
                <input 
                    type="date" 
                    id="registration_end_date" 
                    name="registration_end_date"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required
                >
            </div>

            <!-- Orientation Date -->
            <div>
                <label for="orientation_date" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="text-red-500">*</span> Orientation Date
                </label>
                <input 
                    type="date" 
                    id="orientation_date" 
                    name="orientation_date"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required
                >
            </div>

            <!-- Lectures Begin Date -->
            <div>
                <label for="lectures_begin_date" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="text-red-500">*</span> Date Lectures Begin
                </label>
                <input 
                    type="date" 
                    id="lectures_begin_date" 
                    name="lectures_begin_date"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required
                >
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6 border-t">
                <a href="{{ url()->previous() }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700">
                    Continue to Preview
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
