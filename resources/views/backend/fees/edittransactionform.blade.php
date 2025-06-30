@extends('layouts.app')

@section('content')
    <div class="roles">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">Edit Transaction</h2>
            </div>
            <div class="flex flex-wrap items-center">
                <a href="{{url()->previous()}}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
                    <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="long-arrow-alt-left" class="svg-inline--fa fa-long-arrow-alt-left fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z"></path></svg>
                    <span class="ml-2 text-xs font-semibold">Back</span>
                </a>
            </div>
        </div>

        <div class="table w-full mt-8 bg-white rounded">
            <form action="{{route('edit.transaction',$transaction->id)}} " method="POST" class="w-full max-w-xl px-6 py-12">
                @csrf
                @method('PUT')
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Student Index Number
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="student_index_number" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" value="{{ old('student_index_number', $transaction->student_index_number)}}">
                        @error('student_index_number')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Student Name
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="student_name" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" value="{{ old('student_name', $transaction->student_name)}}" >
                        @error('student_name')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Method of Payment
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <select name="method_of_payment" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="method_of_payment">
                            <option value="">--Select Method of Payment--</option>
                            <option value="Cash" {{ old('method_of_payment', $transaction->method_of_payment ?? '') === 'Cash' ? 'selected' : '' }}>Cash</option>
                            <option value="Cheque" {{ old('method_of_payment', $transaction->method_of_payment ?? '') === 'Cheque' ? 'selected' : '' }}>Cheque</option>
                            <option value="Momo" {{ old('method_of_payment', $transaction->method_of_payment ?? '') === 'Momo' ? 'selected' : '' }}>Momo</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>                        @error('description')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Amount
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="amount" id="amount" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" value="{{ old('amount', $transaction->amount)}}">
                        @error('amount')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Balance
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="balance" id="balance" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" value="{{ old('balance', $transaction->balance)}}" readonly>
                        @error('balance')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Currency
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="currency" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" value="{{ old('currency', $transaction->currency)}}">
                        @error('currency')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Cheque Number
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="cheque_number" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" value="{{ old('cheque_number', $transaction->cheque_number)}}">
                        @error('cheque_number')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Momo Number
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="momo_number" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" value="{{ old('Momo_number', $transaction->Momo_number)}}">
                        @error('momo_number')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Remarks
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="remarks" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" value="{{ old('remarks', $transaction->remarks)}}">
                        @error('remarks')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Receipt Number
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="receipt_number" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text" value="{{ old('receipt_number', $transaction->receipt_number)}}" readonly>
                        @error('receipt_number')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                            Fees Type
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <select name="fees_type" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="fees_type">
                            <option value="">--Select Fees Type--</option>
                            <option value="School Fees" {{ old('fees_type', $transaction->fees_type ?? '') === 'School Fees' ? 'selected' : '' }}>School Fees</option>
                            <option value="Mature Exams" {{ old('fees_type', $transaction->fees_type ?? '') === 'Mature Exams' ? 'selected' : '' }}>Mature Exams</option>
                            <option value="Other" {{ old('fees_type', $transaction->fees_type ?? '') === 'Other' ? 'selected' : '' }}>Other</option>
                            <option value="Resit" {{ old('fees_type', $transaction->fees_type ?? '') === 'Resit' ? 'selected' : '' }}>Resit</option>
                            <option value="Graduation Fees" {{ old('fees_type', $transaction->fees_type ?? '') === 'Graduation Fees' ? 'selected' : '' }}>Graduation Fees</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                        @error('fees_type')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="md:flex md:items-center">
                    <div class="md:w-1/3"></div>
                    <div class="md:w-2/3">
                        <button class="shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">
                            Edit transaction
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
            </form>        
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const amountInput = document.getElementById('amount');
        const balanceInput = document.getElementById('balance');

        // Store initial values
        const originalAmount = parseFloat(amountInput.value) || 0;
        const originalBalance = parseFloat(balanceInput.value) || 0;

        amountInput.addEventListener('input', function () {
            const newAmount = parseFloat(amountInput.value) || 0;

            // Calculate difference and new balance
            const difference = originalAmount - newAmount;
            const updatedBalance = originalBalance + difference;

            if (updatedBalance < 0) {
                alert("Balance cannot be negative. Please enter a valid amount.");
                
                // Revert to original values
                amountInput.value = originalAmount.toFixed(2);
                balanceInput.value = originalBalance.toFixed(2);
            } else {
                balanceInput.value = updatedBalance.toFixed(2);
            }
        });
    });
    </script>



@endsection