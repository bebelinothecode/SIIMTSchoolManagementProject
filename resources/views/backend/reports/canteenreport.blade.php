                                                                                                                                        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canteen Report</title>
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
            <h5 class="report-title">CANTEEN COLLECTIONS REPORT</h5>
            <div class="report-date">
                <i class="far fa-calendar-alt"></i> Generated on: {{ \Carbon\Carbon::now()->format('F j, Y h:i A') }}
            </div>
        </div>

        <!-- Filters Section -->
        <div class="filters-section">
            <h4><i class="fas fa-filter"></i> Filters Applied</h4>
            <div class="row">
                @if ($validatedData['current_date'])
                    <div class="col-md-3">
                        <strong>Current Date:</strong><br>
                        <span class="badge badge-primary">{{ \Carbon\Carbon::parse($validatedData['current_date'])->format('M j, Y') }}</span>
                    </div>
                @endif
                @if ($validatedData['start_date'])
                    <div class="col-md-3">
                        <strong>Start Date:</strong><br>
                        <span class="badge badge-info">{{ \Carbon\Carbon::parse($validatedData['start_date'])->format('M j, Y') }}</span>
                    </div>
                @endif
                @if ($validatedData['end_date'])
                    <div class="col-md-3">
                        <strong>End Date:</strong><br>
                        <span class="badge badge-info">{{ \Carbon\Carbon::parse($validatedData['end_date'])->format('M j, Y') }}</span>
                    </div>
                @endif
                
                @if ($validatedData['branch'])
                    <div class="col-md-3">
                        <strong>Branch:</strong><br>
                        <span class="badge badge-success">{{$validatedData['branch'] }}</span>
                    </div>
                @endif
                @if ($validatedData['mode_of_transaction'])
                    <div class="col-md-3">
                        <strong>Method of Transaction:</strong><br>
                        <span class="badge badge-success">{{ ucfirst($validatedData['mode_of_payment']) }}</span>
                    </div>
                @endif
                @if ($validatedData['category'])
                    <div class="col-md-3">
                        <strong>Category:</strong><br>
                        <span class="badge badge-success">{{ ucfirst($validatedData['category']) }}</span>
                    </div>
                @endif
                @if ($validatedData['currency'])
                    <div class="col-md-3">
                        <strong>Currency:</strong><br>
                        <span class="badge badge-success">{{ ucfirst($validatedData['currency']) }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Detailed Transactions -->
        <h4 class="section-title"><i class="fas fa-list-ul"></i> Detailed Transactions</h4>
        {{-- @foreach ($sales as $sale) --}}
            {{-- <div class="category-title">
                <h5><i class="fas fa-folder-open"></i> {{ ucfirst($category) }} Payments</h5>
            </div> --}}
            {{-- @foreach ($currencies as $currency => $transactions) --}}
                {{-- <div class="currency-subtitle mb-2">
                    <h6><i class="fas fa-coins"></i> Currency: {{ $currency }}</h6>
                </div> --}}
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Item Name</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Mode of Transaction</th>
                                <th>Category</th>
                                <th>Currency</th>
                                <th>Branch</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $sale)
                                <tr>
                                    <td>{{ $sale->item_name }}</td>
                                    <td>{{ $sale->description }}</td>
                                    <td>{{ $sale->amount }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($sale->mode_of_transaction == 'Mobile Money') badge-success
                                            @elseif($sale->mode_of_transaction == 'Cash') badge-primary
                                            @else badge-warning @endif">
                                            {{ $sale->mode_of_transaction }}
                                        </span>
                                    </td>
                                    <td>{{ $sale->category ?? 'N/A' }}</td>
                                    <td>{{ $sale->currency ?? 'N/A' }}</td>
                                    <td>{{ $sale->branch ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($sale->created_at)->format('M j, Y h:i A') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            {{-- @endforeach --}}
        {{-- @endforeach --}}

        <!-- Summary Totals -->
        {{-- <h4 class="section-title"><i class="fas fa-calculator"></i> Summary Totals(Student Category)</h4>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>Category</th>
                        <th>Currency</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($totalsByCategoryAndCurrency as $category => $currencies)
                        @foreach ($currencies as $currency => $total)
                            <tr class="@if($loop->last) total-highlight @endif">
                                <td>{{ ucfirst($category) }}</td>
                                <td>{{ $currency }}</td>
                                <td><strong>{{ number_format($total, 2) }}</strong></td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>

        <h4 class="section-title"><i class="fas fa-calculator"></i> Summary Totals by Cash, Momo, Cheque</h4>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>Method of Payment</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <tr class=" ">
                        <td>Cash</td>
                        <td><strong>GHS{{ number_format($cashTotal, 2) }}</strong></td>
                    </tr>
                    <tr class=" ">
                        <td>Mobile Money(Momo)</td>
                        <td><strong>GHS{{ number_format($momoTotal, 2) }}</strong></td>
                    </tr>
                    <tr class=" ">
                        <td>Cheque</td>
                        <td><strong>GHS{{ number_format($chequeTotal, 2) }}</strong></td>
                    </tr>
                        
                    
                </tbody>
            </table>
        </div> --}}

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