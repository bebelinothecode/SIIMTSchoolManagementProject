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

        <!-- Filters Section -->
        <div class="filters-section">
            <h4><i class="fas fa-filter"></i> Filters Applied</h4>
            <div class="row">
                @if ($currentDate)
                    <div class="col-md-3">
                        <strong>Current Date:</strong><br>
                        <span class="badge badge-primary">{{ \Carbon\Carbon::parse($currentDate)->format('M j, Y') }}</span>
                    </div>
                @endif
                @if ($startDate)
                    <div class="col-md-3">
                        <strong>Start Date:</strong><br>
                        <span class="badge badge-info">{{ \Carbon\Carbon::parse($startDate)->format('M j, Y') }}</span>
                    </div>
                @endif
                @if ($endDate)
                    <div class="col-md-3">
                        <strong>End Date:</strong><br>
                        <span class="badge badge-info">{{ \Carbon\Carbon::parse($endDate)->format('M j, Y') }}</span>
                    </div>
                @endif
                @if ($modeOfPayment)
                    <div class="col-md-3">
                        <strong>Mode of Payment:</strong><br>
                        <span class="badge badge-success">{{ ucfirst($modeOfPayment) }}</span>
                    </div>
                @endif
                @if ($studentCategory)
                    <div class="col-md-3">
                        <strong>Student Category:</strong><br>
                        <span class="badge badge-success">{{ ucfirst($studentCategory) }}</span>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Detailed Transactions -->
        <h4 class="section-title"><i class="fas fa-list-ul"></i> Detailed Expenses</h4>
        
        @php
            // If no specific student category is selected, show both categories
            if (!$studentCategory) {
                $academicExpenses = $expenses->where('source_of_expense', 'Academic');
                $professionalExpenses = $expenses->where('source_of_expense', 'Professional');
                $otherExpenses = $expenses->whereNotIn('source_of_expense', ['Academic', 'Professional']);
            } else {
                // If a category is selected, all expenses are of that category
                $academicExpenses = $studentCategory === 'Academic' ? $expenses : collect();
                $professionalExpenses = $studentCategory === 'Professional' ? $expenses : collect();
                $otherExpenses = collect();
            }
        @endphp

        @if ($studentCategory === 'Academic' || !$studentCategory)
        <div class="category-title">
            <h5><i class="fas fa-folder-open"></i> Academic Expenses</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Currency</th>
                        <th>Amount</th>
                        <th>Mode of Payment</th>
                        <th>Category</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!$studentCategory)
                        @foreach ($academicExpenses as $expense)
                            <tr>
                                <td>{{ $expense->currency }}</td>
                                <td>{{ number_format($expense->amount, 2) }}</td>
                                <td>{{ $expense->mode_of_payment }}</td>
                                <td>{{ $expense->category }}</td>
                                <td>{{ $expense->created_at }}</td>
                            </tr>
                        @endforeach
                        <!-- Academic Total row -->
                        <tr class="table-info font-weight-bold">
                            <td colspan="4" class="text-right">Total Academic Amount:</td>
                            <td>GHS{{ number_format($academicExpenses->sum('amount'), 2) }}</td>
                        </tr>
                    @else
                        @foreach ($expenses as $expense)
                            <tr>
                                <td>{{ $expense->currency }}</td>
                                <td>{{ number_format($expense->amount, 2) }}</td>
                                <td>{{ $expense->mode_of_payment }}</td>
                                <td>{{ $expense->category }}</td>
                                <td>{{ $expense->created_at }}</td>
                            </tr>
                        @endforeach
                        <!-- Total row -->
                        <tr class="table-info font-weight-bold">
                            <td colspan="4" class="text-right">Total Academic Amount:</td>
                            <td>GHS{{ number_format($sumOfExpenses, 2) }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        @endif

        @if ($studentCategory === 'Professional' || !$studentCategory)
        <div class="category-title">
            <h5><i class="fas fa-folder-open"></i> Professional Expenses</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Currency</th>
                        <th>Amount</th>
                        <th>Mode of Payment</th>
                        <th>Category</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!$studentCategory)
                        @foreach ($professionalExpenses as $expense)
                            <tr>
                                <td>{{ $expense->currency }}</td>
                                <td>{{ number_format($expense->amount, 2) }}</td>
                                <td>{{ $expense->mode_of_payment }}</td>
                                <td>{{ $expense->category }}</td>
                                <td>{{ $expense->created_at }}</td>
                            </tr>
                        @endforeach
                        <!-- Professional Total row -->
                        <tr class="table-info font-weight-bold">
                            <td colspan="4" class="text-right">Total Professional Amount:</td>
                            <td>GHS{{ number_format($professionalExpenses->sum('amount'), 2) }}</td>
                        </tr>
                    @else
                        @foreach ($expenses as $expense)
                            <tr>
                                <td>{{ $expense->currency }}</td>
                                <td>{{ number_format($expense->amount, 2) }}</td>
                                <td>{{ $expense->mode_of_payment }}</td>
                                <td>{{ $expense->category }}</td>
                                <td>{{ $expense->created_at }}</td>
                            </tr>
                        @endforeach
                        <!-- Total row -->
                        <tr class="table-info font-weight-bold">
                            <td colspan="4" class="text-right">Total Professional Amount:</td>
                            <td>GHS{{ number_format($sumOfExpenses, 2) }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        @endif

        @if (!$studentCategory && $otherExpenses->count() > 0)
        <div class="category-title">
            <h5><i class="fas fa-folder-open"></i> Other Expenses</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Currency</th>
                        <th>Amount</th>
                        <th>Mode of Payment</th>
                        <th>Category</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($otherExpenses as $expense)
                        <tr>
                            <td>{{ $expense->currency }}</td>
                            <td>{{ number_format($expense->amount, 2) }}</td>
                            <td>{{ $expense->mode_of_payment }}</td>
                            <td>{{ $expense->category }}</td>
                            <td>{{ $expense->created_at }}</td>
                        </tr>
                    @endforeach
                    <!-- Other Total row -->
                    <tr class="table-info font-weight-bold">
                        <td colspan="4" class="text-right">Total Other Amount:</td>
                        <td>GHS{{ number_format($otherExpenses->sum('amount'), 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif
      
        <!-- Summary Totals -->
        <h4 class="section-title"><i class="fas fa-calculator"></i> Summary Totals</h4>
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Category</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!$studentCategory)
                        <tr>
                            <td>Academic</td>
                            <td>GHS{{ number_format($academicExpenses->sum('amount'), 2) }}</td>
                        </tr>
                        <tr>
                            <td>Professional</td>
                            <td>GHS{{ number_format($professionalExpenses->sum('amount'), 2) }}</td>
                        </tr>
                        @if ($otherExpenses->count() > 0)
                        <tr>
                            <td>Other</td>
                            <td>GHS{{ number_format($otherExpenses->sum('amount'), 2) }}</td>
                        </tr>
                        @endif
                        <tr class="total-highlight">
                            <td>Total</td>
                            <td>GHS{{ number_format($sumOfExpenses, 2) }}</td>
                        </tr>
                    @else
                        <tr>
                            <td>{{ $studentCategory }}</td>
                            <td>GHS{{ number_format($sumOfExpenses, 2) }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Payment Mode Summary -->
        <h4 class="section-title"><i class="fas fa-credit-card"></i> Payment Method Summary</h4>
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Payment Method</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $paymentMethods = $expenses->groupBy('mode_of_payment');
                    @endphp
                    
                    @foreach ($paymentMethods as $method => $items)
                        <tr>
                            <td>{{ ucfirst($method) }}</td>
                            <td>GHS{{ number_format($items->sum('amount'), 2) }}</td>
                        </tr>
                    @endforeach
                    
                    <tr class="total-highlight">
                        <td>Total</td>
                        <td>GHS{{ number_format($sumOfExpenses, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>This report was automatically generated by the University Financial System</p>
            <p><i class="far fa-copyright"></i> {{ date('Y') }} - All Rights Reserved</p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
