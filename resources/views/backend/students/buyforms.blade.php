@extends('layouts.app')

@section('content')
    <div class="roles">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">Enquiry Form</h2>
            </div>
            <div class="flex flex-wrap items-center">
                <a href="{{ route('student.enquires') }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
                    <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="long-arrow-alt-left" class="svg-inline--fa fa-long-arrow-alt-left fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z"></path></svg>
                    <span class="ml-2 text-xs font-semibold">Back</span>
                </a>
            </div>
        </div>
        <div class="table w-full mt-8 bg-white rounded">
            <form action="{{ route('update.enquiry',$enquiry->id) }}" method="POST" class="w-full max-w-xl px-6 py-12" enctype="multipart/form-data" target="_blank">
                @csrf
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
                             Name
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="name" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" value="{{ old('name', $enquiry->name ?? '') }}">
                        @error('name')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
                            Telephone Number
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="telephone_number" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="number" value="{{ old('name', $enquiry->telephone_number ?? '') }}">
                        @error('telephone_number')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
                            Type of Course
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <div class="md:w-2/3">
                        <select name="type_of_course" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                            <option value="">-- Select type of course --</option>
                            <option value="Academic" {{ old('type_of_course', $enquiry->type_of_course ?? '') == 'Academic' ? 'selected' : '' }}>Academic</option>
                            <option value="Professional" {{ old('type_of_course', $enquiry->type_of_course ?? '') == 'Professional' ? 'selected' : '' }}>Professional</option>
                        </select>
                        </div>
                        @error('type_of_course')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
                            Bought Forms?
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <div class="md:w-2/3">
                            <select name="bought_forms" id="bought_forms" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                                <option value="">-- Select answer --</option>
                                <option value="Yes" {{ old('bought_forms', $enquiry->bought_forms ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ old('bought_forms', $enquiry->bought_forms ?? '') == 'No' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        @error('type_of_course')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="hidden" id="amount_paid_div">

                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
                                Currency
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <div class="md:w-2/3">
                                <select name="currency" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="currency">
                                    <option value="">-- Select currency --</option>
                                    <option value="Dollar">Dollar</option>
                                    <option value="Ghana Cedi">Ghana Cedi</option>
                                </select>
                            </div>
                            @error('currency')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
                                Amount Paid
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <div class="md:w-2/3">
                                <input name="amount_paid" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="number">
                            </div>
                            @error('amount_paid')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
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
                                    @if ($enquiry->type_of_course == 'Professional')
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}">{{$course->code}}-{{ $course->name}}</option>
                                        @endforeach
                                    @endif

                                    @if ($enquiry->type_of_course == 'Academic')
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}">{{$course->course_code}}-{{ $course->course_name}}</option>
                                        @endforeach
                                    @endif
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
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
                            Expected Start Date
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="expected_start_date" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="date" value="{{ old('email') }}">
                        @error('expected_start_date')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="md:flex md:items-center">
                    <div class="md:w-1/3"></div>
                    <div class="md:w-2/3">
                        <button class="shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">
                            Save Enquiry
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
        </div>
        <script>
            document.getElementById('bought_forms').addEventListener('change', function () {
                const selectedMethod = this.value;
                const amountDiv = document.getElementById('amount_paid_div');

                if (selectedMethod === 'Yes') {
                    document.getElementById('amount_paid_div').classList.remove('hidden')
                } else {
                    document.getElementById('amount_paid_div').classList.add('hidden')
                }
            });
        </script>
        <script>
        document.getElementById('enquiry-form').addEventListener('submit', function (e) {
        e.preventDefault();

        const form = this;
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    if (data.redirect_url) {
                        window.open(data.redirect_url, '_blank');
                    } else {
                        location.reload();
                    }
                });
            } else {
                Swal.fire('Error!', 'An error occurred.', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire('Error!', 'An unexpected error occurred.', 'error');
        });
    });
        </script>

    </div>
@endsection