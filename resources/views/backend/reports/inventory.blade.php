<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Report</title>

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
        <!-- Header -->
        <div class="header">
            <div class="logo-container">
                <img src="{{ asset('logo/SIIMT-logo.png') }}" alt="Institution Logo" class="logo">
            </div>
            <h2 class="report-title">SIIMT UNIVERSITY COLLEGE</h2>
            <h5 class="report-title">INVENTORY MANAGEMENT REPORT</h5>
            <div class="report-date">
                <i class="far fa-calendar-alt"></i> Generated on: {{ \Carbon\Carbon::now()->format('F j, Y h:i A') }}
            </div>
        </div>

        <!-- Filters Section -->
        <div class="filters-section">
            <h4><i class="fas fa-filter"></i> Filters Applied</h4>
            <div class="row">
                @if ($current_date)
                    <div class="col-md-3">
                        <strong>Current Date:</strong><br>
                        <span class="badge badge-primary">{{ \Carbon\Carbon::parse($current_date)->format('M j, Y') }}</span>
                    </div>
                @endif
               
                @if ($end_date)
                    <div class="col-md-3">
                        <strong>End Date:</strong><br>
                        <span class="badge badge-info">{{ \Carbon\Carbon::parse($end_date)->format('M j, Y') }}</span>
                    </div>
                @endif
                @if ($category)
                    <div class="col-md-3">
                        <strong>Category:</strong><br>
                        <span class="badge badge-success">{{ ucfirst($category) }}</span>
                    </div>
                @endif
                @if ($current_state)
                    <div class="col-md-3">
                        <strong>Current State:</strong><br>
                        <span class="badge badge-warning">Enabled</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Report Data -->
        @if(isset($type) && $type === 'Current State')
            <h4 class="section-title"><i class="fas fa-boxes"></i> Current Stock Overview</h4>
            <div class="mb-3">
                <strong>Total Stock Items:</strong> {{ $total_stocks }}<br>
                <strong>Total Quantity:</strong> {{ $total_quantity }}
            </div>

            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>Stock Name</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td>{{ $item->stock_name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->unit_of_measure }}</td>
                            <td>{{ $item->location }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @elseif($category === 'Stock In')
            <h4 class="section-title"><i class="fas fa-arrow-circle-down"></i> Stock In Records</h4>
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Stock Name</th>
                        <th>Old Qty</th>
                        <th>New Qty</th>
                        <th>Total After In</th>
                        <th>Notes</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td>{{ $item->stock->stock_name ?? 'N/A' }}</td>
                            <td>{{ $item->old_stock_in_quantity }}</td>
                            <td>{{ $item->new_stock_in_quantity }}</td>
                            <td>{{ $item->total_stock_after_in }}</td>
                            <td>{{ $item->notes }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('M j, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @elseif($category === 'Stock Out')
            <h4 class="section-title"><i class="fas fa-arrow-circle-up"></i> Stock Out Records</h4>
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Stock Name</th>
                        <th>Qty Issued</th>
                        <th>Issued To</th>
                        <th>Issued By</th>
                        <th>Date Issued</th>
                        <th>Date Returned</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td>{{ $item->stock->stock_name ?? 'N/A' }}</td>
                            <td>{{ $item->quantity_issued }}</td>
                            <td>{{ $item->issued_to }}</td>
                            <td>{{ $item->issued_by }}</td>
                            <td>{{ $item->date_issued }}</td>
                            <td>{{ $item->date_returned ?? '-' }}</td>
                            <td>{{ $item->notes ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @elseif($category === 'Total')
            <h4 class="section-title"><i class="fas fa-layer-group"></i> Combined Inventory Summary</h4>

            <!-- Stock In Section -->
            <div class="category-title">
                <h5><i class="fas fa-arrow-circle-down text-success"></i> Stock In Summary</h5>
            </div>
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Stock Name</th>
                        <th>New Qty</th>
                        <th>Total After In</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['stockIns'] as $item)
                        <tr>
                            <td>{{ $item->stock->stock_name ?? 'N/A' }}</td>
                            <td>{{ $item->new_stock_in_quantity }}</td>
                            <td>{{ $item->total_stock_after_in }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('M j, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Stock Out Section -->
            <div class="category-title">
                <h5><i class="fas fa-arrow-circle-up text-danger"></i> Stock Out Summary</h5>
            </div>
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Stock Name</th>
                        <th>Qty Issued</th>
                        <th>Issued To</th>
                        <th>Date Issued</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['stockOuts'] as $item)
                        <tr>
                            <td>{{ $item->stock->stock_name ?? 'N/A' }}</td>
                            <td>{{ $item->quantity_issued }}</td>
                            <td>{{ $item->issued_to }}</td>
                            <td>{{ $item->date_issued }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> No data to display. Please select filters and generate a report.
            </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>This report was automatically generated by the SIIMT Inventory Management System</p>
            <p><i class="far fa-copyright"></i> {{ date('Y') }} - All Rights Reserved</p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
