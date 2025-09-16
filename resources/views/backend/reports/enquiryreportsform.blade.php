@extends('layouts.app')

@section('content')
    <div class="roles">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">Enquiry Reports</h2>
            </div>
            <div class="flex flex-wrap items-center">
                <a href="{{ url()->previous()}}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
                    <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="long-arrow-alt-left" class="svg-inline--fa fa-long-arrow-alt-left fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z"></path></svg>
                    <span class="ml-2 text-xs font-semibold">Back</span>
                </a>
            </div>
        </div>
        
        <div class="table w-full mt-8 bg-white rounded">
            <form action="{{ route('enquiry.report') }} " method="POST" class="w-full max-w-xl px-6 py-12" enctype="multipart/form-data" target="_blank">
                @csrf
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Academic/Professional
                        </label>
                    </div>
                    <div class="md:w-2/3 block text-gray-600 font-bold">
                        <select name="acaProf" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="acaProf" required>
                            <option value="">--Select Academic/Professional--</option>
                            <option value="Professional">Professional</option>
                            <option value="Academic">Academic</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>

                <script>
                    document.getElementById('acaProf').addEventListener('change', function () {
                        const selectedMethod = this.value;
                
                        // Hide all fields initially
                        document.getElementById('professional_fields').classList.add('hidden');
                        document.getElementById('academic_fields').classList.add('hidden');
                
                        // Show fields based on the selected method
                        if (selectedMethod === 'Academic') {
                            document.getElementById('academic_fields').classList.remove('hidden');
                            document.getElementById('professional_fields').classList.add('hidden');
                        } else if (selectedMethod === 'Professional') {
                            document.getElementById('professional_fields').classList.remove('hidden');
                            document.getElementById('academic_fields').classList.add('hidden');
                        } 
                    });
                </script>
                
                <!-- Additional Fields -->
                <div id="professional_fields" class="hidden">
                    <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Diploma:
                        </label>
                    </div>
                    <div class="md:w-2/3 block text-gray-600 font-bold">
                        <select id="choices-select" name="diploma_id">
                            <option value="">--Select Diploma--</option>
                                @foreach ($diplomas as $diploma)
                                    <option value="{{ $diploma->id }}">{{ $diploma->code }} - {{ $diploma->name }}</option>
                                @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                    </div>
                </div>

                <div id="academic_fields" class="hidden">
                    <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Academic:
                        </label>
                    </div>
                    <div class="md:w-2/3 block text-gray-600 font-bold">
                        <select id="choices-select-1" name="course_id">
                            <option value="">--Select Course--</option>
                                @foreach ($grades as $course)
                                    <option value="{{ $course->id }}">{{ $course->course_code }} - {{ $course->course_name }}</option>
                                @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                    </div>

                    <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="start_date">
                            Current Date
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="current_date" id="current_date" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="date" value="{{ old('current_date') }}">
                        @error('current_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                    </div>

                    {{-- <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="start_date">
                            Expected Date
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="expected_date" id="expected_date" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="date" value="{{ old('expected_date') }}">
                        @error('expected_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div> --}}

                 <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Branch
                        </label>
                    </div>
                    <div class="md:w-2/3 block text-gray-600 font-bold">
                        <select name="branch" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="branch" >
                            <option value="">--Select Branch--</option>
                            <option value="Kanda">Kanda</option>
                            <option value="Kasoa">Kasoa</option>
                            <option value="Spintex">Spintex</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                    </div>

                    {{-- <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Branch
                        </label>
                    </div>
                    <div class="md:w-2/3 block text-gray-600 font-bold">
                        <select name="branch" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="level" >
                            <option value="">--Select Branch--</option>
                            <option value="Kasoa">Kasoa</option>
                            <option value="Spintex">Spintex</option>
                            <option value="Kanda">Kanda</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div> --}}
                
                <div class="md:flex md:items-center">
                    <div class="md:w-1/3"></div>
                    <div class="md:w-2/3">
                        <button class="shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit" >
                            Generate Report
                        </button>
                    </div>
                </div>
                @if (session('success'))
                    <script>
                        Swal.fire({
                            title: 'Info',
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
            </form>        
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const choices = new Choices('#choices-select', {
            removeItemButton: true,
            searchEnabled: true,
            searchPlaceholderValue: 'Search for a diploma...'
        });
    });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const choices = new Choices('#choices-select-1', {
            removeItemButton: true,
            searchEnabled: true,
            searchPlaceholderValue: 'Search for a course...'
        });
    });
    </script>

    <script>
        document.getElementById('fees_type').addEventListener('change', function () {
            const selectedMethod = this.value;
            console.log(selectedMethod);
            
            // Hide all fields initially
            document.getElementById('balance_div').classList.add('hidden');
            document.getElementById('amount_id').classList.add('hidden');
            document.getElementById('amount_paid_id').classList.add('hidden')
            // document.getElementById('amount_div').classList.add('hidden');

            if (selectedMethod === 'School Fees') {
                document.getElementById('balance_div').classList.remove('hidden')
                document.getElementById('amount_id').classList.remove('hidden')
            } else {
                document.getElementById('amount_paid_id').classList.remove('hidden')
                document.getElementById('amount_id').classList.add('hidden')
            }
        });
    </script>
@endsection