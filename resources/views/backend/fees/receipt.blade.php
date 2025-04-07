<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 297mm;
            height: 105mm;
            box-sizing: border-box;
            font-size: 9pt;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f9f9f9;
        }
        .receipt-container {
            width: 270mm;
            height: 85mm;
            border: 1px solid #ddd;
            padding: 15mm;
            box-sizing: border-box;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }
        .header img {
            max-width: 80px;
            margin-bottom: 5px;
        }
        .header h1 {
            margin: 5px 0;
            font-size: 14pt;
            color: #2c3e50;
        }
        .header h3 {
            margin: 5px 0;
            font-size: 12pt;
            color: #3498db;
        }
        .details {
            margin-bottom: 15px;
        }
        .details h3 {
            margin: 10px 0 5px 0;
            font-size: 11pt;
            color: #2c3e50;
        }
        .details p {
            margin: 4px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 9pt;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        .receipt-number {
            font-size: 10pt;
            font-weight: bold;
            margin: 10px 0;
            padding: 5px;
            background-color: #f8f9fa;
            border: 1px dashed #ddd;
            text-align: center;
        }
        .footer {
            text-align: center;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 8pt;
            color: #7f8c8d;
        }
        .footer p {
            margin: 3px 0;
        }
        @media print {
            body {
                background-color: white;
            }
            .receipt-container {
                box-shadow: none;
                border: none;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="header">
            <img src="{{ asset('logo/SIIMT-logo.png') }}" alt="SIIMT University College Logo">
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
                    <th>Fees Type</th>
                    <td>{{ $feespaid->fees_type }}</td>
                </tr>
                <tr>
                    <th>Amount Paid</th>
                    <td>{{ $feespaid->currency }} {{ number_format($feespaid->amount, 2) }}</td>
                </tr>
                @if($feespaid->fees_type === 'School Fees')
                <tr>
                    <th>Balance</th>
                    <td>{{ $feespaid->currency }} {{ number_format($feespaid->balance, 2) }}</td>
                </tr>
                @endif
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

        <div class="receipt-number">
            <strong>Receipt Number:</strong> {{ $feespaid->receipt_number }}
        </div>

        <div class="footer">
            <p>Thank you for your payment!</p>
            <p>For any inquiries, please contact us at <strong>(+233) 057 080 1631</strong></p>        
            <p>&copy; {{ now()->format('Y') }} SIIMT University College. All rights reserved.</p>
        </div>
    </div>
</body>
</html>