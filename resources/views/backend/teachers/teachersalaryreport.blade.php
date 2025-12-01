<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Salary Report</title>
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
            <h5 class="report-title">TEACHER SALARY REPORT</h5>
            <div class="report-date">
                <i class="far fa-calendar-alt"></i> Report for {{ \Carbon\Carbon::create($validatedData['year'], $validatedData['month'], 1)->format('F Y') }}
            </div>
            <div class="report-date">
                <i class="fas fa-user"></i> Teacher: {{ $teacher->user->name ?? 'N/A' }}
            </div>
        </div>

        <!-- Teacher Information -->
        <h4 class="section-title"><i class="fas fa-user"></i> Teacher Information</h4>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td><strong>Name:</strong></td>
                        <td>{{ $teacher->user->name ?? 'N/A' }}</td>
                        <td><strong>Email:</strong></td>
                        <td>{{ $teacher->user->email ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Phone:</strong></td>
                        <td>{{ $teacher->phone ?? 'N/A' }}</td>
                        <td><strong>Gender:</strong></td>
                        <td>{{ $teacher->gender ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Employment Type:</strong></td>
                        <td>{{ $teacher->employment_type ?? 'N/A' }}</td>
                        <td><strong>Address:</strong></td>
                        <td>{{ $teacher->current_address ?? 'N/A' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Salary Breakdown -->
        <h4 class="section-title"><i class="fas fa-calculator"></i> Salary Breakdown</h4>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>Session Type</th>
                        <th>Number of Sessions</th>
                        <th>Rate per Session</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Weekday Sessions</td>
                        <td>{{ $salaryData['weekday_sessions'] }}</td>
                        <td>GHS 120.00</td>
                        <td>GHS {{ number_format($salaryData['weekday_sessions'] * 120, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Weekend Sessions</td>
                        <td>{{ $salaryData['weekend_sessions'] }}</td>
                        <td>GHS 250.00</td>
                        <td>GHS {{ number_format($salaryData['weekend_sessions'] * 250, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Online Sessions</td>
                        <td>{{ $salaryData['online_sessions'] }}</td>
                        <td>GHS 100.00</td>
                        <td>GHS {{ number_format($salaryData['online_sessions'] * 100, 2) }}</td>
                    </tr>
                    <tr class="total-highlight">
                        <td><strong>Gross Total</strong></td>
                        <td><strong>{{ $salaryData['weekday_sessions'] + $salaryData['weekend_sessions'] + $salaryData['online_sessions'] }}</strong></td>
                        <td></td>
                        <td><strong>GHS {{ number_format($salaryData['total_amount'], 2) }}</strong></td>
                    </tr>
                    <tr>
                        <td>Withholding Tax (3%)</td>
                        <td></td>
                        <td></td>
                        <td>GHS {{ number_format($salaryData['withholding_tax'], 2) }}</td>
                    </tr>
                    <tr class="total-highlight">
                        <td><strong>Net Amount</strong></td>
                        <td></td>
                        <td></td>
                        <td><strong>GHS {{ number_format($salaryData['amount_after_tax'], 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Subjects with Remaining Sessions -->
        <h4 class="section-title"><i class="fas fa-book"></i> Assigned Subjects with Remaining Sessions</h4>
        @if($subjectsWithRemainingSessions->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Subject Name</th>
                            <th>Subject Code</th>
                            <th>Remaining Sessions</th>
                            <th>Academic/Professional</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subjectsWithRemainingSessions as $subjectAssignment)
                            <tr>
                                <td>{{ $subjectAssignment->subject->name ?? 'N/A' }}</td>
                                <td>{{ $subjectAssignment->subject->code ?? 'N/A' }}</td>
                                <td>{{ $subjectAssignment->remaining_sessions }}</td>
                                <td>{{ $subjectAssignment->aca_prof ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted">No subjects with remaining sessions.</p>
        @endif

        <!-- Attendance Records -->
        <h4 class="section-title"><i class="fas fa-calendar-check"></i> Attendance Records for {{ \Carbon\Carbon::create($validatedData['year'], $validatedData['month'], 1)->format('F Y') }}</h4>
        @if($teacher->attendances->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Date</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teacher->attendances as $attendance)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($attendance->attendence_date)->format('M j, Y') }}</td>
                                <td>{{ $attendance->subject->name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge {{ $attendance->attendence_status == 'present' ? 'badge-success' : 'badge-danger' }}">
                                        {{ ucfirst($attendance->attendence_status) }}
                                    </span>
                                </td>
                                <td>{{ $attendance->type }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted">No attendance records for this period.</p>
        @endif

        <!-- Payment History -->
        <h4 class="section-title"><i class="fas fa-money-bill-wave"></i> Payment History</h4>
        @if($teacher->payments->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Receipt No.</th>
                            <th>Gross Amount</th>
                            <th>Tax</th>
                            <th>Net Amount</th>
                            <th>Method</th>
                            <th>Paid At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teacher->payments as $payment)
                            <tr>
                                <td>{{ $payment->receipt_number }}</td>
                                <td>GHS {{ number_format($payment->gross_amount, 2) }}</td>
                                <td>GHS {{ number_format($payment->withholding_tax, 2) }}</td>
                                <td>GHS {{ number_format($payment->net_amount, 2) }}</td>
                                <td>{{ $payment->method ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($payment->paid_at)->format('M j, Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted">No payment records found.</p>
        @endif

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