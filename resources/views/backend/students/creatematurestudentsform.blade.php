@extends('layouts.app') 

@section('content')
<div class="roles">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-gray-700 uppercase font-bold">Create Mature Student</h2>
        </div>
        <div class="flex flex-wrap items-center">
            <a href="{{ route('mature.index') }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
                <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="long-arrow-alt-left" class="svg-inline--fa fa-long-arrow-alt-left fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z"></path></svg>
                <span class="ml-2 text-xs font-semibold">Back</span>
            </a>
        </div>
    </div>

    <div class="table w-full mt-8 bg-white rounded">
        <form action="{{ route('store.maturestudent') }} " method="POST" class="w-full max-w-xl px-6 py-12" enctype="multipart/form-data" target="_blank">
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

            

            <!-- Other Fields (Name, Email, etc.) -->
            <!-- Add other fields here as needed -->
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                        Name
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input name="name" name="name" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text"  placeholder="Enter name..." required>
                    @error('name')
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
                    <input name="phone" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="number" required>
                    @error('phone')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
                            Interested Course
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <div class="md:w-2/3">
                            <select name="course_id" class="form-select select2-dropdown" id="choices-select">
                                <option value="">-- Select Program --</option>
                                @foreach($grades as $grade)
                                    <option value="{{ $grade->id }}">{{ $grade->course_name }}</option>
                                @endforeach
                               
                            </select>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const choices = new Choices('#choices-select', {
                                removeItemButton: true,
                                searchEnabled: true,
                                searchPlaceholderValue: 'Search for a course...'
                            });
                        });
                    </script>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                        Currency
                    </label>
                </div>
                <div class="md:w-2/3 block text-gray-600 font-bold">
                    <div class="relative">
                        <select name="currency" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                            <option value="">--Select currency --</option>
                            <option value="Ghana Cedi">Ghana Cedi</option>
                            <option value="Dollar">Dollar</option>                                
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
                        Amount Paid
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input name="amount_paid" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="number"  placeholder="Enter amount" required>
                    @error('amount_paid')
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
                            <input name="gender" class="mr-2 leading-tight" type="radio" value="Male">
                            <span class="text-sm">Male</span>
                        </label>
                        <label class="ml-4 block text-gray-500 font-bold">
                            <input name="gender" class="mr-2 leading-tight" type="radio" value="Female">
                            <span class="text-sm">Female</span>
                        </label>
                    </div>
                    @error('gender')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <!-- <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
                            Interested Course
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <div class="md:w-2/3">
                            <select name="course" class="form-select select2-dropdown" id="choices-select">
                                <option value="">-- Select Program --</option>
                                @foreach($grades as $grade)
                                    <option value="{{ $grade->id }}">{{ $grade->course_name }}</option>
                                @endforeach
                               
                            </select>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const choices = new Choices('#choices-select', {
                                removeItemButton: true,
                                searchEnabled: true,
                                searchPlaceholderValue: 'Search for a course...'
                            });
                        });
                    </script>
            </div> -->
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
                    <input name="date_of_birth" id="datepicker-sc" autocomplete="off" 
                        class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" 
                        type="text">
                    @error('dateofbirth')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>
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


@endpush

