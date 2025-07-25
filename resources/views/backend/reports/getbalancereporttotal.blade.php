<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance Report(Total)</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f7fa;
            color: #333;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        h3 {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-top: 0;
        }
        
        .filter-section {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #dee2e6;
        }
        
        /* .filter-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 10px;
        } */
        .filter-group {
            display: flex;
            flex-direction: row;  
            gap: 20px;            
            flex-wrap: wrap;      
        }
        
        .filter-item {
            min-width: 200px;      
            padding: 10px;
            border: 1px solid #ddd; 
            border-radius: 4px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #495057;
        }
        
        select, input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 14px;
        }
        
        button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        
        button:hover {
            background-color: #2980b9;
        }
        
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px 0;
            font-family: Arial, sans-serif;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 10px 12px;
            text-align: left;
        }
        
        th {
            background-color: #3498db;
            color: white;
            font-weight: bold;
            position: sticky;
            top: 0;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        tr:hover {
            background-color: #e9e9e9;
        }
        
        caption {
            font-weight: bold;
            margin-bottom: 10px;
            text-align: left;
            font-size: 1.1em;
            color: #2c3e50;
            padding: 5px 0;
        }
        
        .summary-card {
            background-color: #e8f4fd;
            border-left: 4px solid #3498db;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .summary-card h4 {
            margin-top: 0;
            color: #2c3e50;
        }
        
        .summary-value {
            font-size: 1.2em;
            font-weight: bold;
            color: #2980b9;
        }
        
        .table-container {
            margin-bottom: 30px;
        }
        
        .date-range {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .date-range input {
            flex: 1;
        }
        
        @media (max-width: 768px) {
            .filter-group {
                flex-direction: column;
            }
            
            .filter-item {
                min-width: 100%;
            }
            
            .date-range {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Balance Report(Professional + Academic)</h3>
        <!-- @if ($currentDate)
         <h4>This report is on {{ $currentDate }}</h4>
        @endif
        @if ($startDate && $endDate)
         <h4>This report is from {{ $startDate }} to {{ $endDate }}</h4>
        @endif -->
        <!-- Summary Cards -->
        <div class="summary-card">
            <h4>Financial Summary</h4>
            <!-- <div class="filter-group">
                <div class="filter-item">
                    <p>Total Collections</p>
                    <p class="summary-value">GHS {{ number_format($feesPaymentsTotal + $formFeesAllAmount, 2) }}</p>                </div>
                <div class="filter-item">
                <div class="filter-item">
                    <p>Opening Balance </p>
                    <p class="summary-value">GHS {{ number_format($openingBalance, 2) }}</p>                </div>
                <div class="filter-item">
                    <p>Total Expenses</p>
                    <p class="summary-value">GHS {{ number_format($expensesTotalAmount,2) }}</p>
                </div>
                <div class="filter-item">
                    <p>Closing Balance</p>
                    <p class="summary-value">
                        GHS {{ number_format(($feesPaymentsTotal + $formFeesAllAmount + $openingBalance) - $expensesTotalAmount, 2) }}
                    </p>                
                </div>
              </div>
            </div> -->
            <div class="filter-group">
                <div class="filter-item">
                    <p>Total Collections that Day</p>
                    <p class="summary-value">GHS {{ number_format($feesPaymentsTotal + $formFeesAllAmount, 2) }}</p>
                </div>
                <div class="filter-item">
                    <p>Opening Balance</p>
                         <!-- {{ number_format(($feesPaymentsTotal + $formFeesAllAmount + $openingBalance) - $expensesTotalAmount, 2) }} -->
                    <p class="summary-value">GHS {{ number_format($openingBalance, 2) }}</p>
                </div>
                <div class="filter-item">
                    <p>Total Expenses</p>
                    <p class="summary-value">GHS {{ number_format($expensesTotalAmount, 2) }}</p>
                </div>
                <div class="filter-item">
                    <p>Closing Balance</p>
                    <p class="summary-value">
                    <!-- {{ number_format(($feesPaymentsTotal + $formFeesAllAmount) - $expensesTotalAmount, 2) }} -->
                        GHS {{ number_format(($feesPaymentsTotal + $formFeesAllAmount + $openingBalance) - $expensesTotalAmount, 2) }}
                    </p>
                </div>
            </div>

        <!-- Payments Table -->
        <div class="table-container">
            <table id="paymentsTable">
                <caption>Payments Table</caption>
                <thead>
                    <tr>
                        <th>Student Index</th>
                        <th>Student Name</th>
                        <th>Amount</th>
                        <th>Balance</th>
                        <th>Currency</th>
                        <th>Method</th>
                        <th>Receipt No.</th>
                        <th>Fee Type</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($feeCollectionTransactions as $feeCollectionTransaction)
                    <tr>
                        <td>{{ $feeCollectionTransaction->student_index_number ?? "N/A" }}</td>
                        <td>{{ $feeCollectionTransaction->student_name ?? "N/A" }}</td>
                        <td>{{ $feeCollectionTransaction->amount ?? "N/A" }}</td>
                        <td>{{ $feeCollectionTransaction->balance ?? "N/A" }}</td>
                        <td>{{ $feeCollectionTransaction->currency ?? "N/A" }}</td>
                        <td>{{ $feeCollectionTransaction->method_of_payment  }}</td>
                        <td>{{ $feeCollectionTransaction->receipt_number ?? "N/A" }}</td>
                        <td>{{ $feeCollectionTransaction->fees_type }}</td>
                        <td>{{ $feeCollectionTransaction->created_at }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">No payments found.</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2">Total Payments:</td>
                        <td colspan="7">GHS {{$feesPaymentsTotal}}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <!-- Form Fees Table -->
        <div class="table-container">
            <table id="formFeesTable">
                <caption>Form Fees Table</caption>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Currency</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($formFeesBebelinos as $formFeesBebelino)
                    <tr>
                        <td>{{ $formFeesBebelino->name ?? "N/A" }}</td>
                        <td>{{ $formFeesBebelino->telephone_number ?? "N/A" }}</td>
                        <td>{{ $formFeesBebelino->currency ?? "N/A" }}</td>
                        <td>{{ $formFeesBebelino->amount ?? "N/A" }}</td>
                        <td>{{ $formFeesBebelino->created_at ?? "N/A" }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No form fee payments found.</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">Total Form Fees:</td>
                        <td colspan="2">GHS {{$formFeesAllAmount}}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <!-- Expenses Table -->
        <div class="table-container">
            <table id="expensesTable">
                <caption>Expenses Table</caption>
                <thead>
                    <tr>
                        <th>Source</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($expensesTransactions as $expensesTransaction)
                    <tr>
                        <td>{{ $expensesTransaction->source_of_expense ?? "N/A" }}</td>
                        <td>{{ $expensesTransaction->description_of_expense ?? "N/A" }}</td>
                        <td>{{ $expensesTransaction->category ?? "N/A" }}</td>
                        <td>{{ $expensesTransaction->amount ?? "N/A" }}</td>
                        <td>{{ $expensesTransaction->mode_of_payment ?? "N/A" }}</td>
                        <td>{{ $expensesTransaction->created_at }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No expenses found.</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">Total Expenses:</td>
                        <td colspan="3">GHS {{$expensesTotalAmount}}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="overflow-x-auto">
        <h3 class="text-lg font-bold mb-4">Balance by Category and Mode of Payment</h3>
        <table class="table-auto w-full border border-gray-300 text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">Category</th>
                    <th class="border px-4 py-2">Cash</th>
                    <th class="border px-4 py-2">Mobile Money</th>
                    <th class="border px-4 py-2">Bank Transfer</th>
                    <!-- <th class="border px-4 py-2">Momo</th>
                    <th class="border px-4 py-2">Cheque</th> -->
                </tr>
            </thead>
            <tbody>
                @foreach ($balanceByCategoryAndMode as $category => $modes)
                    <tr>
                        <td class="border px-4 py-2 font-semibold">{{ $category }}</td>
                        <td class="border px-4 py-2">{{ number_format($modes['Cash'] ?? 0, 2) }}</td>
                        <td class="border px-4 py-2">{{ number_format($modes['Mobile Money'] ?? 0, 2) }}</td>
                        <td class="border px-4 py-2">{{ number_format($modes['Bank Transfer'] ?? 0, 2) }}</td>
                        <!-- <td class="border px-4 py-2">{{ number_format($modes['Momo'] ?? 0, 2) }}</td>
                        <td class="border px-4 py-2">{{ number_format($modes['Cheque'] ?? 0, 2) }}</td> -->
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>

         <!-- =======Balance brought forward -->
        <div class="overflow-x-auto">
        <h3 class="text-lg font-bold mb-4">Opening & Closing Balance</h3>
        <table class="table-auto w-full border border-gray-300 text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">Opening Balance</th>
                    <th class="border px-4 py-2">Closing Balance</th>
                    <!-- <th class="border px-4 py-2">Mobile Money</th>
                    <th class="border px-4 py-2">Bank Transfer</th> -->
                </tr>
            </thead>
            <tbody>
                <tr>
                    <!-- <td class="border px-4 py-2 font-semibold">{{ $category }}</td> -->
                    <td class="border px-4 py-2">GHS{{ number_format($openingBalance ?? 0, 2) }}</td>
                    <td class="border px-4 py-2">GHS{{ number_format(($feesPaymentsTotal + $formFeesAllAmount + $openingBalance) - $expensesTotalAmount, 2) }}</td>
                </tr>
            </tbody>
        </table>
       </div> 
    </div>
</body>
</html>