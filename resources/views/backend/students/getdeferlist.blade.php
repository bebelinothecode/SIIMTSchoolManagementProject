@extends('layouts.app')

@section('content')
<div class="roles">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-gray-700 uppercase font-bold">Defer Students List</h2>
        </div>
        <div class="flex flex-wrap items-center">
            <a href="{{ url()->previous() }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
                <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="long-arrow-alt-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <path fill="currentColor" d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z"/>
                </svg>
                <span class="ml-2 text-xs font-semibold">Back</span>
            </a>
        </div>
    </div>

    <div class="table w-full mt-8 bg-white rounded">
        <form action="{{ route('get.deferlist') }}" method="GET" class="w-full max-w-xl px-6 py-12" enctype="multipart/form-data">
            @csrf
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                        Academic/Professional
                    </label>
                </div>
                <div class="md:w-2/3 block text-gray-600 font-bold">
                    <div class="relative">
                        <select name="student_category" id="student_category" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value="">--Select--</option>
                            <option value="Academic">Academic</option>
                            <option value="Professional">Professional</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Academic Course --}}
            <div class="md:flex md:items-center mb-6" id="academic-course-wrapper" style="display: none;">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                        Academic Course:
                    </label>
                </div>
                <div class="md:w-2/3 block text-gray-600 font-bold">
                    <select id="choices-select" name="courseID_academic">
                        <option value="">--Select Course--</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->course_code }} - {{ $course->course_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Professional Course --}}
            <div class="md:flex md:items-center mb-6" id="professional-course-wrapper" style="display: none;">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                        Professional Course:
                    </label>
                </div>
                <div class="md:w-2/3 block text-gray-600 font-bold">
                    <select id="choices-select2" name="courseID_professional">
                        <option value="">--Select Course--</option>
                        @foreach ($diplomas as $diploma)
                            <option value="{{ $diploma->id }}">{{ $diploma->code }} - {{ $diploma->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Level --}}
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                        Level
                    </label>
                </div>
                <div class="md:w-2/3 block text-gray-600 font-bold">
                    <div class="relative">
                        <select name="level" id="level" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value="">--Select Level--</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                            <option value="300">300</option>
                            <option value="400">400</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                        Branch
                    </label>
                </div>
                <div class="md:w-2/3 block text-gray-600 font-bold">
                    <div class="relative">
                        <select name="branch" id="branch" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value="">--Select Branch--</option>
                            <option value="Kasoa">Kasoa</option>
                            <option value="Kanda">Kanda</option>
                            <option value="Spintex">Spintex</option>

                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:flex md:items-center">
                <div class="md:w-1/3"></div>
                <div class="md:w-2/3">
                    <button type="submit" class="shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
                        Generate Report
                    </button>
                </div>
            </div>

            @if (session('error'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: "{{ session('error') }}",
                        showConfirmButton: true
                    });
                </script>
            @endif
        </form>
    </div>
</div>

{{-- Scripts --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Choices.js initialization
        new Choices('#choices-select', {
            removeItemButton: true,
            searchEnabled: true,
            searchPlaceholderValue: 'Search for a course...'
        });

        new Choices('#choices-select2', {
            removeItemButton: true,
            searchEnabled: true,
            searchPlaceholderValue: 'Search for a diploma...'
        });

        // Show/hide logic
        const semesterSelect = document.querySelector('#student_category');
        const academicWrapper = document.getElementById('academic-course-wrapper');
        const professionalWrapper = document.getElementById('professional-course-wrapper');

        function toggleCourseFields() {
            const selected = semesterSelect.value;
            academicWrapper.style.display = (selected === 'Academic') ? 'flex' : 'none';
            professionalWrapper.style.display = (selected === 'Professional') ? 'flex' : 'none';
        }

        semesterSelect.addEventListener('change', toggleCourseFields);

        // Trigger once in case a value is pre-selected (e.g., from validation errors)
        toggleCourseFields();
    });
</script>
@endsection
