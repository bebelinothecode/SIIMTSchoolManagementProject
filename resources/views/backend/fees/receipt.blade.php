<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .details {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        .footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('logo/SIIMT-logo.png') }}" alt="Institution Logo">
        <h1>SIIMT University College, Ghana</h1>
        <h3>Payment Receipt</h3>
        <p><strong>Date:</strong> {{ now()->format('F d, Y') }}</p>
    </div>

    <div class="details">
        <h3>Student Details</h3>
        <p><strong>Index Number:</strong> {{ $feespaid->student_index_number }}</p>
        <p><strong>Name:</strong> {{ $feespaid->student_name }}</p>

        <h3>Payment Details</h3>
        <table>
            <tr>
                <th>Amount Paid</th>
                <td>{{ $feespaid->currency }} {{ number_format($feespaid->amount, 2) }}</td>
            </tr>
            <tr>
                <th>Balance</th>
                <td>{{ $feespaid->currency }} {{ number_format($feespaid->balance, 2) }}</td>
            </tr>
            <tr>
                <th>Method of Payment</th>
                <td>{{ $feespaid->method_of_payment }}</td>
            </tr>
            @if ($feespaid->cheque_number)
            <tr>
                <th>Cheque Number</th>
                <td>{{ $feespaid->cheque_number }}</td>
            </tr>
            @endif
            @if ($feespaid->Momo_number)
            <tr>
                <th>MoMo Number</th>
                <td>{{ $feespaid->Momo_number }}</td>
            </tr>
            @endif
        </table>
    </div>

    <div class="footer">
        <p>Thank you for your payment!</p>
        <p>For any inquiries, please contact us at <strong>(+233) 057 080 1631</strong></p>        
        <p>&copy; {{ now()->format('Y') }} Institution Name. All rights reserved.</p>
    </div>
</body>
</html>