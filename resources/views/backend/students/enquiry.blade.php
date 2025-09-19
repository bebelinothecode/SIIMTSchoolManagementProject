@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-6">
    <h1 class="text-2xl font-bold text-gray-700">Students Enquiry</h1>

    <div class="flex justify-between items-center mt-6">
        <a href="{{ route('enquiry.form') }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
            <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" class="svg-inline--fa fa-plus fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg>
            <span class="ml-2 text-xs font-semibold">Add Student Enquiry</span>
        </a>

        <!-- Sorting Dropdown -->
        <form action=" " method="GET" class="flex items-center">
            <label for="sort" class="text-sm text-gray-600 mr-2">Sort by:</label>
            <select name="sort" id="sort" onchange="this.form.submit()" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 rounded">
                <option value="">All</option>
                <option value="Academic" {{ request('sort') === 'Academic' ? 'selected' : '' }}>Academic</option>
                <option value="Professional" {{ request('sort') === 'Professional' ? 'selected' : '' }}>Professional</option>
            </select>
        </form>
    </div>

    <form action="{{ route('student.enquires') }}" method="GET" class="flex items-center mt-4 space-x-4">
        <input 
            type="text" 
            name="search" 
            placeholder="Search..." 
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

    
    <!-- Enquiry Table -->
    <div class="mt-6 bg-white rounded-lg shadow">
        <table class="w-full table-auto">
            <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-left">Telephone</th>
                    <th class="py-2 px-4 text-left">Type of Course (Academic or Professional)</th>                    
                    <th class="py-3 px-6 text-left">Interested Course</th>
                    <th class="py-3 px-6 text-left">Expected Start Date</th>
                    <th class="py-3 px-6 text-left">Bought Forms</th>
                    <th class="py-3 px-6 text-left">Currency</th>
                    <th class="py-3 px-6 text-left">Amount</th>
                    <th class="py-3 px-6 text-left">Branch</th>
                    <th class="py-3 px-6 text-left">Created On</th>
                    <th class="py-3 px-6 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach ($enquiries as $enquiry)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="border border-gray-200 px-4 py-2">{{ $enquiry->name }}</td>
                    <td class="border border-gray-200 px-4 py-2">{{ $enquiry->telephone_number }}</td>
                    <td class="border border-gray-200 px-2 py-2">{{ $enquiry->type_of_course ?? "N/A" }}</td>
                    <td class="border border-gray-200 px-4 py-2">{{ $enquiry->course->course_name ?? $enquiry->diploma->name ?? $enquiry->interested_course ?? "N/A" }}</td>
                    <td class="border border-gray-200 px-4 py-2">{{ \Carbon\Carbon::parse($enquiry->expected_start_date)->format('M d, Y') }}</td>
                    <td class="border border-gray-200 px-4 py-2">{{ $enquiry->bought_forms }}</td>
                    <td class="border border-gray-200 px-4 py-2">{{ $enquiry->currency }}</td>
                    <td class="border border-gray-200 px-4 py-2">{{ $enquiry->amount }}</td>
                    <td class="border border-gray-200 px-4 py-2">{{ $enquiry->branch ?? "N/A" }}</td>
                    <td class="border border-gray-200 px-4 py-2">{{ \Carbon\Carbon::parse($enquiry->created_at)->format('M d, Y H:i A') }}</td>
                    <td class="py-3 px-6 text-center">
                        @if ($enquiry->bought_forms === 'Yes')
                            <a href="{{ route('print.enquiryreceipt',$enquiry->id) }}" class="ml-4 text-green-600 hover:underline" target="_blank">Print</a>
                        @endif
                        @if ($enquiry->bought_forms === 'No')
                             <a href="{{ route('buy.forms',$enquiry->id) }} " class="ml-4 text-blue-600 hover:underline">Buy Forms</a>
                        @endif
                        @role('Admin|rector')
                        <form action="{{ route('delete.enquiry',$enquiry->id) }} " method="POST" onsubmit="return confirm('Are you sure you want to delete this expense?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="ml-4 text-red-600 hover:underline">Delete</button>
                        </form>
                        @endhasrole
                    </td>
                </tr>
                @endforeach

                @if ($enquiries->isEmpty())
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500">No enquiries found.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

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

    <!-- Pagination -->
    <div class="mt-4">
        {{ $enquiries->appends(request()->query())->links() }}
    </div> 
</div>
@endsection