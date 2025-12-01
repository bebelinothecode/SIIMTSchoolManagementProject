@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Teacher Attendance System</h2>

        <!-- Attendance Form Card -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Take Attendance</h3>

            <form id="attendanceForm">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="teacher_id" class="block text-sm font-medium text-gray-700 mb-1">Teacher</label>
                        <select name="teacher_id" id="teacher_id" class="w-full bg-gray-50 border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-indigo-500" required>
                            <option value="">-- Select Teacher --</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->user->name ?? "N/A" }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="subject_id" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                        <select name="subject_id" id="subject_id" class="w-full bg-gray-50 border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-indigo-500" disabled required>
                            <option value="">-- Select Subject --</option>
                        </select>
                    </div>
                </div>

                <!-- Selected Teacher and Subject Info -->
                <div id="selectedInfo" class="bg-gray-50 border border-gray-200 rounded-md p-4 mb-4" style="display: none;">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Selected Teacher and Subject</h4>
                    <p class="text-sm text-gray-900">Teacher: <span id="selectedTeacher"></span></p>
                    <p class="text-sm text-gray-900">Subject: <span id="selectedSubject"></span></p>
                </div>

                <!-- Session Info -->
                <div id="sessionInfo" class="bg-blue-50 border border-blue-200 rounded-md p-4 mb-4" style="display: none;">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-medium text-blue-800">
                            Remaining Sessions: <span id="remainingSessions" class="font-bold">0</span>
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div>
                        <label for="attendance_date" class="block text-sm font-medium text-gray-700 mb-1">Attendance Date</label>
                        <input type="date" name="attendance_date" id="attendance_date" value="{{ date('Y-m-d') }}" class="w-full bg-gray-50 border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-indigo-500" required>
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                        <select name="type" id="type" class="w-full bg-gray-50 border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-indigo-500" required>
                            <option value="">-- Select Type --</option>
                            <option value="Weekday">Weekday</option>
                            <option value="Weekend">Weekend</option>
                            <option value="Online">Online</option>
                        </select>
                    </div>

                    <div>
                        <label for="attendance_status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="attendance_status" id="attendance_status" class="w-full bg-gray-50 border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-indigo-500" required>
                            <option value="">-- Select Status --</option>
                            <option value="present">Present</option>
                            <option value="absent">Absent</option>
                        </select>
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Submit Attendance
                    </button>
                </div>
            </form>
        </div>

        <!-- Attendance History Card -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Attendance History</h3>
            <h4 id="historyTitle" class="text-md font-medium text-gray-600 mb-4" style="display: none;">For: <span id="historyTeacher"></span> - <span id="historySubject"></span></h4>
            <div id="attendanceHistory" class="overflow-hidden">
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-gray-500">Select a teacher and subject to view attendance history.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.select2-container--default .select2-selection--single,
.select2-container--default .select2-selection--multiple {
    border-radius: .375rem;
    border-color: #d1d5db;
    background-color: #f9fafb;
    padding: .5rem .75rem;
    height: auto;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 100%;
}
.attendance-table {
    max-height: 400px;
    overflow-y: auto;
}
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Select2
    $('#teacher_id').select2({
        placeholder: '-- Select Teacher --',
        allowClear: true,
        width: '100%'
    });

    // Load subjects when teacher is selected
    $('#teacher_id').on('change', function() {
        const teacherId = $(this).val();

        if (teacherId) {
            const teacherName = $('#teacher_id option:selected').text();
            $('#selectedTeacher').text(teacherName);
            $('#subject_id').prop('disabled', false);
            loadTeacherSubjects(teacherId);
        } else {
            $('#subject_id').prop('disabled', true).html('<option value="">-- Select Subject --</option>');
            $('#selectedInfo').hide();
            $('#sessionInfo').hide();
            $('#historyTitle').hide();
            $('#attendanceHistory').html(`
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-gray-500">Select a teacher and subject to view attendance history.</p>
                </div>
            `);
        }
    });

    // Load attendance record when subject is selected
    $('#subject_id').on('change', function() {
        const teacherId = $('#teacher_id').val();
        const subjectId = $(this).val();

        if (teacherId && subjectId) {
            const subjectText = $('#subject_id option:selected').text();
            const subjectName = subjectText.split(' (')[0];
            $('#selectedSubject').text(subjectName);
            $('#selectedInfo').show();
            loadAttendanceRecord(teacherId, subjectId);
        } else {
            $('#selectedInfo').hide();
            $('#historyTitle').hide();
        }
    });

    // Handle form submission
    $('#attendanceForm').on('submit', function(e) {
        e.preventDefault();
        submitAttendance();
    });

    function loadTeacherSubjects(teacherId) {
        $.get(`/teacher-attendance/teacher-subjects/${teacherId}`, function(data) {
            let options = '<option value="">-- Select Subject --</option>';
            data.forEach(function(subject) {
                options += `<option value="${subject.subject_id}" data-sessions="${subject.num_of_sessions}">
                    ${subject.subject.name} (${subject.remaining_sessions} sessions remaining)
                </option>`;
            });
            $('#subject_id').html(options);
            
            // Re-initialize Select2 for subject dropdown
            $('#subject_id').select2({
                placeholder: '-- Select Subject --',
                allowClear: true,
                width: '100%'
            });
        }).fail(function() {
            $('#subject_id').html('<option value="">-- Select Subject --</option>');
            $('#sessionInfo').hide();
        });
    }

    function loadAttendanceRecord(teacherId, subjectId) {
        $.get(`/teacher-attendance/record/${teacherId}/${subjectId}`, function(data) {
            // Update history title
            $('#historyTeacher').text(data.teacher_name);
            $('#historySubject').text(data.subject_name);
            $('#historyTitle').show();

            // Update session info
            $('#remainingSessions').text(data.remaining_sessions);
            $('#sessionInfo').show();

            // Display attendance history
            if (data.attendance.length > 0) {
                let table = `
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teacher Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">`;
                
                data.attendance.forEach(function(record) {
                    const statusClass = record.attendence_status === 'present' ? 'text-green-600' : 'text-red-600';
                    const statusIcon = record.attendence_status === 'present' ? 
                        '<svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>' :
                        '<svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>';
                    
                    table += `
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${data.teacher_name}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${data.subject_name}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${record.attendence_date}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium ${statusClass}">
                                ${statusIcon}${record.attendence_status}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${record.type}</td>
                        </tr>`;
                });
                
                table += `</tbody></table></div>`;
                $('#attendanceHistory').html(table);
            } else {
                $('#attendanceHistory').html(`
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-gray-500">No attendance records found for this subject.</p>
                    </div>
                `);
            }
        }).fail(function() {
            $('#historyTitle').hide();
            $('#attendanceHistory').html(`
                <div class="text-center py-8">
                    <p class="text-red-500">Error loading attendance records.</p>
                </div>
            `);
        });
    }

    function submitAttendance() {
        const formData = $('#attendanceForm').serialize();
        const submitBtn = $('#attendanceForm button[type="submit"]');
        
        // Show loading state
        submitBtn.prop('disabled', true).html(`
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Processing...
        `);
        
        $.post('/teacher-attendance', formData, function(response) {
            if (response.success) {
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                
                // Reload the attendance record and subjects
                const teacherId = $('#teacher_id').val();
                const subjectId = $('#subject_id').val();
                if (teacherId && subjectId) {
                    loadAttendanceRecord(teacherId, subjectId);
                    loadTeacherSubjects(teacherId);
                }
                
                // Reset form but keep teacher and subject
                $('#attendance_date').val('{{ date('Y-m-d') }}');
                $('#type').val('');
                $('#attendance_status').val('');
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: response.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        }).fail(function(xhr) {
            const response = xhr.responseJSON;
            Swal.fire({
                title: 'Error!',
                text: response?.message || 'Something went wrong!',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }).always(function() {
            // Reset button state
            submitBtn.prop('disabled', false).html(`
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Submit Attendance
            `);
        });
    }
});
</script>
@endpush

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    });
</script>
@endif

@if (session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Error!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });
</script>
@endif