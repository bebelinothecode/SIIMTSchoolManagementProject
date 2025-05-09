<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenses Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            color: #333; 
            line-height: 1.6; 
        }
        .header { 
            border-bottom: 2px solid #007bff; 
            padding-bottom: 20px; 
            margin-bottom: 30px; 
        }
        .logo { 
            max-height: 80px; 
            height: auto; 
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
        .footer { 
            margin-top: 50px; 
            text-align: center; 
            font-size: 12px; 
            color: #6c757d; 
            border-top: 1px solid #dee2e6; 
            padding-top: 20px; 
        }
        .badge { 
            margin-top: 5px; 
            font-size: 90%; 
        }
        .payment-card { 
            margin-bottom: 20px; 
        }
        .payment-card .card-header { 
            font-weight: bold; 
        }
        .total-row { 
            font-weight: bold; 
            background-color: #e9f7fe; 
        }
        .category-header {
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-radius: 4px;
            margin: 25px 0 15px;
            border-left: 4px solid #007bff;
        }
        @media print {
            .no-print { 
                display: none; 
            }
            body { 
                padding: 0; 
                font-size: 11pt; 
            }
            .table { 
                font-size: 10pt; 
            }
            .payment-card { 
                break-inside: avoid; 
            }
            .category-section {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-4 mb-5">
        <!-- Header -->
        <div class="header">
            <div class="text-center mb-4">
                <img src="{{ asset('resources/views/backend/fees/siimtlogo.jpeg') }}" alt="Institution Logo" class="logo img-fluid">
            </div>
            <h1 class="report-title">EXPENSES REPORT</h1>
            <div class="report-date">
                <i class="far fa-calendar-alt"></i> Generated on: {{ $generatedAt }}
            </div>
        </div>
<!-- Filters Section -->
        <div class="filters-section no-print">
            <h4><i class="fas fa-filter"></i> Filters Applied</h4>
            <div class="row">
                @if ($filters['currentDate'])
                    <div class="col-md-3 col-6 mb-2">
                        <strong>Current Date:</strong><br>
                        <span class="badge badge-primary">{{ \Carbon\Carbon::parse($filters['currentDate'])->format('M j, Y') }}</span>
                    </div>
                @endif
                @if ($filters['startDate'])
                    <div class="col-md-3 col-6 mb-2">
                        <strong>Start Date:</strong><br>
                        <span class="badge badge-info">{{ \Carbon\Carbon::parse($filters['startDate'])->format('M j, Y') }}</span>
                    </div>
                @endif
                @if ($filters['endDate'])
                    <div class="col-md-3 col-6 mb-2">
                        <strong>End Date:</strong><br>
                        <span class="badge badge-info">{{ \Carbon\Carbon::parse($filters['endDate'])->format('M j, Y') }}</span>
                    </div>
                @endif
                @if ($filters['studentCategory'])
                    <div class="col-md-3 col-6 mb-2">
                        <strong>Category:</strong><br>
                        <span class="badge badge-success">{{ $filters['studentCategory'] }}</span>
                    </div>
                @endif
                @if ($filters['modeOfPayment'])
                    <div class="col-md-3 col-6 mb-2">
                        <strong>Payment Mode:</strong><br>
                        <span class="badge badge-success">{{ $filters['modeOfPayment'] }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Summary Section -->
        <h4 class="section-title"><i class="fas fa-chart-pie"></i> Summary</h4>
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary">
                    <div class="card-body text-center">
                        <h6 class="card-title">Total Expenses</h6>
                        <h4>{{ number_format($totalAmount, 2) }}</h4>
                    </div>
                </div>
            </div>
            @if($filters['studentCategory'])
                @foreach($paymentSummaries[$filters['studentCategory']] as $method => $summary)
                    @if($summary['total'] > 0)
                    <div class="col-md-3">
                        <div class="card text-white bg-{{ 
                            $method == 'Cash' ? 'success' : 
                            ($method == 'Mobile Money' ? 'info' : 
                            ($method == 'Bank Transfer' ? 'warning' : 'secondary')) 
                        }}">
                            <div class="card-body text-center">
                                <h6 class="card-title">{{ $method }}</h6>
                                <h4>{{ number_format($summary['total'], 2) }}</h4>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            @else
                @foreach(['Academic', 'Professional'] as $category)
                    @if(isset($paymentSummaries[$category]))
                    <div class="col-md-3">
                        <div class="card text-white bg-{{ $category == 'Academic' ? 'dark' : 'secondary' }}">
                            <div class="card-body text-center">
                                <h6 class="card-title">{{ $category }} Total</h6>
                                <h4>{{ number_format($categories[$category]->sum('amount'), 2) }}</h4>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            @endif
        </div>
<!-- Category-wise Expenses -->
        @if(!$filters['studentCategory'])
            @foreach($categories as $category => $expenses)
                @if($expenses->count() > 0)
                <div class="category-section">
                    <div class="category-header">
                        <h4>
                            <i class="fas fa-{{ $category == 'Academic' ? 'book' : 'briefcase' }}"></i> 
                            {{ $category }} Expenses
                            <span class="badge badge-primary float-right">{{ number_format($expenses->sum('amount'), 2) }}</span>
                        </h4>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-sm table-hover table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Source</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Payment Mode</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($expenses as $expense)
                                    <tr>
                                        <td>{{ $expense->source_of_expense }}</td>
                                        <td>{{ $expense->description_of_expense }}</td>
                                        <td>{{ number_format($expense->amount, 2) }}</td>
                                        <td>{{ $expense->mode_of_payment }}</td>
                                        <td>{{ \Carbon\Carbon::parse($expense->created_at)->format('M j, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="total-row">
                                    <td colspan="2" class="text-right">Total {{ $category }}:</td>
                                    <td>{{ number_format($expenses->sum('amount'), 2) }}</td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
<!-- Payment Method Breakdown for this Category -->
                    <h5 class="mt-4 mb-3"><i class="fas fa-money-bill-wave"></i> Payment Method Breakdown</h5>
                    <div class="row">
                        @foreach($paymentSummaries[$category] as $method => $summary)
                            @if($summary['total'] > 0)
                            <div class="col-md-3 mb-3">
                                <div class="card border-{{ 
                                    $method == 'Cash' ? 'success' : 
                                    ($method == 'Mobile Money' ? 'info' : 
                                    ($method == 'Bank Transfer' ? 'warning' : 'secondary')) 
                                }}">
                                    <div class="card-body p-2 text-center">
                                        <h6 class="card-title mb-1">{{ $method }}</h6>
                                        <h5 class="mb-0">{{ number_format($summary['total'], 2) }}</h5>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif
            @endforeach
        @else
            <!-- Detailed Expenses when a specific category is selected -->
            <h4 class="section-title"><i class="fas fa-list-ul"></i> Detailed Expenses</h4>
            <div class="table-responsive">
                <table class="table table-sm table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Source</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Currency</th>
                            <th>Payment Mode</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories[$filters['studentCategory']] as $expense)
                            <tr>
                                <td>{{ $expense->source_of_expense }}</td>
                                <td>{{ $expense->description_of_expense }}</td>
                                <td>{{ $expense->category }}</td>
                                <td>{{ number_format($expense->amount, 2) }}</td>
                                <td>{{ $expense->currency }}</td>
                                <td>{{ $expense->mode_of_payment }}</td>
                                <td>{{ \Carbon\Carbon::parse($expense->created_at)->format('M j, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No expenses found for the selected filters</td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if($categories[$filters['studentCategory']]->count() > 0)
                    <tfoot>
                        <tr class="total-row">
                            <td colspan="3" class="text-right">Total:</td>
                            <td>{{ number_format($categories[$filters['studentCategory']]->sum('amount'), 2) }}</td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
<!-- Payment Method Breakdown -->
            <h5 class="section-title"><i class="fas fa-money-bill-wave"></i> Payment Method Breakdown</h5>
            <div class="row">
                @foreach($paymentSummaries[$filters['studentCategory']] as $method => $summary)
                    @if($summary['total'] > 0)
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <div class="card-header bg-{{ 
                                $method == 'Cash' ? 'success' : 
                                ($method == 'Mobile Money' ? 'info' : 
                                ($method == 'Bank Transfer' ? 'warning' : 'secondary')) 
                            }} text-white">
                                <i class="fas fa-{{
                                    $method == 'Cash' ? 'money-bill-wave' : 
                                    ($method == 'Mobile Money' ? 'mobile-alt' : 
                                    ($method == 'Bank Transfer' ? 'university' : 'money-check'))
                                }}"></i> {{ $method }}
                            </div>
                            <div class="card-body text-center">
                                <h4>{{ number_format($summary['total'], 2) }}</h4>
                                <p class="mb-0">{{ $summary['transactions']->count() }} transactions</p>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>This report was automatically generated by the University Financial System</p>
            <p><i class="far fa-copyright"></i> {{ date('Y') }} - All Rights Reserved</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('load', function() {
            if(window.location.href.indexOf('print=true') > -1) {
                window.print();
            }
        });
    </script>
</body>
</html>
