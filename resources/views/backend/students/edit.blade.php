@extends('layouts.app')

@section('content')
    <div class="roles">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">Edit Student</h2>
            </div>
            <a href="{{ route('student.index') }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded hover:bg-gray-300 transition duration-300">
                <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="long-arrow-alt-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <path fill="currentColor" d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z"></path>
                </svg>
                <span class="ml-2 text-xs font-semibold">Back</span>
            </a>
        </div>

        <div class="table w-full mt-8 bg-white rounded">
            <form action="{{ route('update.student',$student->id) }}" method="POST" class="w-full max-w-4xl px-6 py-8" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Profile Section -->
                <div class="mb-8 border-b pb-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Profile Information</h3>
                    
                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/4">
                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                                Profile Picture
                            </label>
                        </div>
                        <div class="md:w-3/4 flex items-center">
                            <img class="w-20 h-20 sm:w-32 sm:h-32 rounded-full mr-4 border-2 border-gray-200" src="{{ asset('images/profile/' .$student->user->profile_picture) }}" alt="avatar">
                            <input name="profile_picture" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="file">
                        </div>
                    </div>
                    
                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/4">
                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                                Full Name
                            </label>
                        </div>
                        <div class="md:w-3/4">
                            <input name="name" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" value="{{ old('name', $student->user->name) }}">
                            @error('name')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/4">
                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                                Email
                            </label>
                        </div>
                        <div class="md:w-3/4">
                            <input name="email" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="email" value="{{ old('email', $student->user->email) }}">
                            @error('email')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Personal Information Section -->
                <div class="mb-8 border-b pb-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Personal Information</h3>
                    
                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/4">
                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                                Phone Number
                            </label>
                        </div>
                        <div class="md:w-3/4">
                            <input name="phone" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" value="{{ old('phone', $student->phone) }}">
                            @error('phone')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/4">
                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                                Gender
                            </label>
                        </div>
                        <div class="md:w-3/4">
                            <div class="flex flex-row items-center space-x-6">
                                <label class="inline-flex items-center">
                                    <input name="gender" class="form-radio h-5 w-5 text-blue-600" type="radio" value="male" {{ old('gender', $student->gender) == 'male' ? 'checked' : '' }}>
                                    <span class="ml-2 text-gray-700">Male</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input name="gender" class="form-radio h-5 w-5 text-blue-600" type="radio" value="female" {{ old('gender', $student->gender) == 'female' ? 'checked' : '' }}>
                                    <span class="ml-2 text-gray-700">Female</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input name="gender" class="form-radio h-5 w-5 text-blue-600" type="radio" value="other" {{ old('gender', $student->gender) == 'other' ? 'checked' : '' }}>
                                    <span class="ml-2 text-gray-700">Other</span>
                                </label>
                            </div>
                            @error('gender')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/4">
                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                                Date of Birth
                            </label>
                        </div>
                        <div class="md:w-3/4">
                            <input name="dateofbirth" id="datepicker-se" autocomplete="off" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" value="{{ old('dateofbirth', $student->dateofbirth) }}">
                            @error('dateofbirth')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/4">
                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                                Current Address
                            </label>
                        </div>
                        <div class="md:w-3/4">
                            <input name="current_address" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" value="{{ old('current_address', $student->current_address) }}">
                            @error('current_address')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Academic Information Section -->
                <div class="mb-8 border-b pb-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Academic Information</h3>
                    
                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/4">
                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                                Student Category
                            </label>
                        </div>
                        <div class="md:w-3/4">
                            <input type="text" class="bg-gray-100 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" value="{{ ucfirst($student->student_category) }}" disabled>
                        </div>
                    </div>

                    @if ($student->student_category === 'Academic')
                    
                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/4">
                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                                Level
                            </label>
                        </div>
                        <div class="md:w-3/4">
                            <input name="level" id="fees-field" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" value="{{ old('level', $student->level) }}">
                            @error('level')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/4">
                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                                Semester
                            </label>
                        </div>
                        <div class="md:w-3/4">
                            <input name="session" id="fees-field" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" value="{{ old('semester', $student->session) }}">
                            @error('semester')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    @endif

                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/4">
                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                                Currency
                            </label>
                        </div>
                        <div class="md:w-3/4">
                            <input name="currency" id="currency-field" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" value="{{ old('currency', $student->student_category === 'Academic' ? $student->currency : $student->currency_prof) }}" readonly>
                            @error('currency')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/4">
                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                                Fees
                            </label>
                        </div>
                        <div class="md:w-3/4">
                            <input name="fees" id="fees-field" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" value="{{ old('fees', $student->student_category === 'Academic' ? $student->fees : $student->fees_prof) }}" readonly>
                            @error('fees')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/4">
                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                                Balance
                            </label>
                        </div>
                        <div class="md:w-3/4">
                            <input name="balance" id="balance-field" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" value="{{ old('balance', $student->balance) }}">
                            @error('balance')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Parent Information Section -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Parent/Guardian Information</h3>
                    
                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/4">
                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                                Parent/Guardian Phone Number
                            </label>
                        </div>
                        <div class="md:w-3/4">
                            <div class="relative">
                                <input name="parent_phonenumber" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" >
                                <!-- <select name="parent_id" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                    <option value="">--Select Parent/Guardian--</option>
                                    @foreach ($parents as $parent)
                                        <option value="{{ $parent->id }}"
                                            {{ $parent->id == old('parent_id', $student->parent_id) ? 'selected' : '' }}
                                        >
                                            {{ $parent->user->name ?? "" }} ({{ $parent->phone ?? "" }})
                                        </option>
                                    @endforeach
                                </select> -->
                                <!-- <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div> -->
                            </div>

                            
                            @error('parent_id')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Submission -->
                <div class="md:flex md:items-center">
                    <div class="md:w-1/4"></div>
                    <div class="md:w-3/4">
                        <button class="shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-6 rounded transition duration-300" type="submit">
                            Update Student
                        </button>
                        <a href="{{ route('student.index') }}" class="ml-4 bg-gray-500 hover:bg-gray-400 text-white font-bold py-2 px-6 rounded transition duration-300">
                            Cancel
                        </a>
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

@push('scripts')

@endpush





