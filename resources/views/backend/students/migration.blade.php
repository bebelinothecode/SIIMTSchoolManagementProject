@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Promote Students</h1>

    <!-- Promotion Form -->
    <form action="{{route('students.promote')}} " method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        @method('PUT')

        <!-- Current Level -->
        <div class="mb-4">
            <label for="current_level" class="block text-gray-700 text-sm font-bold mb-2">Current Level</label>
            <select name="current_level" id="current_level" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="">Select Current Level</option>
                @foreach ($levels as $level)
                    <option value="{{ $level->name }}">{{ $level->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Current Semester -->
        <div class="mb-4">
            <label for="current_semester" class="block text-gray-700 text-sm font-bold mb-2">Current Semester</label>
            <select name="current_semester" id="current_semester" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="">Select Current Semester</option>
                @foreach ($semesters as $semester)
                    <option value="{{ $semester->name }}">{{ $semester->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Target Level -->
        <div class="mb-4">
            <label for="target_level" class="block text-gray-700 text-sm font-bold mb-2">Target Level</label>
            <select name="target_level" id="target_level" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="">Select Target Level</option>
                @foreach ($levels as $level)
                    <option value="{{ $level->name }}">{{ $level->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Target Semester -->
        <div class="mb-6">
            <label for="target_semester" class="block text-gray-700 text-sm font-bold mb-2">Target Semester</label>
            <select name="target_semester" id="target_semester" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="">Select Target Semester</option>
                @foreach ($semesters as $semester)
                    <option value="{{ $semester->name }}">{{ $semester->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Promote Students
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

    @if (session('failure'))
    <script>
        Swal.fire({
            title: 'Failure!',
            text: '{{ session('failure') }}',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>
    @endif
    @if (session('duplicate'))
    <script>
        Swal.fire({
            title: 'Failure!',
            text: '{{ session('duplicate') }}',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>
    @endif
    @if (session('error'))
    <script>
        Swal.fire({
            title: 'Error3!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>
    @endif
</div>
@endsection