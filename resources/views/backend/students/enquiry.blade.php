@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-6">
    <h1 class="text-2xl font-bold text-gray-700">Students Enquiry</h1>

    <div class="flex flex-wrap items-center">
        <a href="{{ route('enquiry.form') }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
            <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" class="svg-inline--fa fa-plus fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg>
            <span class="ml-2 text-xs font-semibold">Add Student Enquiry</span>
        </a>
    </div>
    
    <!-- Students Table -->
    <div class="mt-6 bg-white rounded-lg shadow">
        <table class="w-full table-auto">
            <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-left">Telephone</th>
                    <th class="py-3 px-6 text-left">Interested Course</th>
                    <th class="py-3 px-6 text-left">Expected Start Date</th>
                    <th class="py-3 px-6 text-left">Created On</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach ($enquiries as $enquiry)
                <tr>
                    {{-- <td class="border border-gray-200 px-4 py-2">{{ $loop->iteration }}</td> --}}
                    <td class="border border-gray-200 px-4 py-2">{{ $enquiry->name }}</td>
                    <td class="border border-gray-200 px-4 py-2">{{ $enquiry->telephone_number }}</td>
                    <td class="border border-gray-200 px-4 py-2">{{ $enquiry->interested_course }}</td>
                    <td class="border border-gray-200 px-4 py-2">{{ $enquiry->expected_start_date }}</td>
                    <td class="border border-gray-200 px-4 py-2">{{ $enquiry->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $enquiries->links() }}
    </div>
</div>
@endsection
