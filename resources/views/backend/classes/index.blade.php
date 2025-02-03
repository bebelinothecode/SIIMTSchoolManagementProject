{{-- This page is for the subjects within each course --}}

{{-- @extends('layouts.app')

@section('content')
    <div class="roles-permissions">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">Subjects</h2>
            </div>
            <div class="flex flex-wrap items-center">
                <a href="{{ route('classes.create') }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
                    <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" class="svg-inline--fa fa-plus fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg>
                    <span class="ml-2 text-xs font-semibold">Subject</span>
                </a>
            </div>
        </div>
        <div class="mt-8 bg-white rounded border-b-4 border-gray-300">
            <div class="flex flex-wrap items-center uppercase text-sm font-semibold bg-gray-300 text-gray-600 rounded-tl rounded-tr">
                <div class="w-2/12 px-4 py-3">Subject Code</div>
                <div class="w-2/12 px-4 py-3">Subject Name</div>
                <div class="w-2/12 px-4 py-3">level</div> 
                <div class="w-1/12 px-4 py-3">Credit hours</div> 
                <div class="w-1/12 px-4 py-3">Semester</div> 
                <div class="w-2/12 px-4 py-3">Course</div> 
                <div class="w-2/12 px-4 py-3 text-right">Action</div> 
            </div>
            @foreach ($classes as $class)
                <div class="flex flex-wrap items-center text-gray-700 border-t-2 border-l-4 border-r-4 border-gray-300">
                    <div class="w-2/12 px-4 py-3 text-sm font-semibold text-gray-600 tracking-tight">{{ $class->subject_code }}</div>
                    <div class="w-2/12 px-4 py-3 text-sm font-semibold text-gray-600 tracking-tight">{{ $class->subject_name }}</div>
                    <div class="w-2/12 px-4 py-3 text-sm font-semibold text-gray-600 tracking-tight">{{ $class->level }}</div>
                    <div class="w-1/12 px-4 py-3 text-sm font-semibold text-gray-600 tracking-tight">{{ $class->credit_hours }}</div>
                    <div class="w-1/12 px-4 py-3 text-sm font-semibold text-gray-600 tracking-tight">{{ $class->semester }}</div>
                    <div class="w-2/12 px-4 py-3 text-sm font-semibold text-gray-600 tracking-tight">{{ $class->course->course_name }}</div>
                    <div class="w-2/12 flex items-center justify-end px-3">
                        <a href="{{ route('classes.edit',$class->id) }}">
                            <svg class="h-6 w-6 fill-current text-gray-600" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pen-square" class="svg-inline--fa fa-pen-square fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M400 480H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48v352c0 26.5-21.5 48-48 48zM238.1 177.9L102.4 313.6l-6.3 57.1c-.8 7.6 5.6 14.1 13.3 13.3l57.1-6.3L302.2 242c2.3-2.3 2.3-6.1 0-8.5L246.7 178c-2.5-2.4-6.3-2.4-8.6-.1zM345 165.1L314.9 135c-9.4-9.4-24.6-9.4-33.9 0l-23.1 23.1c-2.3 2.3-2.3 6.1 0 8.5l55.5 55.5c2.3 2.3 6.1 2.3 8.5 0L345 199c9.3-9.3 9.3-24.5 0-33.9z"></path></svg>
                        </a>
                        <form action="{{ route('classes.destroy',$class->id) }}" method="POST" class="inline-flex ml-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-gray-600 block p-1 border border-gray-600 rounded-sm">
                                <svg class="h-3 w-3 fill-current text-gray-100" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" class="svg-inline--fa fa-trash fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"></path></svg>
                            </button>
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
                </div>
            @endforeach
        </div>
        <div class="mt-8">
            {{ $classes->links() }}
        </div>
    </div>
@endsection --}}

