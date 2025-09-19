@extends('layouts.app')

@section('content')
    <div class="roles">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">Enquiry Form</h2>
            </div>
            <div class="flex flex-wrap items-center">
                <a href="{{ route('student.enquires') }}" 
                   class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
                    <svg class="w-3 h-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path fill="currentColor"
                            d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z">
                        </path>
                    </svg>
                    <span class="ml-2 text-xs font-semibold">Back</span>
                </a>
            </div>
        </div>

        <div class="table w-full mt-8 bg-white rounded">
            <form action="{{ route('store.enquiry') }}" method="POST" 
                  class="w-full max-w-xl px-6 py-12" enctype="multipart/form-data" target="_blank">
                @csrf

                {{-- Name --}}
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                             Name
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="name" 
                               class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" 
                               type="text" value="{{ old('name') }}">
                        @error('name')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Telephone --}}
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Telephone Number
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="telephone_number" 
                               class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" 
                               type="phone_number" value="{{ old('telephone_number') }}">
                        @error('phone_number')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Type of Course --}}
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Type of Course
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <select name="type_of_course" id="type_of_course"
                                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                            <option value="">-- Select type of course --</option>
                            <option value="Academic">Academic</option>
                            <option value="Professional">Professional</option>
                        </select>
                        @error('type_of_course')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Bought Forms --}}
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Bought Forms?
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <select name="bought_forms" id="bought_forms"
                                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                            <option value="">-- Select answer --</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                        @error('bought_forms')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Academic Fields --}}
                <div class="hidden" id="academicfields">
                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                                Interested Course (Academic)
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <select name="course_id" id="academic-select" class="form-select">
                                <option value="">-- Select Course --</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Professional Fields --}}
                <div class="hidden" id="professionalfields">
                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                                Interested Course (Professional)
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <select name="diploma_id" id="professional-select" class="form-select">
                                <option value="">-- Select Course --</option>
                                @foreach($diplomas as $diploma)
                                    <option value="{{ $diploma->id }}">{{ $diploma->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Currency + Amount --}}
                <div class="hidden" id="amount_paid_div">
                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                                Currency
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <select name="currency" id="currency"
                                    class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="">-- Select currency --</option>
                                <option value="Dollar">Dollar</option>
                                <option value="Ghana Cedi">Ghana Cedi</option>
                            </select>
                            @error('currency')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                                Amount Paid
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <input name="amount_paid" 
                                   class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" 
                                   type="number">
                            @error('amount_paid')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Expected Start Date --}}
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Expected Start Date
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="expected_start_date" type="date" value="{{ old('expected_start_date') }}"
                               class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500">
                        @error('expected_start_date')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Branch --}}
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Branch
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <select name="branch" id="branch"
                                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value="">-- Select Branch --</option>
                            <option value="Kanda">Kanda</option>
                            <option value="Kasoa">Kasoa</option>
                            <option value="Spintex">Spintex</option>
                        </select>
                        @error('branch')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Submit --}}
                <div class="md:flex md:items-center">
                    <div class="md:w-1/3"></div>
                    <div class="md:w-2/3">
                        <button type="submit"
                                class="shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
                            Save Enquiry
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Success alert --}}
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

        {{-- Toggle Scripts --}}
        <script>
            // Bought forms -> show/hide amount
            document.getElementById('bought_forms').addEventListener('change', function () {
                const amountDiv = document.getElementById('amount_paid_div');
                if (this.value === 'Yes') {
                    amountDiv.classList.remove('hidden');
                } else {
                    amountDiv.classList.add('hidden');
                }
            });

            // Type of course -> show academic/professional
            document.getElementById('type_of_course').addEventListener('change', function () {
                const academicFields = document.getElementById('academicfields');
                const professionalFields = document.getElementById('professionalfields');

                academicFields.classList.add('hidden');
                professionalFields.classList.add('hidden');

                if (this.value === 'Academic') {
                    academicFields.classList.remove('hidden');
                } else if (this.value === 'Professional') {
                    professionalFields.classList.remove('hidden');
                }
            });

            // Choices.js for both selects
            document.addEventListener('DOMContentLoaded', function () {
                new Choices('#academic-select', {
                    removeItemButton: true,
                    searchEnabled: true,
                    searchPlaceholderValue: 'Search for a course...'
                });
                new Choices('#professional-select', {
                    removeItemButton: true,
                    searchEnabled: true,
                    searchPlaceholderValue: 'Search for a course...'
                });
            });
        </script>
    </div>
@endsection
