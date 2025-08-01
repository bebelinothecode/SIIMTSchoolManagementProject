@extends('layouts.app')

@section('content')
    <div class="roles-permissions">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">Courses</h2>
            </div>
            @hasanyrole('Admin|rector') 
            <div class="flex flex-wrap items-center">
                <a href="{{ route('subject.create') }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
                    <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" class="svg-inline--fa fa-plus fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg>
                    <span class="ml-2 text-xs font-semibold">Add Course</span>
                </a>
            </div>
            @endhasanyrole 
        </div>
        <div class="mt-6 bg-white rounded-lg shadow">
            <table class="w-full table-auto">
                <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <tr>
                        <th class="py-3 px-6 text-left">Course Code</th>
                        <th class="py-2 px-4 text-left">Course Name</th>
                        <th class="py-3 px-6 text-left">Description</th>
                        <th class="py-3 px-6 text-left">Currency</th>
                        <th class="py-3 px-6 text-left">Fees</th>
                        @hasanyrole('Admin|rector')
                        <th class="py-3 px-6 text-center">Actions</th>
                        @endhasanyrole
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @forelse ($courses as $course)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap">{{ $course->course_code }}</td>
                        <td class="py-2 px-4 text-left">{{ $course->course_name}}</td>
                        <td class="py-2 px-4 text-left">{{ $course->course_description }}</td>
                        <td class="py-2 px-4 text-left">{{ $course->currency }}</td>
                        <td class="py-2 px-4 text-left">{{ $course->fees }}</td>
                        <td class="py-3 px-6 text-center">
                            {{-- @hasanyrole('Admin|rector|frontdesk') --}}
                            {{-- <a href="{{ route('get.assignmentform', $course->id) }}" class="ml-4 text-green-600 hover:underline">Assign Subject</a> --}}
                            @hasrole('Admin|rector')
                            <a href="{{ route('subject.edit', $course->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            <a href="{{ route('course.overviewform', $course->id) }}" class="text-green-600 hover:underline mx-2">Assign Subjects to Course</a>
                            <form action="{{route('subject.destroy', $course->id)}}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-4 text-red-600 hover:underline">Delete Course   </button>
                            </form>
                            @endhasrole
                            {{-- @endhasanyrole --}}
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
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-3 px-6 text-center text-gray-500">No teachers found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    
        <!-- Pagination -->
        <div class="mt-8">
            {{ $courses->links() }}
        </div>

        @include('backend.modals.delete',['name' => 'teacher'])
    </div>
@endsection

@push('scripts')
<script>
    $(function() {
        $(".deletebtn").on("click", function(event) {
            event.preventDefault();
            $("#deletemodal").toggleClass("hidden");
            var url = $(this).attr('data-url');
            $(".remove-record").attr("action", url);
        });
        
        $("#deletemodelclose").on("click", function(event) {
            event.preventDefault();
            $("#deletemodal").toggleClass("hidden");
        });
    });
</script>
@endpush
