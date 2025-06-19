<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Defer List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .report-title {
            font-size: 24px;
            font-weight: bold;
        }
        .report-date {
            font-size: 14px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
        <div class="header">
            <div class="logo-container"> 
                <img src="{{asset('logo\SIIMT-logo.png')}}" alt="Institution Logo" class="logo" style="width: 120px; height:90px">
            </div>
            <h2 class="report-title">SIIMT UNIVERSITY COLLEGE</h2>
            <h5 class="report-title">STUDENTS' DEFER LIST</h5>
            <div class="report-date">
                <i class="far fa-calendar-alt"></i> Generated on: {{ \Carbon\Carbon::now()->format('F j, Y h:i A') }}
            </div>
        </div>

    <table>
        <thead>
            <tr>
                <!-- <th>#</th> -->
                <th>Username</th>
                <th>Phone Number</th>
                <th>Index Number</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as  $student)
            <tr>
                <td>{{ $student->user_name }}</td>
                <td>{{ $student->phone}}</td>
                <td>{{ $student->index_number }}</td>
                <td>{{ $student->email }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Total Students: {{ count($students) }}
    </div>
</body>
</html>