@extends('layouts.app')

@section('content')
    <div class="roles">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">Collect Fees</h2>
            </div>
            <div class="flex flex-wrap items-center">
                <a href="{{ route('parents.index') }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
                    <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="long-arrow-alt-left" class="svg-inline--fa fa-long-arrow-alt-left fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z"></path></svg>
                    <span class="ml-2 text-xs font-semibold">Back</span>
                </a>
            </div>
        </div>
        <div class="table w-full mt-8 bg-white rounded">
            <form action="{{ route('fees.collected') }}" method="POST" class="w-full max-w-xl px-6 py-12" enctype="multipart/form-data">
                @csrf
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Student Index Number
                        </label>
                    </div>
                    <div class="md:w-2/3 block text-gray-600 font-bold">
                        <select id="choices-select" name="student_index_number">
                            <option value="">--Type Index Number--</option>
                                @foreach ($details as $detail)
                                    <option value={{ $detail->index_number }}>{{ $detail->index_number }}</option>
                                @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Student Name
                        </label>
                    </div>
                    <div class="md:w-2/3 block text-gray-600 font-bold">
                        <select id="choices-select2" name="student_name">
                            <option value="">--Type Student Name--</option>
                                @foreach ($details as $detail)
                                    <option value={{ $detail->user->name }}>{{ $detail->user->name }}</option>
                                @endforeach
                        </select>                        
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Method of Payment
                        </label>
                    </div>
                    <div class="md:w-2/3 block text-gray-600 font-bold">
                            <select name="method_of_payment" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="method_of_payment" required>
                                <option value="">--Select Method of Payment--</option>
                                <option value="Cash">Cash</option>
                                <option value="Cheque">Cheque</option>
                                <option value="Momo">Momo</option>
                            </select>
                            <script text="text/javascript">
                                // In your Javascript (external .js resource or <script> tag)
                                $(document).ready(function() {
                                    $('.js-example-basic-single').select2({
                                        placeholder: 'Select an option',
                                    });
                                });
                            </script>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Currency
                        </label>
                    </div>
                    <div class="md:w-2/3 block text-gray-600 font-bold">
                        <div class="relative">
                            <select name="currency" id="currency" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"  required>
                                <option value="">--Select Currency--</option>
                                <option value="$">Dollar</option>
                                <option value="GHS">Ghana Cedi</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Additional Fields -->
                <div id="cheque_fields" class="hidden">
                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                                Cheque Number
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <input name="cheque_number" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="number">
                            @error('end_academic_year')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div id="momo_fields" class="hidden">
                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                                Momo Number
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <input name="Momo_number" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="number">
                            @error('end_academic_year')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <script>
                    document.getElementById('method_of_payment').addEventListener('change', function () {
                        const selectedMethod = this.value;
                
                        // Hide all fields initially
                        // document.getElementById('cash_fields').classList.add('hidden');
                        document.getElementById('cheque_fields').classList.add('hidden');
                        document.getElementById('momo_fields').classList.add('hidden');
                
                        // Show fields based on the selected method
                        if (selectedMethod === 'Cash') {
                            document.getElementById('cash_fields').classList.remove('hidden');
                        } else if (selectedMethod === 'Cheque') {
                            document.getElementById('cheque_fields').classList.remove('hidden');
                        } else if (selectedMethod === 'Momo') {
                            document.getElementById('momo_fields').classList.remove('hidden');
                        }
                    });
                </script>                   
                
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="amount">
                            Amount
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="amount" id="amount" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="number"  required>
                        @error('amount')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="balance">
                            Balance
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="balance" id="balance" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="number" readonly>
                        @error('balance')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="md:flex md:items-center">
                    <div class="md:w-1/3"></div>
                    <div class="md:w-2/3">
                        <button class="shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit" target="_blank">
                            Collect Fees
                        </button>
                    </div>
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
                <script>
                    new TomSelect("#select-beast-empty",{
                        allowEmptyOption: true,
                        create: true
                    });
                </script>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const choices = new Choices('#choices-select', {
                            removeItemButton: true,
                        });
                    });
                </script>
                 <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const choices = new Choices('#choices-select2', {
                            removeItemButton: true,
                        });
                    });
                </script>
                <script>
                    document.addEventListener('DOMContentLoaded',() => {
                        const amount = document.getElementById('amount');
                        const balance = document.getElementById('balance');
                        const indexNumber = document.getElementById('choices-select')
                        const feesData = @json($details);

                        function calculateBalance() {
                            const enteredAmount = parseFloat(amount.value) || 0;
                            const selectedIndexNumber = indexNumber.value;

                            const matchingStudent = feesData.find(fee =>
                                fee.index_number === selectedIndexNumber
                            );

                            if (matchingStudent) {
                                let remainingBalance = parseFloat(matchingStudent.balance);

                                // If balance is not available, fall back to fees or fees_prof
                                if (isNaN(remainingBalance) || remainingBalance === 0) {
                                    remainingBalance = parseFloat(matchingStudent.fees) || parseFloat(matchingStudent.fees_prof) || 0.0;
                                }

                                console.log('Remaining Balance:', remainingBalance);

                                let newBalance = remainingBalance - enteredAmount;


                                if (newBalance < 0) {
                                     newBalance = 0;
                                     alert('Payment exceeds the remaining balance. Balance cannot be negative.');
                                }

                                balance.value = newBalance.toFixed(2);
                            } else {
                                balance.value = '0.00';
                            }
                        }
                        indexNumber.addEventListener('change', calculateBalance);
                        amount.addEventListener('input', calculateBalance);
                    });
                </script>
                {{-- <script>
                    $(document).ready(function () {
                        $('#choices-select2').on('change', function () {
                            let indexNumber = $(this).val();
                
                            if (indexNumber) {
                                $.ajax({
                                    url: '{{ route("fees.get-student-name") }}', // Route to fetch student name
                                    type: 'GET',
                                    data: { index_number: indexNumber },
                                    success: function (response) {
                                        if (response.student_category === 'Professional') {
                                            console.log(response)
                                            $('#choices-select2').val(response.name || 'Not Found');
                                            $('#balance').val(response.balance || response.fees_prof || 'Not Found');

                                        } else if (response.student_category === 'Academic') {
                                            $('#choices-select2').val(response.name || 'Not Found');
                                            $('#balance').val(response.balance || response.fees || 'Not Found');
                                        } else {
                                            alert('Student not found.');
                                            $('#balance').val('');
                                            $('choices-select2').val('');
                                        }
                                    },
                                    error: function () {
                                        $('#choices-select2').val('Not Found');
                                        $('#balance').val('Not Found');
                                    }
                                });
                            } else {
                                $('#choices-select2').val('');
                                $('#balance').val('');
                            }
                        });
                    });
                </script> --}}
                <script>
                    $(document).ready(function () {
                        // Function to fetch student data
                        function fetchStudentData(input, isIndexNumber) {
                            if (input) {
                                $.ajax({
                                    url: '{{ route("fees.get-student-name") }}', // Route to fetch student data
                                    type: 'GET',
                                    data: isIndexNumber ? { index_number: input } : { student_name: input },
                                    success: function (response) {
                                        console.log(response)
                                        if (response) {
                                            if (isIndexNumber) {
                                                // If input is index number, populate student name
                                                $('#choices-select2').val(response.name || 'Not Found');
                                            } else {
                                                // If input is student name, populate index number
                                                $('#choices-select').val(response.index_number || 'Not Found');
                                            }
                
                                            // Populate balance based on student category
                                            if (response.student_category === 'Professional') {
                                                $('#balance').val(response.balance || response.fees_prof || 'Not Found');
                                            } else if (response.student_category === 'Academic') {
                                                $('#balance').val(response.balance || response.fees || 'Not Found');
                                            } else {
                                                alert('Student not found.');
                                                $('#balance').val('');
                                            }
                                        } else {
                                            alert('Student not found.');
                                            $('#choices-select2').val('');
                                            $('#choices-select').val('');
                                            $('#balance').val('');
                                        }
                                    },
                                    error: function () {
                                        alert('An error occurred. Please try again.');
                                        $('#choices-select2').val('Not Found');
                                        $('#choices-select').val('Not Found');
                                        $('#balance').val('Not Found');
                                    }
                                });
                            } else {
                                // Clear fields if input is empty
                                $('#choices-select2').val('');
                                $('#choices-select').val('');
                                $('#balance').val('');
                            }
                        }
                
                        // Event listener for index number input
                        $('#choices-select').on('input', function () {
                            let indexNumber = $(this).val();
                            fetchStudentData(indexNumber, true);
                        });
                
                        // Event listener for student name input
                        $('#choices-select2').on('input', function () {
                            let studentName = $(this).val();
                            fetchStudentData(studentName, false);
                        });
                    });
                </script>
            </form>        
        </div>
    </div>
@endsection

