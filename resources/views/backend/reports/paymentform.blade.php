@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-6">
    <h1 class="text-2xl font-bold text-gray-700">Payments Reports</h1>

    <!-- Report Generation Form -->
<div class="mt-8 p-6 bg-white rounded-lg shadow">
    <h2 class="text-xl font-bold text-gray-700 mb-4">Generate Reports</h2>
    <form action="{{route('payment.report')}} " method="GET" class="space-y-4">
        <!-- Date Range -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="current_date" class="block text-sm font-medium text-gray-700">Current Date (Optional)</label>
                <input 
                    type="date" 
                    name="current_date" 
                    id="current_date" 
                    value="{{ request('current_date') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                >
            </div>            
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                <input 
                    type="date" 
                    name="start_date" 
                    id="start_date" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                <input 
                    type="date" 
                    name="end_date" 
                    id="end_date" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
            {{-- <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                        Student Index Number
                    </label>
                </div>
                <div class="md:w-2/3 block text-gray-600 font-bold">
                    <select class="bebelino" id="choices-select" name="student_index_number">
                        <option value="">--Type Index Number--</option>
                            @foreach ($details as $detail)
                                <option value={{ $detail->index_number }}>{{ $detail->index_number }}</option>
                            @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div> --}}
        </div>
        <!-- Submit Button -->
        <div>
            <button 
                type="submit" 
                class="my-2 px-6 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
            >
                Generate Report
            </button>
        </div>
    </form>
    {{-- <script text="text/javascript">
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.bebelino').select2({
                placeholder: 'Select an option',
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const choices = new Choices('#bebelino', {
                removeItemButton: true,
            });
        });
    </script> --}}
</div>
</div>
@endsection


    <!-- Search Form -->
    {{-- <form action="{{ route('student.index')}}" method="GET" class="flex items-center mt-4 space-x-4">
        <input 
            type="text" 
            name="search" 
            placeholder="Search Student" 
            value="{{ request('search') }}"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
        >
        <button 
            type="submit" 
            class="px-4 py-2 m-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
        >
            Search
        </button>
    </form> --}}
    
    <!-- Students Table -->
    {{-- <div class="mt-6 bg-white rounded-lg shadow">
        <table class="w-full table-auto">
            <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">Course/Diploma</th>
                    <th class="py-3 px-6 text-left">Index Number</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse ($students as $student)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">{{ $student->user->name }}</td>
                    <td class="py-3 px-6 text-left">{{ $student->user->email }}</td>
                    <td class="py-3 px-6 text-left">{{ $student->course->course_name ?? $student->diploma->name ?? 'N/A' }}</td>
                    <td class="py-3 px-6 text-left">{{ $student->index_number }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-3 px-6 text-center text-gray-500">No students found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div> --}}

    <!-- Pagination -->
    {{-- <div class="mt-8">
        {{ $students->links() }}
    </div> --}}
