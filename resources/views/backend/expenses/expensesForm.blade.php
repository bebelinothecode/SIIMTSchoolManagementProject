@extends('layouts.app')

@section('content')
<div class="roles">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-gray-700 uppercase font-bold">Expenses</h2>
        </div>
        <div class="flex flex-wrap items-center">
            <a href="{{ url()->previous() }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
                <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="long-arrow-alt-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <path fill="currentColor" d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z"></path>
                </svg>
                <span class="ml-2 text-xs font-semibold">Back</span>
            </a>
        </div>
    </div>

    <div class="table w-full mt-8 bg-white rounded">
        <form action="{{ route('save.expense')}}" method="POST" class="w-full max-w-xl px-6 py-12" enctype="multipart/form-data">
            @csrf

            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="academic_professional">
                        Academic/Professional
                    </label>
                </div>
                <div class="md:w-2/3">
                    <select name="source_of_expense" id="source_of_expense" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight m-3 focus:outline-none focus:bg-white focus:border-gray-500">
                        <option value="">--Select one--</option>
                        <option value="Academic">Academic</option>
                        <option value="Professional">Professional</option>
                    </select>
                </div>
            </div>

            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="branch">
                        Branch
                    </label>
                </div>
                <div class="md:w-2/3">
                    <select name="branch" id="branch" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight m-3 focus:outline-none focus:bg-white focus:border-gray-500" required>
                        <option value="">--Select branch--</option>
                        <option value="Kanda">Kanda</option>
                        <option value="Spintex">Spintex</option>
                        <option value="Kasoa">Kasoa</option>
                    </select>
                </div>
            </div>

            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="description">
                        Description of Expense
                    </label>
                </div>
                <div class="md:w-2/3">
                    <textarea name="description" id="description" placeholder="Enter here..." class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"></textarea>
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                        Category
                    </label>
                </div>
                <div class="md:w-2/3">
                    <select name="expensecategory_id" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="expensecategory_id" required>
                        <option value="">--Select Category--</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->expense_category }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="category">
                        Currency
                    </label>
                </div>
                <div class="md:w-2/3">
                    <select name="currency" id="currency" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                        <option value="">--Select Currency--</option>
                        <option value="Dollar">Dollar</option>
                        <option value="Ghana Cedi">Ghana Cedi</option>
                    </select>
                </div>
            </div>

            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="cash_amount">
                        Amount
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input type="number" name="amount" id="amount" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" placeholder="Enter cash amount" step="0.01" min="0" required>
                </div>
            </div>

            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="mode_of_payment">
                        Mode of Payment
                    </label>
                </div>
                <div class="md:w-2/3">
                    <select name="mode_of_payment" id="mode_of_payment" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                        <option value="">--Mode of Payment--</option>
                        <option value="Cash">Cash</option>
                        <option value="Cheque">Cheque</option>
                        <option value="Mobile Money">Mobile Money</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                    </select>
                </div>
            </div>

            <div id="conditionalFields" class="hidden">
                <div id="cheque_number_Field" class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="cheque_number">
                            Cheque Number
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input type="number" name="cheque_number" id="cheque_number" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" placeholder="Enter cheque number">
                    </div>
                </div>
            </div>

            <div id="conditionalFieldsCash" class="hidden">
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="cash_amount">
                            Cash Details
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input type="text" name="cash_amount_details" id="cash_amount" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" placeholder="Enter cash amount details here">
                    </div>
                </div>
            </div>

            <div id="conditionalFieldsMobileMoney" class="hidden">
                <div id="mobile-money-details" class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="mobile_money_details">
                            Mobile Money Details
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input type="text" name="mobile_money_details" id="mobile_money_details" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" placeholder="Enter mobile money details">
                    </div>
                </div>
            </div>

            <div id="conditionalFieldsBankDetails" class="hidden">
                <div id="bank-transfer-details" class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="bank_details">
                            Bank Details
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input type="text" name="bank_details" id="bank_details" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" placeholder="Enter bank details">
                    </div>
                </div>
            </div>

            <div class="md:flex md:items-center">
                <div class="md:w-1/3"></div>
                <div class="md:w-2/3">
                    <button type="submit" class="shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
                        Create Expense
                    </button>
                </div>
            </div>
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

        @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: "{{ session('error') }}",
                timer: 3000,
                showConfirmButton: false
            });
        </script>
        @endif  
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modeOfPaymentSelect = document.getElementById('mode_of_payment');
        const conditionalFields = document.getElementById('conditionalFields');
        const conditionalFieldsMobileMoney = document.getElementById('conditionalFieldsMobileMoney');
        const conditionalFieldsBankDetails = document.getElementById('conditionalFieldsBankDetails');
        const conditionalFieldsCash = document.getElementById('conditionalFieldsCash');

        modeOfPaymentSelect.addEventListener('change', function () {
            const selectedMode = this.value;

            // Hide all conditional fields initially
            conditionalFields.classList.add('hidden');
            conditionalFieldsMobileMoney.classList.add('hidden');
            conditionalFieldsBankDetails.classList.add('hidden');
            conditionalFieldsCash.classList.add('hidden');

            // Show the relevant conditional fields based on the selected mode
            if (selectedMode === 'Cheque') {
                conditionalFields.classList.remove('hidden');
            } else if (selectedMode === 'Mobile Money') {
                conditionalFieldsMobileMoney.classList.remove('hidden');
            } else if (selectedMode === 'Bank Transfer') {
                conditionalFieldsBankDetails.classList.remove('hidden');
            } 
        });
    });
</script>
@endpush