{{-- @extends('layouts.app')

@section('content')
    <div class="roles-permissions">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">Students</h2>
            </div>
            <form action="{{route('search.students')}} " method="POST" class="flex items-center space-x-2">
                @csrf
                <div class="relative">
                    <input 
                        type="text" 
                        name="index_number" 
                        placeholder="Search Student by Index Number" 
                        value="{{ request('index_number') }}" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required
                    >
                </div>
                <button 
                    type="submit" 
                    class="px-4 py-2 m-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
                >
                    Search
                </button>
            </form>
            <div class="flex flex-wrap items-center">
                <a href="{{ route('student.create') }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
                    <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" class="svg-inline--fa fa-plus fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg>
                    <span class="ml-2 text-xs font-semibold">Student</span>
                </a>
            </div>
        </div>
        <div class="mt-8 bg-white rounded border-b-4 border-gray-300">
            <div class="flex flex-wrap items-center uppercase text-sm font-semibold bg-gray-300 text-gray-600 rounded-tl rounded-tr">
                <div class="w-3/12 px-4 py-3">Name</div>
                <div class="w-3/12 px-4 py-3">Email</div>
                <div class="w-2/12 px-4 py-3">Class</div>
                <div class="w-2/12 px-4 py-3">Student ID</div>
                <div class="w-2/12 px-4 py-3 text-right">Action</div>
            </div>
            @foreach ($students as $student)
                <div class="flex flex-wrap items-center text-gray-700 border-t-2 border-l-4 border-r-4 border-gray-300">
                    <div class="w-3/12 px-4 py-3 text-sm font-semibold text-gray-600 tracking-tight">{{ $student->user->name }}</div>
                    <div class="w-3/12 px-4 py-3 text-sm font-semibold text-gray-600 tracking-tight">{{ $student->user->email }}</div>
                    <div class="w-2/12 px-4 py-3 text-sm font-semibold text-gray-600 tracking-tight">{{ $student->class->class_name ?? '' }}</div>
                    <div class="w-2/12 px-4 py-3 text-sm font-semibold text-gray-600 tracking-tight">{{ $student->index_number }}</div>
                    <div class="w-2/12 flex items-center justify-end px-3">
                        <a href="{{ route('student.show',$student->id) }}" class="ml-1 bg-gray-600 block p-1 border border-gray-600 rounded-sm" title="assign subject">
                            <svg class="h-3 w-3 fill-current text-gray-100" aria-hidden="true" focusable="false" data-prefix="far" data-icon="eye" class="svg-inline--fa fa-eye fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M288 144a110.94 110.94 0 0 0-31.24 5 55.4 55.4 0 0 1 7.24 27 56 56 0 0 1-56 56 55.4 55.4 0 0 1-27-7.24A111.71 111.71 0 1 0 288 144zm284.52 97.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400c-98.65 0-189.09-55-237.93-144C98.91 167 189.34 112 288 112s189.09 55 237.93 144C477.1 345 386.66 400 288 400z"></path></svg>
                        </a>
                        <a href="{{ route('student.edit',$student->id) }}" class="ml-1">
                            <svg class="h-6 w-6 fill-current text-gray-600" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pen-square" class="svg-inline--fa fa-pen-square fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M400 480H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48v352c0 26.5-21.5 48-48 48zM238.1 177.9L102.4 313.6l-6.3 57.1c-.8 7.6 5.6 14.1 13.3 13.3l57.1-6.3L302.2 242c2.3-2.3 2.3-6.1 0-8.5L246.7 178c-2.5-2.4-6.3-2.4-8.6-.1zM345 165.1L314.9 135c-9.4-9.4-24.6-9.4-33.9 0l-23.1 23.1c-2.3 2.3-2.3 6.1 0 8.5l55.5 55.5c2.3 2.3 6.1 2.3 8.5 0L345 199c9.3-9.3 9.3-24.5 0-33.9z"></path></svg>
                        </a>
                        <a href="{{ route('student.destroy', $student->id) }}" data-url="{!! URL::route('student.destroy', $student->id) !!}" class="deletestudent ml-1 bg-gray-600 block p-1 border border-gray-600 rounded-sm">
                            <svg class="h-3 w-3 fill-current text-gray-100" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" class="svg-inline--fa fa-trash fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"></path></svg>
                        </a>
                        <a href="{{route('student.print', $student->id)}}" 
                            target="_blank"
                            class="print-admission-letter ml-1 bg-gray-600 block p-1 border border-gray-600 rounded-sm">
                             <svg class="h-3 w-3 fill-current text-gray-100" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="print" class="svg-inline--fa fa-print fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M448 192H64c-35.35 0-64 28.65-64 64v128c0 35.35 28.65 64 64 64h32v64c0 17.7 14.3 32 32 32h256c17.7 0 32-14.3 32-32v-64h32c35.35 0 64-28.65 64-64V256c0-35.35-28.65-64-64-64zm-64 256H128V352h256v96zM96 64c0-35.35 28.65-64 64-64h192c35.35 0 64 28.65 64 64v64H96V64zM384 0H128C92.65 0 64 28.65 64 64v64h384V64c0-35.35-28.65-64-64-64z"></path></svg>
                         </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-8">
            {{ $students->links() }}
        </div>

        @include('backend.modals.delete',['name' => 'student'])
    </div>
@endsection

@push('scripts')
<script>
    $(function() {
        $( ".deletestudent" ).on( "click", function(event) {
            event.preventDefault();
            $( "#deletemodal" ).toggleClass( "hidden" );
            var url = $(this).attr('data-url');
            $(".remove-record").attr("action", url);
        })        
        
        $( "#deletemodelclose" ).on( "click", function(event) {
            event.preventDefault();
            $( "#deletemodal" ).toggleClass( "hidden" );
        })
    })
</script>
@endpush --}}

