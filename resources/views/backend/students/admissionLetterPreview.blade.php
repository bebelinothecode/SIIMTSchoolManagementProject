@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Preview Admission Letter</h1>
        <p class="text-gray-600 mb-8">Review the details that will appear on the admission letter. Click Print or go back to edit.</p>

        <!-- Variables Preview Section -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Letter Variables Preview</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white p-3 rounded border border-gray-200">
                    <p class="text-xs text-gray-500 uppercase">Academic Year</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $letter_details['academic_year'] }}</p>
                </div>
                <div class="bg-white p-3 rounded border border-gray-200">
                    <p class="text-xs text-gray-500 uppercase">School Resumption</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $letter_details['resumption_date_formatted'] }}</p>
                </div>
                <div class="bg-white p-3 rounded border border-gray-200">
                    <p class="text-xs text-gray-500 uppercase">Registration Opens</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $letter_details['registration_start_date_formatted'] }}</p>
                </div>
                <div class="bg-white p-3 rounded border border-gray-200">
                    <p class="text-xs text-gray-500 uppercase">Registration Closes</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $letter_details['registration_end_date_formatted'] }}</p>
                </div>
                <div class="bg-white p-3 rounded border border-gray-200">
                    <p class="text-xs text-gray-500 uppercase">Orientation Date</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $letter_details['orientation_date_formatted'] }}</p>
                </div>
                <div class="bg-white p-3 rounded border border-gray-200">
                    <p class="text-xs text-gray-500 uppercase">Lectures Begin</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $letter_details['lectures_begin_date_formatted'] }}</p>
                </div>
            </div>
        </div>

        <!-- Letter Preview -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Letter Preview</h2>
            <div class="bg-gray-50 border-2 border-dashed border-gray-300 p-8 rounded-lg" style="min-height: 600px; font-family: 'Times New Roman', serif;">
                <!-- Letter Content -->
                <div class="max-w-2xl mx-auto">
                    <p class="text-center mb-4 text-xs">
                        <strong>SIIMT UNIVERSITY</strong><br>
                        School of Postgraduate and Advanced Degree Studies
                    </p>

                    <p class="text-center mb-6 font-bold text-sm">
                        ADMISSION LETTER FOR {{ strtoupper($letter_details['academic_year']) }} ACADEMIC SESSION
                    </p>

                    <p class="mb-4 text-sm">
                        <strong>{{ now()->format('d F Y') }}</strong>
                    </p>

                    <p class="mb-4 text-sm">
                        <strong>{{ $student->user->name }}</strong><br>
                        {{ $student->user->address ?? 'Address not provided' }}
                    </p>

                    <p class="mb-6 text-sm">
                        <strong>Re: ADMISSION INTO THE SCHOOL OF POSTGRADUATE AND ADVANCED DEGREE STUDIES</strong>
                    </p>

                    <p class="mb-4 text-sm leading-relaxed">
                        We are pleased to inform you that you have been selected for admission into {{ $student->course->course_name ?? 'your programme' }} programme in the School of Postgraduate and Advanced Degree Studies, SIIMT UNIVERSITY, for the {{ $letter_details['academic_year'] }} academic session.
                    </p>

                    <p class="mb-4 text-sm leading-relaxed">
                        Your admission is based on merit and subject to the acceptance of the terms and conditions of the University as stated below.
                    </p>

                    <p class="mb-4 text-sm font-bold">
                        IMPORTANT DATES FOR THE {{ strtoupper($letter_details['academic_year']) }} SESSION:
                    </p>

                    <ul class="mb-4 text-sm space-y-2 ml-4">
                        <li>• School Resumption: <strong>{{ $letter_details['resumption_date_formatted'] }}</strong></li>
                        <li>• Registration: <strong>{{ $letter_details['registration_start_date_formatted'] }}</strong> to <strong>{{ $letter_details['registration_end_date_formatted'] }}</strong></li>
                        <li>• Orientation/Matriculation: <strong>{{ $letter_details['orientation_date_formatted'] }}</strong></li>
                        <li>• Lectures Begin: <strong>{{ $letter_details['lectures_begin_date_formatted'] }}</strong></li>
                    </ul>

                    <p class="mb-4 text-sm leading-relaxed">
                        Your registration should be completed within the specified registration period to avoid being dropped from the roll.
                    </p>

                    <p class="mb-4 text-sm leading-relaxed">
                        <strong>Programme Fees:</strong> ₦{{ number_format($student->course->fees ?? 0) }} per session
                    </p>

                    <p class="mb-6 text-sm leading-relaxed">
                        We welcome you to SIIMT UNIVERSITY and wish you a successful and fulfilling academic experience.
                    </p>

                    <p class="text-sm">
                        <strong>Yours in Service,</strong><br><br><br>
                        ___________________<br>
                        REGISTRAR
                    </p>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex gap-4 justify-between border-t pt-6">
            <form action="{{ route('student.print.form', $student->id) }}" method="GET" class="inline">
                <button type="submit" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50">
                    ← Back to Edit
                </button>
            </form>
            <form action="{{ route('student.print', $student->id) }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="letter_details" value="{{ base64_encode(json_encode($letter_details)) }}">
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700">
                    Print Admission Letter
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
