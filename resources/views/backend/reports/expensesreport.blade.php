<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenses Report</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        .header {
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            max-height: 80px;
        }
        .report-title {
            color: #007bff;
            text-align: center;
            margin-bottom: 5px;
        }
        .report-date {
            text-align: center;
            color: #6c757d;
            margin-bottom: 20px;
        }
        .filters-section {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        .section-title {
            color: #007bff;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 5px;
            margin-top: 30px;
            margin-bottom: 20px;
        }
        .table {
            font-size: 14px;
        }
        .table thead {
            background-color: #007bff;
            color: white;
        }
        .total-highlight {
            font-weight: bold;
            background-color: #e9f7fe;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
            padding-top: 20px;
        }
        .category-title {
            background-color: #e9ecef;
            padding: 8px 15px;
            border-radius: 4px;
            margin-top: 25px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container mt-4 mb-5">
        <!-- Header with Logo -->
        <div class="header">
            <div class="logo-container">
                <img src="{{asset('logo\SIIMT-logo.png')}}" alt="Institution Logo" class="logo">
            </div>
            <h2 class="report-title">SIIMT UNIVERSITY COLLEGE</h2>
            <h5 class="report-title">EXPENSES REPORT</h5>
            <div class="report-date">
                <i class="far fa-calendar-alt"></i> Generated on: {{ \Carbon\Carbon::now()->format('F j, Y h:i A') }}
            </div>
        </div>

        <div class="filters-section">
            <h4><i class="fas fa-filter"></i> Filters Applied</h4>
            <div class="row">
                @if ($filters['currentDate'])
                    <div class="col-md-3">
                        <strong>Current Date:</strong><br>
                        <span class="badge badge-primary">{{ \Carbon\Carbon::parse($filters['currentDate'])->format('M j, Y') }}</span>
                    </div>
                @endif
                @if ($filters['startDate'])
                    <div class="col-md-3">
                        <strong>Start Date:</strong><br>
                        <span class="badge badge-info">{{ \Carbon\Carbon::parse($filters['startDate'])->format('M j, Y') }}</span>
                    </div>
                @endif
                @if ($filters['endDate'])
                    <div class="col-md-3">
                        <strong>End Date:</strong><br>
                        <span class="badge badge-info">{{ \Carbon\Carbon::parse($filters['endDate'])->format('M j, Y') }}</span>
                    </div>
                @endif
                
                @if ($filters['branch'])
                    <div class="col-md-3">
                        <strong>Branch:</strong><br>
                        <span class="badge badge-success">{{ $filters['branch'] }}</span>
                    </div>
                @endif
               
                @if ($filters['expensecategory_id'])
                    <div class="col-md-3">
                        <strong>Category:</strong><br>
                        <span class="badge badge-success">{{ $filters['expensecategory_id'] }}</span>
                    </div>
                @endif
                @if ($filters['modeOfPayment'])
                    <div class="col-md-3">
                        <strong>Method of Payment:</strong><br>
                        <span class="badge badge-success">{{ $filters['modeOfPayment'] }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Detailed Transactions -->
        <h4 class="section-title"><i class="fas fa-list-ul"></i> Expenses List</h4>
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <!-- <th>Academic/Professional</th> -->
                                <!-- <th>Expense Category</th> -->
                                <th>Description</th>
                                <th>Branch</th>
                                <th>Expense Category</th>
                                <th>Amount</th>
                                <th>Mode of Payment</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                                <tr>
                                    <!-- <td>{{ $data->source_of_expense }}</td> -->
                                    <!-- <td>{{ $data->category ?? "N/A" }}</td> -->
                                    <td>{{ $data->description_of_expense ?? "N/A" }}</td>
                                    <td>{{ $data->branch }}</td>
                                    <td>{{ $data->expenseCategory->expense_category ?? $data->category ?? "N/A" }}</td>
                                    <td>{{ number_format($data->amount,2) }}</td>
                                    <td>{{ $data->mode_of_payment }}</td>
                                    <td>{{ $data->created_at }}</td>
                                </tr>
                            @endforeach
                            <!-- Total Row -->
                            <tr class="total-highlight">
                                <td colspan="3" class="text-right">Total</td>
                                <td><strong>{{ $datas->first()->currency ?? 'GHS' }} {{ number_format($totalAmount, 2) }}</strong></td>
                                <td colspan="2"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>