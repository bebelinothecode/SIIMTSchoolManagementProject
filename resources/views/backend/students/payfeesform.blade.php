@extends('layouts.app')

@section('content')
    <div class="roles">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">Collect Fees</h2>
            </div>
            <div class="flex flex-wrap items-center">
                <a href="{{ url()->previous()}}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
                    <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="long-arrow-alt-left" class="svg-inline--fa fa-long-arrow-alt-left fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z"></path></svg>
                    <span class="ml-2 text-xs font-semibold">Back</span>
                </a>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>There were some problems with your input:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="table w-full mt-8 bg-white rounded">
            <form action="{{ route('fees.collected') }}" method="POST" class="w-full max-w-xl px-6 py-12" enctype="multipart/form-data" target="_blank">
                @csrf
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Student Index Number
                        </label>
                    </div>
                    <div class="md:w-2/3 block text-gray-600 font-bold">
                        <input name="student_index_number" value="{{$studentIndexNumber}}" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" id='student_index_number' readonly>
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
                        <input name="student_name" value="{{$student->user->name}}" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" id='student_name' readonly>
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
                            @error('cheque_number')
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
                            @error('Momo_numbe')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <script>
                    document.getElementById('method_of_payment').addEventListener('change', function () {
                        const selectedMethod = this.value;
                
                        // Hide all fields initially
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
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Fees Type
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <select name="fees_type" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="fees_type" required>
                            <option value="">--Select Fee Type--</option>
                            @foreach ($feesTypes as $feesType)
                                <option value="{{ $feesType->fees_type }}">{{ $feesType->fees_type }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div id="amount_paid_id" class="hidden">
                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="amount">
                                Amount Paid
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <input name="amount_paid" id="amount_paid" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="number">
                            @error('amount')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div id="amount_id" class="hidden">
                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="amount">
                                Amount
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <input name="amount" id="amount" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="number">
                            @error('amount')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div id="balance_div">
                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="balance">
                                Balance
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <input name="balance" value="{{$student->balance}}" id="balance" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="number" readonly>
                            @error('balance')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div>
                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="balance">
                                Other Fees
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <input name="other_fees"  id="other_fees" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="number" >
                            @error('other_fees')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
               
                <!-- Remarks Textarea -->
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="remarks">
                            Remarks (Optional)
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <textarea name="remarks" id="remarks" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" rows="4" placeholder="Enter any additional remarks or notes"></textarea>
                        @error('remarks')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="md:flex md:items-center">
                    <div class="md:w-1/3"></div>
                    <div class="md:w-2/3">
                        <button class="shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit" >
                            Collect Fees
                        </button>
                    </div>
                </div>
                @if (session('success'))
                    <script>
                        Swal.fire({
                            title: 'Info',
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
            </form>        
        </div>
    </div>

    <!-- <script>
        document.addEventListener('DOMContentLoaded',()=> {
            const amount = document.getElementById('amount');
            const balance = document.getElementById('balance');
            const student = @json($student);
            // console.log(student)
            let totalFees = parseFloat(student.fees) || parseFloat(student.fees_prof) || 0;
            const levelChanged = @json($levelChanged);
            const semesterChanged = @json($semesterChanged);
            console.log(totalFees,levelChanged,semesterChanged);

            let currentSemesterFee = parseFloat(student.fees) || parseFloat(student.fees_prof) || 0;



            let scholarshipAmount = parseFloat(student.Scholarship_amount) || 0;
            function calculateBalance() {
                const enteredAmount = parseFloat(amount.value) || 0;

                if(student.Scholarship === 'Yes' && !isNaN(scholarshipAmount)) {
                    totalFees -= scholarshipAmount;
                }

                let remainingBalance = parseFloat(student.balance);

                if (isNaN(remainingBalance)) {
                    // If no specific balance, use adjusted total fees
                    remainingBalance = totalFees;
                }

                // Calculate new balance after deducting the entered amount
                let newBalance = remainingBalance - enteredAmount;

                if (newBalance < 0) {
                    newBalance = 0;
                    alert('Payment exceeds the remaining balance. Balance cannot be negative.');
                }

                // Update the balance field
                balance.value = newBalance.toFixed(2);
            }

            amount.addEventListener('input', calculateBalance);
        })
    </script> -->
    
    <!-- <script>
    document.addEventListener('DOMContentLoaded', () => {
        const amount = document.getElementById('amount');
        const balance = document.getElementById('balance');

        const student = @json($student);
        const levelChanged = @json($levelChanged);
        const semesterChanged = @json($semesterChanged);

        // Get appropriate fee
        let currentSemesterFee = parseFloat(student.fees) || parseFloat(student.fees_prof) || 0;
        let scholarshipAmount = parseFloat(student.Scholarship_amount) || 0;

        // Apply scholarship if applicable
        if (student.Scholarship === 'Yes' && !isNaN(scholarshipAmount)) {
            currentSemesterFee -= scholarshipAmount;
        }
        if (currentSemesterFee < 0) currentSemesterFee = 0;

        let previousBalance = parseFloat(student.balance) || 0;

        // Only add semester fees if level or semester has changed
        let totalDue = previousBalance;
        if (levelChanged || semesterChanged) {
            totalDue += currentSemesterFee;
        }

        // Update balance field on load
        balance.value = totalDue.toFixed(2);

        function calculateBalance() {
            const enteredAmount = parseFloat(amount.value) || 0;

            let newBalance = totalDue - enteredAmount;

            if (newBalance < 0) {
                newBalance = 0;
                alert('Payment exceeds the remaining balance. Balance cannot be negative.');
            }

            balance.value = newBalance.toFixed(2);
        }

        amount.addEventListener('input', calculateBalance);
    });
    </script> -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const amount = document.getElementById('amount');
        const balance = document.getElementById('balance');

        const student = @json($student);
        const levelChanged = @json($levelChanged);
        const semesterChanged = @json($semesterChanged);

        // Get appropriate fee
        let currentSemesterFee = parseFloat(student.fees) || parseFloat(student.fees_prof) || 0;
        let scholarshipAmount = parseFloat(student.Scholarship_amount) || 0;

        // Apply scholarship if applicable
        if (student.Scholarship === 'Yes' && !isNaN(scholarshipAmount)) {
            currentSemesterFee -= scholarshipAmount;
        }
        if (currentSemesterFee < 0) currentSemesterFee = 0;

        let previousBalance = parseFloat(student.balance) || 0;

        // Only add semester fees if level or semester has changed
        let totalDue = previousBalance;
        if (levelChanged || semesterChanged) {
            totalDue += currentSemesterFee;
        }

        // Update balance field on load
        balance.value = totalDue.toFixed(2);

        function calculateBalance() {
            const enteredAmount = parseFloat(amount.value) || 0;

            if (enteredAmount > totalDue) {
                alert('Payment exceeds the remaining balance. Amount has been reset to 0.');
                amount.value = '0.00';
                balance.value = totalDue.toFixed(2);
                return;
            }

            const newBalance = totalDue - enteredAmount;
            balance.value = newBalance.toFixed(2);
        }

        amount.addEventListener('input', calculateBalance);
    });
    </script>

    <script>
        document.getElementById('fees_type').addEventListener('change', function () {
            const selectedMethod = this.value;
            console.log(selectedMethod);
            
            // Hide all fields initially
            document.getElementById('balance_div').classList.add('hidden');
            document.getElementById('amount_id').classList.add('hidden');
            document.getElementById('amount_paid_id').classList.add('hidden')
            // document.getElementById('amount_div').classList.add('hidden');

            if (selectedMethod === 'School Fees') {
                document.getElementById('balance_div').classList.remove('hidden')
                document.getElementById('amount_id').classList.remove('hidden')
            } else {
                document.getElementById('amount_paid_id').classList.remove('hidden')
                document.getElementById('amount_id').classList.add('hidden')
            }
        });
    </script>
@endsection