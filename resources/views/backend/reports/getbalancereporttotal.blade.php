<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance Report (Total)</title>
    <style>
        /* Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.4;
            color: #333;
            background-color: #f8f9fa;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        /* Header Section */
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" patternUnits="userSpaceOnUse" width="100" height="100"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grain)"/></svg>');
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }

        .header .date {
            font-size: 16px;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        /* Content Area */
        .content {
            padding: 30px;
        }

        /* Summary Card */
        .summary-section {
            margin-bottom: 40px;
        }

        .summary-card {
            background: #f8f9ff;
            border: 2px solid #e3e8ff;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            position: relative;
        }

        .summary-card::before {
            content: '💰';
            position: absolute;
            top: 20px;
            right: 25px;
            font-size: 24px;
        }

        .summary-card h2 {
            color: #4c51bf;
            font-size: 20px;
            margin-bottom: 20px;
            border-bottom: 2px solid #e3e8ff;
            padding-bottom: 10px;
        }

        /* Table Styles */
        .table-section {
            margin-bottom: 40px;
        }

        .table-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 3px solid #e2e8f0;
        }

        .table-header h3 {
            color: #2d3748;
            font-size: 18px;
            margin: 0;
        }

        .table-icon {
            width: 24px;
            height: 24px;
            margin-right: 10px;
            background: #4c51bf;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 14px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: top;
        }

        tr:nth-child(even) {
            background-color: #f7fafc;
        }

        tr:hover {
            background-color: #edf2f7;
        }

        /* Footer Row Styling */
        tfoot td {
            background: #2d3748;
            color: white;
            font-weight: bold;
            padding: 15px 12px;
            border: none;
        }

        /* Amount Highlighting */
        .amount {
            font-weight: 600;
            color: #2b6cb0;
        }

        .total-amount {
            font-size: 18px;
            font-weight: bold;
            color:rgb(254, 254, 255);
        }

        /* Status Indicators */
        .status-positive {
            color: #38a169;
            font-weight: 600;
        }

        .status-negative {
            color:rgb(245, 88, 88);
            font-weight: 600;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #718096;
            font-style: italic;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .container {
                border-radius: 0;
            }

            .header {
                padding: 20px;
            }

            .header h1 {
                font-size: 24px;
            }

            .content {
                padding: 20px;
            }

            table {
                font-size: 12px;
            }

            th, td {
                padding: 8px 6px;
            }
        }

        /* Print Styles - Minimal Ink */
        @media print {
            body {
                background: white !important;
                color: black !important;
                padding: 0;
                font-size: 13px;
                line-height: 1.3;
            }

            .container {
                box-shadow: none !important;
                border-radius: 0 !important;
                border: 1px solid #ccc !important;
            }

            .header {
                background: white !important;
                color: black !important;
                padding: 10px;
                border-bottom: 1px solid #ccc;
            }

            th {
                background: #f0f0f0 !important;
                color: black !important;
                font-weight: bold;
                border: 1px solid #ddd;
                padding: 8px;
            }

            td {
                border: 1px solid #ddd !important;
                color: black !important;
                padding: 6px;
            }

            tr:nth-child(even),
            tr:hover {
                background: white !important;
            }

            tfoot td {
                background: #f0f0f0 !important;
                color: black !important;
                font-weight: bold;
                border-top: 2px solid #000 !important;
            }

            .summary-card {
                background: white !important;
                border: 1px solid #ccc !important;
                color: black !important;
                page-break-inside: avoid;
            }

            .summary-card::before,
            .table-icon {
                display: none !important;
            }

            .amount,
            .status-positive,
            .status-negative {
                color: black !important;
                font-weight: bold;
            }

            .total-amount {
                background: #f0f0f0 !important;
                color: black !important;
                font-weight: bold;
                border: 1px solid #000 !important;
                padding: 4px;
            }

            .table-section {
                page-break-inside: avoid;
            }

            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Balance Report (Professional + Academic)</h1>
            <div class="date">{{ $currentDate }}</div>
        </div>

        <div class="content">
            <!-- Financial Summary -->
            <div class="summary-section">
                <div class="summary-card">
                    <h2>Financial Summary - Daily Balance Overview</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Opening Balance</th>
                                <th>Daily Income</th>
                                <th>Daily Expenses</th>
                                <th>Closing Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dailyBalances as $date => $balance)
                                <tr>
                                    <td><strong>{{ $date }}</strong></td>
                                    <td class="amount">GHS {{ number_format($balance['opening_balance'], 2) }}</td>
                                    <td class="amount status-positive">GHS {{ number_format($balance['total_daily_income'], 2) }}</td>
                                    <td class="amount status-negative">GHS {{ number_format($balance['daily_expenses'], 2) }}</td>
                                    <td class="amount"><strong>GHS {{ number_format($balance['closing_balance'], 2) }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Payments Section -->
            <div class="table-section">
                <div class="table-header">
                    <div class="table-icon">P</div>
                    <h3>Student Fee Payments</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Student Index</th>
                            <th>Student Name</th>
                            <th>Amount</th>
                            <th>Balance</th>
                            <th>Currency</th>
                            <th>Payment Method</th>
                            <th>Receipt No.</th>
                            <th>Fee Type</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($feeCollectionTransactions as $t)
                        <tr>
                            <td><strong>{{ $t->student_index_number ?? "N/A" }}</strong></td>
                            <td>{{ $t->student_name ?? "N/A" }}</td>
                            <td class="amount">{{ $t->amount ?? "N/A" }}</td>
                            <td class="amount">{{ $t->balance ?? "N/A" }}</td>
                            <td>{{ $t->currency ?? "N/A" }}</td>
                            <td>{{ $t->method_of_payment }}</td>
                            <td>{{ $t->receipt_number ?? "N/A" }}</td>
                            <td>{{ $t->fees_type }}</td>
                            <td>{{ $t->created_at }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="empty-state">No payment records found</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"><strong>Total Payments</strong></td>
                            <td colspan="7" class="total-amount">GHS {{ number_format($feesPaymentsTotal, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Form Fees Section -->
            <div class="table-section page-break">
                <div class="table-header">
                    <div class="table-icon">F</div>
                    <h3>Form Fee Collections</h3>
                </div>
                <table>
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
                        @forelse ($formFeesBebelinos as $f)
                        <tr>
                            <td>{{ $f->name ?? "N/A" }}</td>
                            <td>{{ $f->telephone_number ?? "N/A" }}</td>
                            <td>{{ $f->currency ?? "N/A" }}</td>
                            <td class="amount">{{ $f->amount ?? "N/A" }}</td>
                            <td>{{ $f->created_at ?? "N/A" }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="empty-state">No form fee records found</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"><strong>Total Form Fees</strong></td>
                            <td colspan="2" class="total-amount">GHS {{ number_format($formFeesAllAmount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Mature Students Section -->
            <div class="table-section">
                <div class="table-header">
                    <div class="table-icon">M</div>
                    <h3>Mature Student Transactions</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Currency</th>
                            <th>Amount</th>
                            <th>Index Number</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($matureTransactions as $m)
                        <tr>
                            <td>{{ $m->name ?? "N/A" }}</td>
                            <td>{{ $m->currency ?? "N/A" }}</td>
                            <td class="amount">{{ $m->amount_paid ?? "N/A" }}</td>
                            <td><strong>{{ $m->mature_index_number ?? "N/A" }}</strong></td>
                            <td>{{ $m->created_at ?? "N/A" }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="empty-state">No mature student records found</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"><strong>Total Mature Payments</strong></td>
                            <td colspan="3" class="total-amount">GHS {{ number_format($matureTransactionsTotal, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Expenses Section -->
            <div class="table-section page-break">
                <div class="table-header">
                    <div class="table-icon">E</div>
                    <h3>Expenses Overview</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Source</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($expensesTransactions as $e)
                        <tr>
                            <td>{{ $e->source_of_expense ?? "N/A" }}</td>
                            <td>{{ $e->description_of_expense ?? "N/A" }}</td>
                            <td>{{  $e->expenseCategory->expense_category ?? $e->category ?? "N/A"}}</td>
                            <td class="amount status-negative">{{ $e->amount ?? "N/A" }}</td>
                            <td>{{ $e->mode_of_payment ?? "N/A" }}</td>
                            <td>{{ $e->created_at }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="empty-state">No expense records found</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"><strong>Total Expenses</strong></td>
                            <td colspan="3" class="total-amount status-negative">GHS {{ number_format($expensesTotalAmount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Collections by Category -->
            <div class="table-section">
                <div class="table-header">
                    <div class="table-icon">C</div>
                    <h3>Collections by Category & Payment Method</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Cash</th>
                            <th>Mobile Money</th>
                            <th>Bank Transfer</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($balanceByCategoryAndMode as $category => $modes)
                            <tr>
                                <td><strong>{{ $category }}</strong></td>
                                <td class="amount">GHS {{ number_format($modes['Cash'] ?? 0, 2) }}</td>
                                <td class="amount">GHS {{ number_format($modes['Momo'] ?? 0, 2) }}</td>
                                <td class="amount">GHS {{ number_format($modes['Cheque'] ?? 0, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
