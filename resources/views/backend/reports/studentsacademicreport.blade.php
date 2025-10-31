<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Report</title>
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
            <h5 class="report-title">STUDENTS REPORT</h5>
            <div class="report-date">
                <i class="far fa-calendar-alt"></i> Generated on: {{ \Carbon\Carbon::now()->format('F j, Y h:i A') }}
            </div>
            <!-- Download Button -->
            <div class="text-right mt-2">
                <a href="{{ route('students.report.download', request()->all()) }}" class="btn btn-success">
                    <i class="fas fa-download"></i> Download Report
                </a>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="filters-section">
            <h4><i class="fas fa-filter"></i> Filters Applied</h4>
            <div class="row">
                @if ($level)
                    <div class="col-md-3">
                        <strong>Level :</strong><br>
                        <span class="badge badge-primary">{{ $level }}</span>
                    </div>
                @endif
                @if ($semester)
                    <div class="col-md-3">
                        <strong>Semester:</strong><br>
                        <span class="badge badge-primary">{{ $semester }}</span>
                    </div>
                @endif
                @if ($acaProf)
                    <div class="col-md-3">
                        <strong>Course/Diploma:</strong><br>
                        <span class="badge badge-primary">{{ $acaProf }}</span>
                    </div>
                @endif
                @if ($branch)
                    <div class="col-md-3">
                        <strong>Branch:</strong><br>
                        <span class="badge badge-primary">{{ $branch }}</span>
                    </div>
                @endif
                  @if ($nationality)
                    <div class="col-md-3">
                        <strong>Nationality:</strong><br>
                        <span class="badge badge-primary">{{ $nationality }}</span>
                    </div>
                @endif

                    @if ($status)
                    <div class="col-md-3">
                        <strong>Status:</strong><br>
                        <span class="badge badge-primary">{{ $status }}</span>
                    </div>
                @endif
                
                @if ($totalStudents)
                    <div class="col-md-3">
                        <strong>Total Student Count:</strong><br>
                        <span class="badge badge-primary">{{ $totalStudents }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Detailed Transactions -->
        <h4 class="section-title"><i class="fas fa-list-ul"></i> Students Report List</h4>
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Index No.</th>
                                <th>Student Name</th>
                                <th>Phone Number</th>
                                <th>Fees</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr>
                                    <td>{{ $student->index_number }}</td>
                                    <td>{{ $student->user->name ?? "N/A" }}</td>
                                    <td>{{ $student->phone ?? "N/A" }}</td>
                                    <td>{{ $student->course->fees ?? $student->diploma->fees ?? "N/A" }}</td>
                                    <td>{{ number_format($student->balance,2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>