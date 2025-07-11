@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-6">
    <h1 class="text-2xl font-bold text-gray-700">Students Reports (Professional)</h1>

    <!-- Report Generation Form -->
    <div class="mt-8 p-6 bg-white rounded-lg shadow">
        <form action="{{ route('reports.generate') }}" method="GET" class="space-y-4">
            <!-- Date Range and Professional Courses -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="diploma" class="block text-xl p-2 font-medium text-gray-700">Diploma/Professional Course</label>
                    <select 
                        name="diplomaID" 
                        id="choices-select" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required
                    >
                        <option value="">--Select Diploma/Professional--</option>
                        @foreach ($diplomas as $diploma)
                            <option value="{{ $diploma->id }}">{{ $diploma->code }}-{{ $diploma->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Branch
                        </label>
                    </div>
                    <div class="md:w-2/3 block text-gray-600 font-bold">
                        <select name="branch" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="branch" required>
                            <option value="">--Select Branch--</option>
                            <option value="Kasoa">Kasoa</option>
                            <option value="Kanda">Kanda</option>
                            <option value="Spintex">Spintex</option>
                        </select>
                    </div>
                </div>
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
    </div>
</div>

<!-- Initialize Select2 -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const choices = new Choices('#choices-select', {
            removeItemButton: true,
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#choices-select').select2({
            placeholder: '--Select Diploma/Professional--', // Placeholder text
            allowClear: true, // Allow clearing the selection
            width: '100%' // Set width to 100%
        });
    });
</script>
@endsection