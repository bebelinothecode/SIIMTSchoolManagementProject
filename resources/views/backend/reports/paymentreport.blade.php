<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Report</title>
    <!-- Bootstrap CSS for styling -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Payment Report</h1>

        <h1 class="mb-4"><strong>Current Date/Time</strong>:{{ \Carbon\Carbon::now()->format('Y-m-d') }}</h1>

        <!-- Display Filters Applied -->
        <div class="mb-4">
            <h4>Filters Applied:</h4>
            <ul>
                @if ($currentDate)
                    <li><strong>Current Date:</strong> {{ \Carbon\Carbon::parse($currentDate)->format('Y-m-d') }}</li>
                @endif
                @if ($startDate)
                    <li><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($startDate)->format('Y-m-d') }}</li>
                @endif
                @if ($endDate)
                    <li><strong>End Date:</strong> {{ \Carbon\Carbon::parse($endDate)->format('Y-m-d') }}</li>
                @endif
                @if ($aca_prof)
                    <li><strong>Category:</strong> {{ $aca_prof }}</li>
                @endif
            </ul>
        </div>

        <!-- Transactions by Category and Currency -->
        <h2>Transactions by Category and Currency</h2>
        @foreach ($transactionsByCategoryAndCurrency as $category => $currencies)
            <h3 class="mt-4">{{ ucfirst($category) }}</h3>
            @foreach ($currencies as $currency => $transactions)
                <h4 class="mt-3">Currency: {{ $currency }}</h4>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student Index Number</th>
                            <th>Student Name</th>
                            <th>Payment Method</th>
                            <th>Amount</th>
                            <th>Balance</th>
                            <th>Date</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->student_index_number }}</td>
                                <td>{{ $transaction->student_name }}</td>
                                <td>{{ $transaction->method_of_payment }}</td>
                                <td>{{ $transaction->amount }}</td>
                                <td>{{ $transaction->balance }}</td>
                                <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('Y-m-d H:i:s') }}</td>
                                <td>{{ $transaction->remarks ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        @endforeach

        <!-- Totals by Category and Currency -->
        <h2 class="mt-5">Totals by Category and Currency</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Currency</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($totalsByCategoryAndCurrency as $category => $currencies)
                    @foreach ($currencies as $currency => $total)
                        <tr>
                            <td>{{ ucfirst($category) }}</td>
                            <td>{{ $currency }}</td>
                            <td>{{ $total }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>