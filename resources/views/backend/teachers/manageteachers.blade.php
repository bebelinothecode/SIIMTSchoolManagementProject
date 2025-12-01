@extends('layouts.app')

@section('content')
    <div class="roles">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">Manage Teachers</h2>
            </div>
            <div class="flex flex-wrap items-center">
                <a href="{{ url()->previous() }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
                    <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="long-arrow-alt-left" class="svg-inline--fa fa-long-arrow-alt-left fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path fill="currentColor" d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z"></path>
                    </svg>
                    <span class="ml-2 text-xs font-semibold">Back</span>
                </a>
            </div>
        </div>

        <div class="table w-full mt-8 bg-white rounded">
            <form action="{{ route('store.teacher.sessions') }}" method="POST" class="w-full max-w-xl px-6 py-12" enctype="multipart/form-data">
                @csrf

                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
                            Teacher's Name
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <div class="md:w-2/3">
                            <select name="teacher_id" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="teacher_id" required>
                                <option value="">-- Select Teacher --</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('category')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
                            Subject Name
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <div class="md:w-2/3">
                            <select name="subject_id" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="subject_id" required>
                                <option value="">-- Select Subject --</option>
                            </select>
                        </div>
                        @error('category')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="month">
                            Number of Sessions 
                        </label>
                    </div>
                    <input type="number" id="sessions_per_month" name="sessions_per_month" class="md:w-2/3 bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" placeholder="Enter number of sessions" required>
                    @error('sessions_per_month')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                    @enderror
                </div>

                 <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="month">
                            Remaining Sessions
                        </label>
                    </div>
                    <input type="number" id="remaining_sessions" name="remaining_sessions" class="md:w-2/3 bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" placeholder="Remaining sessions" required>
                    @error('remaining_sessions')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                    @enderror
                </div>
                <div class="md:flex md:items-center">
                    <div class="md:w-1/3"></div>
                    <div class="md:w-2/3">
                        <button class="shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">
                            Save
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

            @if (session('error'))
                <script>
                    Swal.fire({
                        title: 'Opps!',
                        text: '{{ session('error') }}',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                </script>
            @endif
        </div>
    </div>

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            .select2-container--default .select2-selection--single,
            .select2-container--default .select2-selection--multiple {
                border-radius: .375rem;
                border-color: #d1d5db;
                background-color: #f9fafb;
                padding: .5rem .75rem;
                height: auto;
            }
            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 100%;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#teacher_id').select2({
                    placeholder: '-- Select Teacher --',
                    allowClear: true,
                    width: '100%'
                });

                $('#subject_id').select2({
                    placeholder: '-- Select Subject --',
                    allowClear: true,
                    width: '100%'
                });

                $('#teacher_id').on('change', function() {
                    var teacherId = $(this).val();
                    if (teacherId) {
                        $.ajax({
                            url: '/teacher-attendance/teacher-subjects/' + teacherId,
                            type: 'GET',
                            success: function(data) {
                                $('#subject_id').empty().append('<option value="">-- Select Subject --</option>');
                                $.each(data, function(index, item) {
                                    $('#subject_id').append('<option value="' + item.subject_id + '">' + item.subject.name + '</option>');
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error('Error fetching teacher subjects:', error);
                            }
                        });
                    } else {
                        $('#subject_id').empty().append('<option value="">-- Select Subject --</option>');
                    }
                    $('#sessions_per_month').val('');
                    $('#remaining_sessions').val('');
                });

                $('#subject_id').on('change', function() {
                    var teacherId = $('#teacher_id').val();
                    var subjectId = $(this).val();
                    if (teacherId && subjectId) {
                        $.ajax({
                            url: '/get-teacher-sessions/' + teacherId + "/" + subjectId,
                            type: 'GET',
                            success: function(data) {
                                $('#sessions_per_month').val(data.total_sessions);
                                $('#remaining_sessions').val(data.remaining_sessions);
                            },
                            error: function(xhr, status, error) {
                                console.error('Error fetching teacher sessions:', error);
                            }
                        });
                    } else {
                        $('#sessions_per_month').val('');
                        $('#remaining_sessions').val('');
                    }
                });
            });
        </script>
    @endpush
@endsection