@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-6">
    <h1 class="text-2xl font-bold text-gray-700">Subjects</h1>

    <div class="flex flex-wrap items-center">
        <a href="{{ route('classes.create') }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
            <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" class="svg-inline--fa fa-plus fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg>
            <span class="ml-2 text-xs font-semibold">Subject</span>
        </a>
    </div>

    <!-- Search Form -->
    <form action="{{ route('classes.index')}}" method="GET" class="flex items-center mt-4 space-x-4">
        <input 
            type="text" 
            name="search" 
            placeholder="Search Subject by Example: semester=1 or subject_name=Twi and subject_code=CPEN112" 
            value="{{ request('search') }}"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
        >
        <button 
            type="submit" 
            class="px-4 py-2 m-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
        >
            Search
        </button>
    </form>
    
    <!-- Students Table -->
    <div class="mt-6 bg-white rounded-lg shadow">
        <table class="w-full table-auto">
            <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">Subject Code</th>
                    <th class="py-3 px-6 text-left">Subject Name</th>
                    <th class="py-3 px-6 text-left">Level</th>
                    <th class="py-3 px-6 text-left">Credit Hours</th>
                    <th class="py-3 px-6 text-center">Semester</th>
                    {{-- <th class="py-3 px-6 text-center">Course</3th> --}}
                    <th class="py-3 px-6 text-center">Action</th>


                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse ($classes as $class)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $class->subject_code }}</td>
                    <td class="py-3 px-6 text-left">{{ $class->subject_name }}</td>
                    <td class="py-3 px-6 text-left">{{ $class->level ?? 'N/A' }}</td>
                    <td class="py-3 px-6 text-left">{{ $class->credit_hours }}</td>
                    <td class="py-3 px-6 text-left">{{ $class->semester }}</td>
                    {{-- <td class="py-3 px-6 text-left">{{ $class->course->course_name }}</td> --}}

                    <td class="py-3 px-6 text-center">
                        {{-- <a href="{{ route('student.show', $student->id) }}" class="text-blue-600 hover:underline">View</a> --}}
                        <a href="{{ route('classes.edit',$class->id) }}" class="ml-4 text-green-600 hover:underline">Edit</a>
                        <form action="{{ route('classes.destroy',$class->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="ml-4 text-red-600 hover:underline">Delete</button>
                        </form>
                        {{-- <a href="{{route('student.print', $student->id)}}" 
                            target="_blank"
                            class="ml-4 text-green-600 hover:underline">
                            Print Admission Letter
                        </a> --}}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-3 px-6 text-center text-gray-500">No subjects found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    {{-- <div class="mt-6">
        {{ $students->appends(request()->input())->links() }}
    </div> --}}
    <div class="mt-8">
        {{ $classes->links() }}
    </div>
</div>
@endsection
