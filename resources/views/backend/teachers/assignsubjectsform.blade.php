@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Assign subjects to teacher</h2>

        <form method="POST" action="{{ route('assign.subjectstoteacher') }}">
            @csrf

            <div class="space-y-4">

                <!-- TYPE SELECTION -->
                <div>
                    <label for="teacher_type" class="block text-sm font-medium text-gray-700 mb-1">
                        Academic/Professional
                    </label>
                    <select name="teacher_type" id="teacher_type"
                        class="w-full bg-gray-50 border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        <option value="">-- Select --</option>
                        <option value="Academic">Academic</option>
                        <option value="Professional">Professional</option>
                    </select>
                    @error('teacher_type')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- TEACHER -->
                <div id="teacher_div" class="hidden">
                    <label for="teacher_id" class="block text-sm font-medium text-gray-700 mb-1">Teacher</label>
                    <select name="teacher_id" id="teacher_id"
                        class="w-full bg-gray-50 border border-gray-300 rounded-md py-2 px-3">
                        <option value="">-- Select Teacher --</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->user->name ?? 'N/A' }}</option>
                        @endforeach
                    </select>
                    @error('teacher_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SUBJECTS -->
                <div id="subjects_div" class="hidden">
                    <label for="subject_id" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                    <select id="subject_id" name="subject_id" required
                        class="w-full bg-gray-50 border border-gray-300 rounded-md py-2 px-3">
                        <option value="">-- Select Subjects --</option>
                        @foreach($diplomas as $diploma)
                            <option value="{{ $diploma->id }}">{{ $diploma->code }} - {{ $diploma->name }}</option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NUMBER OF SESSIONS PER MONTH -->
                <div id="sessions_div" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Number of Sessions Per Month</label>
                    <div class="grid grid-cols-3 gap-4">
                        @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $index => $month)
                            <div>
                                <label for="num_of_sessions_{{ $index + 1 }}" class="block text-xs text-gray-600">{{ $month }}</label>
                                <input type="number" name="num_of_sessions[{{ $index + 1 }}]" id="num_of_sessions_{{ $index + 1 }}"
                                    class="w-full bg-gray-50 border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                                    placeholder="0" min="0">
                            </div>
                        @endforeach
                    </div>
                    @error('num_of_sessions')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="text-right">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 m-3 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                        Assign Subjects
                    </button>
                </div>
            </div>
            {{-- ASSIGNED SUBJECTS TABLE --}}
            <div class="mt-10">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Assigned Teachers & Subjects</h3>

                <div class="overflow-x-auto bg-white shadow rounded-lg">
                    <table class="min-w-full text-left">
                        <thead class="bg-gray-100 border-b">
                            <tr>
                                <th class="px-4 py-2 text-sm font-medium text-gray-600">Teacher</th>
                                <th class="px-4 py-2 text-sm font-medium text-gray-600">Subject</th>
                                <th class="px-4 py-2 text-sm font-medium text-gray-600">Sessions Per Month</th>
                                <th class="px-4 py-2 text-sm font-medium text-gray-600">Remaining Sessions</th>
                                <th class="px-4 py-2 text-sm font-medium text-gray-600">Teacher Type</th>
                                <th class="px-4 py-2 text-sm font-medium text-gray-600">Assigned On</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($assignedSubjects as $assign)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-2">{{ $assign->teacher->user->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2">{{ $assign->subject->code ?? "N/A" }} - {{ $assign->subject->name ?? "N/A" }}</td>
                                    <td class="px-4 py-2">
                                        @if($assign->aca_prof == 'Professional' && $assign->num_of_sessions)
                                            @php
                                                $sessions = json_decode($assign->num_of_sessions, true);
                                                $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                            @endphp
                                            @if(is_array($sessions))
                                                @foreach($sessions as $index => $count)
                                                    @if($count > 0)
                                                        {{ $months[$index] }}: {{ $count }}<br>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @else
                                            {{ $assign->num_of_sessions ?? '—' }}
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">{{ $assign->remaining_sessions ?? '—' }}</td>
                                    <td class="px-4 py-2">{{ $assign->aca_prof ?? "N/A" }}</td>
                                    <td class="px-4 py-2">{{ $assign->created_at?->format('d M Y') ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-gray-500">
                                        No subjects assigned yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </form>

        @if (session('success'))
            <script>
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif 

        @if (session('error'))
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif 
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
}
</style>
@endpush


@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
/* Select2 initialization */
(function() {
    function initSelect2() {
        if (!window.$ || !$.fn.select2) {
            return setTimeout(initSelect2, 50);
        }

        $('#teacher_id').select2({
            placeholder: '-- Select Teacher --',
            allowClear: true,
            width: '100%'
        });

        $('#subject_id').select2({
            placeholder: 'Select Subject',
            width: '100%'
        });
    }

    document.addEventListener('DOMContentLoaded', initSelect2);
})();
</script>

<script>
/* Show/Hide Logic */
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('teacher_type');
    const teacherDiv = document.getElementById('teacher_div');
    const subjectsDiv = document.getElementById('subjects_div');
    const sessionsDiv = document.getElementById('sessions_div');

    function updateVisibility() {
        const value = typeSelect.value;

        if (value === 'Academic') {
            teacherDiv.classList.remove('hidden');
            subjectsDiv.classList.remove('hidden');
            sessionsDiv.classList.add('hidden');
            // Remove required and disable session inputs
            document.querySelectorAll('input[name^="num_of_sessions"]').forEach(input => {
                input.removeAttribute('required');
                input.setAttribute('disabled', 'disabled');
            });
        } else if (value === 'Professional') {
            teacherDiv.classList.remove('hidden');
            subjectsDiv.classList.remove('hidden');
            sessionsDiv.classList.remove('hidden');
            // Add required and enable session inputs
            document.querySelectorAll('input[name^="num_of_sessions"]').forEach(input => {
                input.setAttribute('required', 'required');
                input.removeAttribute('disabled');
            });
        } else {
            teacherDiv.classList.add('hidden');
            subjectsDiv.classList.add('hidden');
            sessionsDiv.classList.add('hidden');
            // Remove required and disable session inputs
            document.querySelectorAll('input[name^="num_of_sessions"]').forEach(input => {
                input.removeAttribute('required');
                input.setAttribute('disabled', 'disabled');
            });
        }
    }

    typeSelect.addEventListener('change', updateVisibility);
});
</script>

@endpush
