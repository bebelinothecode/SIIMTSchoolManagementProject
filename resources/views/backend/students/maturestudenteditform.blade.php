@extends('layouts.app') 

@section('content')
<div class="roles">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-gray-700 uppercase font-bold">Edit Mature Student</h2>
        </div>
        <div class="flex flex-wrap items-center">
            <a href="{{ route('mature.index') }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
                <svg class="w-3 h-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <path fill="currentColor" d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z"/>
                </svg>
                <span class="ml-2 text-xs font-semibold">Back</span>
            </a>
        </div>
    </div>

    <div class="table w-full mt-8 bg-white rounded">
        <form action="{{ route('edit.maturestudent', $matureStudent->id) }}" method="POST" class="w-full max-w-xl px-6 py-12" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="list-disc list-inside text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif 

            <!-- Name -->
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">Name</label>
                </div>
                <div class="md:w-2/3">
                    <input name="name" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" placeholder="Enter name..." value="{{ old('name', $matureStudent->name) }}" required>
                    @error('name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Phone -->
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">Phone</label>
                </div>
                <div class="md:w-2/3">
                    <input name="phone" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="number" value="{{ old('phone', $matureStudent->phone) }}" required>
                    @error('phone')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Course -->
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">Interested Course</label>
                </div>
                <div class="md:w-2/3">
                    <select name="course_id" class="form-select select2-dropdown w-full" id="choices-select">
                        <option value="">-- Select Program --</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id', $matureStudent->course_id) == $course->id ? 'selected' : '' }}>
                                {{ $course->course_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Currency -->
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">Currency</label>
                </div>
                <div class="md:w-2/3">
                    <select name="currency" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                        <option value="">--Select currency--</option>
                        <option value="Ghana Cedi" {{ old('currency', $matureStudent->currency) == 'Ghana Cedi' ? 'selected' : '' }}>Ghana Cedi</option>
                        <option value="Dollar" {{ old('currency', $matureStudent->currency) == 'Dollar' ? 'selected' : '' }}>Dollar</option>
                    </select>
                </div>
            </div>

            <!-- Amount Paid -->
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">Amount Paid</label>
                </div>
                <div class="md:w-2/3">
                    <input name="amount_paid" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="number" placeholder="Enter amount" value="{{ old('amount_paid', $matureStudent->amount_paid) }}" required>
                    @error('amount_paid')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Gender -->
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">Gender</label>
                </div>
                <div class="md:w-2/3 flex items-center space-x-4">
                    <label class="text-gray-600">
                        <input type="radio" name="gender" value="Male" {{ old('gender', $matureStudent->gender) == 'Male' ? 'checked' : '' }}> Male
                    </label>
                    <label class="text-gray-600">
                        <input type="radio" name="gender" value="Female" {{ old('gender', $matureStudent->gender) == 'Female' ? 'checked' : '' }}> Female
                    </label>
                </div>
                @error('gender')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date of Birth -->
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">Date of Birth</label>
                </div>
                <div class="md:w-2/3">
                    <input name="date_of_birth" id="datepicker-sc" autocomplete="off" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" value="{{ old('date_of_birth', $matureStudent->date_of_birth) }}">
                    @error('date_of_birth')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="md:flex md:items-center">
                <div class="md:w-1/3"></div>
                <div class="md:w-2/3">
                    <button type="submit" class="shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
                        Edit Student
                    </button>
                </div>
            </div>
        </form>

        <!-- SweetAlert notifications -->
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
                    icon: "error",
                    title: "Oops...",
                    text: '{{ session('error') }}',
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
            </script>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Choices.js on select
        new Choices('#choices-select', {
            removeItemButton: true,
            searchEnabled: true,
            searchPlaceholderValue: 'Search for a course...'
        });

        // Initialize flatpickr for date of birth with max age 16+
        const maxDate = new Date();
        maxDate.setFullYear(maxDate.getFullYear() - 16);

        flatpickr("#datepicker-sc", {
            dateFormat: "Y-m-d",
            maxDate: maxDate
        });
    });
</script>
@endpush
