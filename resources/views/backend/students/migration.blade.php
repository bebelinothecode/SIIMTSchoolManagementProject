{{-- @extends('layouts.app')

@section('content')
    <div class="create">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">Student Migration</h2>
            </div>
        </div>

        <div class="w-full mt-8 bg-white rounded">
            <form action="{{route('students.promote')}}" method="POST" class="md:flex md:items-center md:justify-between px-6 py-6 pb-0">
                @csrf
                @method('PUT')
                <div class="md:flex md:items-center mb-6 text-gray-700 uppercase font-bold">
                    <div>
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            From
                        </label>
                    </div>
                    <div class="flex flex-row items-center bg-gray-200 px-4 py-3 rounded">
                        <div class="relative">
                            <select name="from" class="block font-bold appearance-none w-full bg-gray-200 border border-gray-200 text-gray-600 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                                <option value="">--Select Level--</option>
                                @foreach ($levels as $level)
                                    <option value="{{ $level->name }}">{{ $level->name }}</option>
                                @endforeach
                                @error('from')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6 text-gray-700 uppercase font-bold">
                    <div>
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            To
                        </label>
                    </div>
                    <div class="block text-gray-600 font-bold">
                        <div class="relative">
                            <select name="to" class="block font-bold appearance-none w-full bg-gray-200 border border-gray-200 text-gray-600 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                                <option value="">--Select Level--</option>
                                @foreach ($levels as $level)
                                    <option value="{{ $level->name }}">{{ $level->name }}</option>
                                @endforeach
                                @error('to')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6 text-gray-700 uppercase font-bold">
                    <button class="shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">Migrate</button>
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
        </div>
    </div>
@endsection --}}


@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Promote Students</h1>

    <!-- Success Message -->
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Promotion Form -->
    <form action=" " method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf

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
</div>
@endsection