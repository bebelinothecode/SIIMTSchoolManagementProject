<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enquiry Reports</title>
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
                <img src="{{ asset('logo/SIIMT-logo.png') }}" alt="Institution Logo" class="logo">
            </div>
            <h2 class="report-title">SIIMT UNIVERSITY COLLEGE</h2>
            <h5 class="report-title">ENQUIRY REPORT</h5>
            <div class="report-date">
                <i class="far fa-calendar-alt"></i> Generated on: {{ \Carbon\Carbon::now()->format('F j, Y h:i A') }}
            </div>
        </div>

        <!-- Filters Section -->
        <div class="filters-section">
            <h4><i class="fas fa-filter"></i> Filters Applied</h4>
            <div class="row">
                @if (!empty($validatedData['acaProf']))
                    <div class="col-md-3">
                        <strong>Type of Course:</strong><br>
                        <span class="badge badge-primary">{{ $validatedData['acaProf'] }}</span>
                    </div>
                @endif
                @if (!empty($validatedData['start_date']))
                    <div class="col-md-3">
                        <strong>Start Date:</strong><br>
                        <span class="badge badge-info">{{ \Carbon\Carbon::parse($validatedData['start_date'])->toFormattedDateString() }}</span>
                    </div>
                @endif
                @if (!empty($validatedData['current_date']))
                    <div class="col-md-3">
                        <strong>Current Date:</strong><br>
                        <span class="badge badge-info">{{ \Carbon\Carbon::parse($validatedData['current_date'])->toFormattedDateString() }}</span>
                    </div>
                @endif
                @if (!empty($validatedData['end_date']))
                    <div class="col-md-3">
                        <strong>End Date:</strong><br>
                        <span class="badge badge-info">{{ \Carbon\Carbon::parse($validatedData['end_date'])->toFormattedDateString() }}</span>
                    </div>
                @endif
                @if (!empty($validatedData['branch']))
                    <div class="col-md-3">
                        <strong>Branch:</strong><br>
                        <span class="badge badge-success">{{ $validatedData['branch'] }}</span>
                    </div>
                @endif
                @if ($course->course_name ?? null)
                    <div class="col-md-3">
                        <strong>Course (Academic):</strong><br>
                        <span class="badge badge-success">{{ $course->course_name }}</span>
                    </div>
                @endif
                @if ($diploma->name ?? null)
                    <div class="col-md-3">
                        <strong>Diploma (Professional):</strong><br>
                        <span class="badge badge-success">{{ $diploma->name }}</span>
                    </div>
                @endif
                @if (!empty($validatedData['source_of_enquiry']))
                    <div class="col-md-3">
                        <strong>Source of Enquiry:</strong><br>
                        <span class="badge badge-success">{{ $validatedData['source_of_enquiry'] }}</span>
                    </div>
                @endif
                @if (!empty($validatedData['preferred_time']))
                    <div class="col-md-3">
                        <strong>Preferred Time:</strong><br>
                        <span class="badge badge-success">{{ $validatedData['preferred_time'] }}</span>
                    </div>
                @endif
                @if (!empty($count))
                    <div class="col-md-3">
                        <strong>Count:</strong><br>
                        <span class="badge badge-success">{{ $count }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Detailed Transactions -->
        <h4 class="section-title"><i class="fas fa-list-ul"></i> Details</h4>
        <div class="table-responsive">
            <table class="table table-sm table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Interested Course/Diploma</th>
                        <th>Expected Start Date</th>
                        <th>Source of Enquiry</th>
                        <th>Preferred Time</th>
                        <th>Method of Payment</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($datas as $data)
                        <tr class="{{ $data->bought_forms === 'Yes' ? 'table-success' : '' }}">
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->telephone_number }}</td>
                            <td>{{ $data->course->course_name ?? $data->diploma->name ?? $data->interested_course ?? "N/A" }}</td>
                            <td>{{ $data->expected_start_date ?? 'N/A' }}</td>
                            <td>{{ $data->source_of_enquiry ?? 'N/A' }}</td>
                            <td>{{ $data->preferred_time ?? 'N/A' }}</td>
                            <td>
                                {{ $data->bought_forms === 'Yes' ? ($data->method_of_payment ?? 'N/A') : 'Not Applicable' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No enquiries found for the selected filters.</td>
                        </tr>
                    @endforelse
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
