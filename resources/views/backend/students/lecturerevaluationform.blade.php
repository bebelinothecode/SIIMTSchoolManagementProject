@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-6 shadow-md rounded-lg">
    <h2 class="text-xl font-bold mb-4">Lecturer Evaluation Form</h2>

    <div class="mb-4">
        <p><strong>Student:</strong> {{ $student->name ?? $student->index_number }}</p>
        <p><strong>Course:</strong> {{ $courseName }}</p>
    </div>

    <form action="{{ route('submit.evaluation') }}" method="POST">
        @csrf

        <input type="hidden" name="course" value="{{ $courseName }}">

        <table class="w-full border-collapse border border-gray-300 text-sm">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Subject (Code)</th>
                    <th class="border p-2">Lecturer</th>
                    <th class="border p-2">Clarity (1-5)</th>
                    <th class="border p-2">Knowledge (1-5)</th>
                    <th class="border p-2">Punctuality (1-5)</th>
                    <th class="border p-2">Comments</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $subject)
                    <tr>
                        <td class="border p-2">
                            {{ $subject->subject_name }} ({{ $subject->subject_code }})
                            <input type="hidden" name="evaluations[{{ $subject->subject_code }}][subject_name]" value="{{ $subject->subject_name }}">
                        </td>
                        <td class="border p-2">
                            {{-- TODO: Replace this with lecturer name fetched from DB --}}
                            <select name="evaluations[{{ $subject->subject_code }}][lecturer]" class="border rounded p-1 w-full" required>
                                <option value="">-- Select Lecturer --</option>
                                <option value="Dr. Mensah">Dr. Mensah</option>
                                <option value="Prof. Owusu">Prof. Owusu</option>
                                <option value="Mrs. Adjei">Mrs. Adjei</option>
                            </select>
                        </td>
                        <td class="border p-2">
                            <select name="evaluations[{{ $subject->subject_code }}][clarity]" class="border rounded p-1 w-20" required>
                                <option value="">--</option>
                                @for($i=1; $i<=5; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </td>
                        <td class="border p-2">
                            <select name="evaluations[{{ $subject->subject_code }}][knowledge]" class="border rounded p-1 w-20" required>
                                <option value="">--</option>
                                @for($i=1; $i<=5; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </td>
                        <td class="border p-2">
                            <select name="evaluations[{{ $subject->subject_code }}][punctuality]" class="border rounded p-1 w-20" required>
                                <option value="">--</option>
                                @for($i=1; $i<=5; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </td>
                        <td class="border p-2">
                            <textarea name="evaluations[{{ $subject->subject_code }}][comments]"
                                      class="w-full border rounded p-1"></textarea>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                Submit Evaluation
            </button>
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
@endsection
