<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Detailed Report</title>

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
            <h5 class="report-title">INVENTORY DETAILED REPORT</h5>
            <div class="report-date">
                <i class="far fa-calendar-alt"></i> Generated on: {{ \Carbon\Carbon::now()->format('F j, Y h:i A') }}
            </div>
        </div>

        <!-- Item Details -->
        <div class="filters-section">
            <h4><i class="fas fa-info-circle"></i> Item Details</h4>
            <div class="row">
                <div class="col-md-6">
                    <strong>Stock Name:</strong><br>
                    <span class="badge badge-primary">{{ $stock->stock_name ?? 'Item' }}</span>
                </div>
                <div class="col-md-6">
                    <strong>Current Amount:</strong><br>
                    <span class="badge badge-success">{{ $current_amount }}</span>
                </div>
            </div>
        </div>

        <!-- Stock In Section -->
        <h4 class="section-title"><i class="fas fa-arrow-circle-down"></i> Stock In Records</h4>
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Quantity</th>
                    <th>Reference</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ins as $in)
                    <tr>
                        <td>{{ optional($in->created_at)->format('Y-m-d') }}</td>
                        <td>{{ $in->new_stock_in_quantity }}</td>
                        <td>{{ $in->reference ?? $in->notes ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3">No stock in records</td></tr>
                @endforelse
            </tbody>
        </table>

        <!-- Stock Out Section -->
        <h4 class="section-title"><i class="fas fa-arrow-circle-up"></i> Stock Out Records</h4>
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>Date Issued</th>
                    <th>Quantity</th>
                    <th>Reference</th>
                </tr>
            </thead>
            <tbody>
                @forelse($outs as $out)
                    <tr>
                        <td>{{ optional($out->date_issued)->format('Y-m-d') }}</td>
                        <td>{{ $out->quantity_issued }}</td>
                        <td>{{ $out->reference ?? $out->notes ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3">No stock out records</td></tr>
                @endforelse
            </tbody>
        </table>

        <!-- Back Button -->
        <div class="text-center mt-4">
            <a href="{{ route('inventoryreport.form') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Inventory Report</a>
        </div>

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
