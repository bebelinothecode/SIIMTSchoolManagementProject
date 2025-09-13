@extends('layouts.app')

@section('content')
    <div class="roles">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">Enquiry Reports</h2>
            </div>
        </div>
        <div class="table w-full mt-8 bg-white rounded">
            <form action="{{ route('payment.report') }}" method="GET" class="w-full max-w-xl px-6 py-12" target="_blank" onsubmit="return validateForm()">
                <!-- No CSRF needed for GET -->

                <!-- Academic/Professional -->
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Academic/Professional
                        </label>
                    </div>
                    <div class="md:w-2/3 block text-gray-600 font-bold">
                        <select name="aca_prof" class="block m-2 appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="aca_prof">
                            <option value="">--Select Category--</option>
                            <option value="Academic">Academic</option>
                            <option value="Professional">Professional</option>
                        </select>
                    </div>
                </div>

                <!-- Academic courses dropdown -->
                <div id="academic_courses" class="md:flex md:items-center mb-6 hidden">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Academic Course
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <select name="academic_course" class="block m-2 appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value="">--Select Academic Course--</option>
                            <option value="BSc IT">BSc IT</option>
                            <option value="BSc Accounting">BSc Accounting</option>
                            <option value="BSc Marketing">BSc Marketing</option>
                        </select>
                    </div>
                </div>

                <!-- Professional courses dropdown -->
                <div id="professional_courses" class="md:flex md:items-center mb-6 hidden">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Professional Course
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <select name="professional_course" class="block m-2 appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value="">--Select Professional Course--</option>
                            <option value="ACCA">ACCA</option>
                            <option value="CIM">CIM</option>
                            <option value="CIPS">CIPS</option>
                        </select>
                    </div>
                </div>

                <!-- Current Date -->
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="current_date">
                            Current Date
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="current_date" id="current_date" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="date" value="{{ old('current_date') }}">
                        @error('current_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Expected Date -->
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="start_date">
                            Expected Date
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="start_date" id="start_date" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="date" value="{{ old('start_date') }}">
                        @error('start_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Branch -->
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Branch
                        </label>
                    </div>
                    <div class="md:w-2/3 block text-gray-600 font-bold">
                        <select name="branch" class="block m-2 appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="branch">
                            <option value="">--Select Branch--</option>
                            <option value="Kasoa">Kasoa</option>
                            <option value="Kanda">Kanda</option>
                            <option value="Spintex">Spintex</option>
                        </select>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="md:flex md:items-center">
                    <div class="md:w-1/3"></div>
                    <div class="md:w-2/3 space-x-4">
                        <button type="submit" class="shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
                            Generate Report
                        </button>
                        <button type="reset" class="shadow bg-gray-500 hover:bg-gray-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
                            Reset
                        </button>
                    </div>
                </div>
            </form>

            @if(session('error'))
                <script>
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: '{{ session('error') }}',
                    });
                </script>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Toggle Academic/Professional dropdowns
    document.getElementById('aca_prof').addEventListener('change', function () {
        const selectedMethod = this.value;

        document.getElementById('academic_courses').classList.add('hidden');
        document.getElementById('professional_courses').classList.add('hidden');

        if (selectedMethod === 'Academic') {
            document.getElementById('academic_courses').classList.remove('hidden');
        } else if (selectedMethod === 'Professional') {
            document.getElementById('professional_courses').classList.remove('hidden');
        }
    });
});

// Simple client-side validation
function validateForm() {
    // const acaProf = document.getElementById('aca_prof').value;
    // if (!acaProf) {
    //     alert("Please select Academic/Professional before submitting.");
    //     return false;
    // }
    // return true;
}
</script>
@endsection
