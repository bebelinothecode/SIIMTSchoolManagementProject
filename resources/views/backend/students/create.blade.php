@extends('layouts.app')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="roles">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-gray-700 uppercase font-bold">Create Student</h2>
        </div>
        <div class="flex flex-wrap items-center">
            <a href="{{ route('student.index') }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
                <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="long-arrow-alt-left" class="svg-inline--fa fa-long-arrow-alt-left fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z"></path></svg>
                <span class="ml-2 text-xs font-semibold">Back</span>
            </a>
        </div>
    </div>

    <div class="table w-full mt-8 bg-white rounded">
        <form action="{{ route('student.store') }}" method="POST" class="w-full max-w-xl px-6 py-12" enctype="multipart/form-data">
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                        Branch
                    </label>
                </div>
                <div class="md:w-2/3">
                    <select name="branch" id="branch" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                        <option value="">--Select Branch--</option>
                        <option value="Spintex">Spintex</option>
                        <option value="Kanda">Kanda</option>
                        <option value="Kasoa">Kasoa</option>
                    </select>
                </div>
            </div>

            <!-- Student Category Field -->
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                        Student Category
                    </label>
                </div>
                <div class="md:w-2/3">
                    <select name="student_category" id="student_category" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                        <option value="">--Select Student Category--</option>
                        <option value="Professional">Professional</option>
                        <option value="Academic">Academic</option>
                    </select>
                </div>
            </div>

            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                        Student Type
                    </label>
                </div>
                <div class="md:w-2/3">
                    <select name="student_type" id="student_type" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                        <option value="">--Select Student Type--</option>
                        <option value="Local">Local</option>
                        <option value="Foreign">Foreign</option>
                    </select>
                </div>
            </div>

            <!-- Conditional Fields (Hidden by Default) -->
            <div id="conditionalFields" class="hidden">
                <!-- Course Field -->
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Course Professional
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <select name="course_id_prof" id="course_id" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value="">--Select Course--</option>
                            @foreach ($diplomas as $diploma)
                                <option value="{{ $diploma->id }}" data-currency="{{ $diploma->currency }}" data-amount="{{ $diploma->fees }}" data-duration="{{ $diploma->duration }}">
                                    {{$diploma->code}}-{{ $diploma->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Currency Field -->
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Currency
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input id="currency" name="currency_prof" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" readonly>
                    </div>
                </div>

                <!-- Amount Field -->
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Amount
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input id="amount" name="fees_prof" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="number" readonly>
                    </div>
                </div>

                <!-- Duration Field -->
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Duration
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input id="duration" name="duration_prof" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" readonly>
                    </div>
                </div>
            </div>

            <div id="conditionalFieldsProfessional" class="hidden">
                <!-- Existing Professional Fields Here -->
                <!-- Include Course, Currency, Amount, and Duration Fields -->
            </div>

            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                        Scholarship
                    </label>
                </div>
                <div class="md:w-2/3">
                    <div class="flex flex-row items-center">
                        <label class="block text-gray-500 font-bold">
                            <input name="scholarship" id="scholarship_yes" class="mr-2 leading-tight" type="radio" value="Yes">
                            <span class="text-sm">Yes</span>
                        </label>
                        <label class="ml-4 block text-gray-500 font-bold">
                            <input name="scholarship" id="scholarship_no" class="mr-2 leading-tight" type="radio" value="No">
                            <span class="text-sm">No</span>
                        </label>
                    </div>
                    @error('scholarship')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Conditional Scholarship Amount Field -->
            <div class="md:flex md:items-center mb-6" id="scholarship_amount_field" style="display: none;">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                        Scholarship Amount
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input name="scholarship_amount" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" type="number" placeholder="Enter amount">
                    @error('scholarship_amount')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    $(document).ready(function() {
                        // Show/hide scholarship amount field based on radio button selection
                        $('input[name="scholarship"]').change(function() {
                            if ($('#scholarship_yes').is(':checked')) {
                                $('#scholarship_amount_field').show();
                            } else {
                                $('#scholarship_amount_field').hide();
                            }
                        });
                
                        // Trigger change event on page load to set initial state
                        $('input[name="scholarship"]').trigger('change');
                    });
                </script>

            </div>

            <!-- Conditional Fields for Academic -->
            <div id="conditionalFieldsAcademic" class="hidden">
                {{-- Course --}}
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Course Academic
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <select name="course_id" id="course_id_aca" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value="">--Select Course--</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}" data-currency="{{ $course->currency }}" data-amount="{{ $course->fees }}">
                                   {{$course->course_code}} - {{ $course->course_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- Fees Field -->
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Fees
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input id="fees" name="fees" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="number" readonly>
                    </div>
                </div>

                <!-- Currency Field -->
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Currency
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input id="currency_academic" name="currency" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" readonly>
                    </div>
                </div>

                <!-- Level Field -->
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label for="level" class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Level
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <select 
                            class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" 
                            id="level" 
                            name="level" 
                            {{-- required --}}
                            aria-label="Select level"
                        >
                            <option value="">--Select level--</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                            <option value="300">300</option>
                            <option value="400">400</option>
                        </select>
                    </div>
                </div>

                <!-- Semester Field -->
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Semester
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <select class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" id="session" name="session">
                            <option value="">--Select semester--</option>
                            <option value="1">1</option>
                            <option value="2">2</option>                                
                        </select>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Session
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <select class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" id="academicyear" name="academicyear">
                            <option value="">--Select academic year--</option>
                            @foreach ($years as $year)
                                <option value="{{ $year->startyear }} - {{$year->endyear}}">
                                    {{ $year->startyear }} - {{$year->endyear}}
                                </option>
                            @endforeach                              
                        </select>
                    </div>
                </div>
            </div>


            <!-- Other Fields (Name, Email, etc.) -->
            <!-- Add other fields here as needed -->
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                        Name
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input name="name" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" value="{{ old('name') }}" placeholder="Enter name" style="text-transform: uppercase;" required>
                    @error('name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                        Email
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input name="email" name="email" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="email" value="{{ old('email') }}" placeholder="Enter email" required>
                    @error('email')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                        Password
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input name="password" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="password" required>
                    @error('password')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                        Phone
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input name="phone" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" value="{{ old('phone') }}" required>
                    @error('phone')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                        Current Address
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input name="current_address" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" value="{{ old('email') }}" placeholder="Enter address" >
                    @error('current_address')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                        Gender
                    </label>
                </div>
                <div class="md:w-2/3">
                    <div class="flex flex-row items-center">
                        <label class="block text-gray-500 font-bold">
                            <input name="gender" class="mr-2 leading-tight" type="radio" value="male">
                            <span class="text-sm">Male</span>
                        </label>
                        <label class="ml-4 block text-gray-500 font-bold">
                            <input name="gender" class="mr-2 leading-tight" type="radio" value="female">
                            <span class="text-sm">Female</span>
                        </label>
                        <label class="ml-4 block text-gray-500 font-bold">
                            <input name="gender" class="mr-2 leading-tight" type="radio" value="other">
                            <span class="text-sm">Other</span>
                        </label>
                    </div>
                    @error('gender')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                        Batch
                    </label>
                </div>
                <div class="md:w-2/3 block text-gray-600 font-bold">
                    <div class="relative">
                        <select name="attendance_time" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                            <option value="">--Select batch--</option>
                            <option value="weekday">Weekday</option>
                            <option value="weekend">Weekend</option>                                
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
            </div>
             <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                        Admission Cycle
                    </label>
                </div>
                <div class="md:w-2/3 block text-gray-600 font-bold">
                    <div class="relative">
                        <select name="admission_cycle" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value="">--Select Cycle--</option>
                            <option value="February">February</option>
                            <option value="August">August</option>                                
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                        Date of Birth
                    </label>
                </div>
                @php
                    // Calculate the date 16 years ago from today
                    $minAllowedDate = now()->subYears(18)->format('Y-m-d');
                @endphp
                <div class="md:w-2/3">
                    <input name="dateofbirth" id="datepicker-sc" autocomplete="off" 
                        class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" 
                        type="text">
                    @error('dateofbirth')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                        Picture :
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input name="profile_picture" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="file">
                </div>
            </div>

            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                        Student Parent's Name
                    </label>
                </div>
                <div class="md:w-2/3 block text-gray-600 font-bold">
                    <div class="relative">
                        <input name="student_parent" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" value="{{ old('permanent_address') }}" required>
                            @error('student_parent')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                    </div>
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                         Parent's Phone Number
                    </label>
                </div>
                <div class="md:w-2/3 block text-gray-600 font-bold">
                    <div class="relative">
                        <input name="parent_phonenumber" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="number" value="{{ old('permanent_address') }}" required>
                            @error('parent_phonenumber')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                    </div>
                </div>
            </div>

         <div class="md:flex md:items-center mb-6">
        <div class="md:w-1/3">
            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                Pay fees now?
            </label>
        </div>
        <div class="md:w-2/3 block text-gray-600 font-bold">
            <div class="relative flex items-center space-x-6">
                <label class="inline-flex items-center">
                    <input type="radio" name="pay_fees_now" value="yes"
                        class="text-blue-600 focus:ring-blue-500 border-gray-300"
                        onclick="toggleFeesSection(true)">
                    <span class="ml-2 text-gray-700">Yes</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="pay_fees_now" value="no"
                        class="text-blue-600 focus:ring-blue-500 border-gray-300"
                        onclick="toggleFeesSection(false)">
                    <span class="ml-2 text-gray-700">No</span>
                </label>
            </div>
            @error('pay_fees_now')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Hidden section for Fees and Balance -->
    <div id="feesSection" class="hidden">
        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3">
                <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                    Amount Paid
                </label>
            </div>
            <div class="md:w-2/3">
                <input name="amount_paid" type="number" id="amount_paid"
                    class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                    placeholder="Enter fees paid here">
                @error('fees')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3">
                <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                    Balance
                </label>
            </div>
            <div class="md:w-2/3">
                <input name="new_student_balance" type="number" id="balance"
                    class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                    placeholder="Enter balance amount">
                @error('balance')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <script>
        function toggleFeesSection(show) {
            const section = document.getElementById('feesSection');
            if (show) {
                section.classList.remove('hidden');
            } else {
                section.classList.add('hidden');
            }
        }
    </script>



            <!-- Submit Button -->
    <div class="md:flex md:items-center">
        <div class="md:w-1/3"></div>
        <div class="md:w-2/3">
            <button type="submit" class="shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
                Create Student
            </button>
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
        @if(session('error'))
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const baseUrl = window.location.origin;

    // Elements (may be null if not present on this page)
    const studentCategory   = document.getElementById('student_category');
    const profCourseSelect  = document.getElementById('course_id');        
    const acaCourseSelect   = document.getElementById('course_id_aca');    
    const conditionalProf   = document.getElementById('conditionalFields'); 
    const conditionalAca    = document.getElementById('conditionalFieldsAcademic'); 
    const profAmountInput   = document.getElementById('amount');          
    const acaFeesInput      = document.getElementById('fees');            
    const amountPaidInput   = document.getElementById('amount_paid');    
    const balanceInput      = document.getElementById('balance');         

    // Helper: safe parse float
    function parseNum(v) {
        const n = parseFloat(String(v || '').replace(/,/g, ''));
        return isNaN(n) ? 0 : n;
    }

    // Update balance based on current fee (either profAmountInput or acaFeesInput) minus amountPaidInput
    function updateBalance() {
        if (!balanceInput) return;

        const profVal = profAmountInput ? parseNum(profAmountInput.value) : 0;
        const acaVal  = acaFeesInput ? parseNum(acaFeesInput.value) : 0;

        // prefer professional amount if > 0 else academic fees
        const feeTotal = profVal > 0 ? profVal : acaVal;

        const paid = amountPaidInput ? parseNum(amountPaidInput.value) : 0;
        let balance = feeTotal - paid;
        if (balance < 0) balance = 0;

        balanceInput.value = balance;
    }

    // Clear helper that accepts an array of element ids (safe)
    function clearFields(fieldIds = []) {
        fieldIds.forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = '';
        });
    }

    // Toggle which course block is visible when student category changes
    function handleCategoryChange() {
        const val = studentCategory ? studentCategory.value : '';
        if (val === 'Professional') {
            if (conditionalProf) conditionalProf.classList.remove('hidden');
            if (conditionalAca) conditionalAca.classList.add('hidden');

            // make professional select required, academic not required
            if (profCourseSelect) profCourseSelect.setAttribute('required', 'required');
            if (acaCourseSelect) acaCourseSelect.removeAttribute('required');

            // if a professional course already selected, trigger change to populate fees
            if (profCourseSelect && profCourseSelect.value) {
                profCourseSelect.dispatchEvent(new Event('change'));
            } else {
                // clear academic fee field if switching
                if (acaFeesInput) acaFeesInput.value = '';
                updateBalance();
            }
        } else if (val === 'Academic') {
            if (conditionalAca) conditionalAca.classList.remove('hidden');
            if (conditionalProf) conditionalProf.classList.add('hidden');

            // make academic select required, professional not required
            if (acaCourseSelect) acaCourseSelect.setAttribute('required', 'required');
            if (profCourseSelect) profCourseSelect.removeAttribute('required');

            // if an academic course already selected, trigger change to populate fees
            if (acaCourseSelect && acaCourseSelect.value) {
                acaCourseSelect.dispatchEvent(new Event('change'));
            } else {
                // clear professional amount if switching
                if (profAmountInput) profAmountInput.value = '';
                updateBalance();
            }
        } else {
            // none selected: hide both blocks
            if (conditionalProf) conditionalProf.classList.add('hidden');
            if (conditionalAca) conditionalAca.classList.add('hidden');
            if (profCourseSelect) profCourseSelect.removeAttribute('required');
            if (acaCourseSelect) acaCourseSelect.removeAttribute('required');
            // clear fees
            if (acaFeesInput) acaFeesInput.value = '';
            if (profAmountInput) profAmountInput.value = '';
            updateBalance();
        }
    }

    // PROFESSIONAL course selection -> fetch diploma details (populates top fees input)
    if (profCourseSelect) {
        profCourseSelect.addEventListener('change', function() {
            const option = this.options[this.selectedIndex];
            // if data attributes exist on option, use them (faster than fetch)
            const dataAmount = option ? option.dataset.amount : null;
            const dataCurrency = option ? option.dataset.currency : null;
            const dataDuration = option ? option.dataset.duration : null;

            if (dataAmount !== undefined && dataAmount !== null) {
                if (profAmountInput) profAmountInput.value = dataAmount;
                if (acaFeesInput) acaFeesInput.value = dataAmount; // keep single #fees updated
                if (document.getElementById('currency')) document.getElementById('currency').value = dataCurrency || '';
                if (document.getElementById('duration')) document.getElementById('duration').value = dataDuration || '';
                updateBalance();
                return;
            }

            // fallback to fetching from server if no data- attributes
            const courseId = this.value;
            if (!courseId) {
                clearFields(['currency','amount','duration']);
                updateBalance();
                return;
            }

            fetch(`${baseUrl}/get/diplomas/${courseId}`)
                .then(response => response.json())
                .then(data => {
                    if (document.getElementById('currency')) document.getElementById('currency').value = data.currency || '';
                    if (profAmountInput) profAmountInput.value = data.amount || '';
                    if (acaFeesInput) acaFeesInput.value = data.amount || '';
                    if (document.getElementById('duration')) document.getElementById('duration').value = data.duration || '';
                    updateBalance();
                })
                .catch(err => {
                    console.error('Error fetching professional course:', err);
                    clearFields(['currency','amount','duration']);
                    updateBalance();
                });
        });
    }

    // ACADEMIC course selection -> populate top fees input
    if (acaCourseSelect) {
        acaCourseSelect.addEventListener('change', function() {
            const option = this.options[this.selectedIndex];
            const dataAmount = option ? option.dataset.amount : null;
            const dataCurrency = option ? option.dataset.currency : null;

            if (dataAmount !== undefined && dataAmount !== null) {
                if (acaFeesInput) acaFeesInput.value = dataAmount;
                if (document.getElementById('currency_academic')) document.getElementById('currency_academic').value = dataCurrency || '';
                updateBalance();
                return;
            }

            const acaID = this.value;
            if (!acaID) {
                clearFields(['currency_academic','fees']);
                updateBalance();
                return;
            }

            fetch(`${baseUrl}/get/academic/${acaID}`)
                .then(response => response.json())
                .then(data => {
                    if (document.getElementById('currency_academic')) document.getElementById('currency_academic').value = data.currency || '';
                    if (acaFeesInput) acaFeesInput.value = data.amount || '';
                    updateBalance();
                })
                .catch(err => {
                    console.error('Error fetching academic course:', err);
                    clearFields(['currency_academic','fees']);
                    updateBalance();
                });
        });
    }

    // Listen to amount_paid input to update balance live
    if (amountPaidInput) {
        amountPaidInput.addEventListener('input', updateBalance);
    }

    // Recalc if fee inputs are manually edited
    if (profAmountInput) profAmountInput.addEventListener('input', updateBalance);
    if (acaFeesInput) acaFeesInput.addEventListener('input', updateBalance);

    // Initialize category on load (in case of old inputs)
    if (studentCategory) {
        studentCategory.addEventListener('change', handleCategoryChange);
        handleCategoryChange();
    } else {
        // If no selector present, still try to initialize fees from selected course
        if (profCourseSelect && profCourseSelect.value) profCourseSelect.dispatchEvent(new Event('change'));
        if (acaCourseSelect && acaCourseSelect.value) acaCourseSelect.dispatchEvent(new Event('change'));
    }

    // Scholarship radio toggling (existing jQuery handler preserved)
    $('input[name="scholarship"]').change(function () {
        if ($('#scholarship_yes').is(':checked')) {
            $('#scholarship_amount_field').show();
        } else {
            $('#scholarship_amount_field').hide();
        }
    }).trigger('change');
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const minDate = new Date();
        minDate.setFullYear(minDate.getFullYear() - 16); // Set the minimum age to 16 years

        // Initialize date picker
        const datepicker = flatpickr("#datepicker-sc", {
            dateFormat: "Y-m-d",
            maxDate: minDate, // Restrict maximum date to 16 years ago
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#course_id').select2({
            placeholder: '--Select Course--',
            allowClear: true,
            width: '100%'
        });
        $('#course_id_aca').select2({
            placeholder: '--Select Course--',
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush
