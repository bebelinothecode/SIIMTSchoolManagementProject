<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <style>
        @page {
            /* A5 size (half of A4) */
            size: A5 portrait; 
            margin: 10mm;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: auto;
            height: auto;
            box-sizing: border-box;
            font-size: 8pt; /* Reduced font size */
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f9f9f9;
        }
        .receipt-container {
            width: 135mm;
            max-width: 128mm; 
            height: 195mm;
            border: 1px solid #ddd;
            padding: 10mm;
            box-sizing: border-box;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 2px solid #eee;
        }
        .header img {
            max-width: 60px;
            margin-bottom: 5px;
        }
        .header h1 {
            margin: 4px 0;
            font-size: 12pt;
            color: #2c3e50;
        }
        .header h3 {
            margin: 4px 0;
            font-size: 10pt;
            color: #3498db;
        }
        .details {
            margin-bottom: 10px;
        }
        .details h3 {
            margin: 8px 0 4px 0;
            font-size: 9pt;
            color: #2c3e50;
        }
        .details p {
            margin: 3px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            font-size: 8pt;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 3px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        .receipt-number {
            font-size: 9pt;
            font-weight: bold;
            margin: 8px 0;
            padding: 4px;
            background-color: #f8f9fa;
            border: 1px dashed #ddd;
            text-align: center;
        }
        .footer {
            text-align: center;
            margin-top: 10px;
            padding-top: 8px;
            border-top: 1px solid #ddd;
            font-size: 7pt;
            color: #7f8c8d;
        }
        .footer p {
            margin: 2px 0;
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
            <p><strong>Programme:</strong> {{ $student->course->course_name ?? $student->diploma->name }}</p>

            <h3>Payment Details</h3>
            <table>
                <tr>
                    <th>Fees Type</th>
                    <td>{{ $feespaid->fees_type }}</td>
                </tr>
                @if (($feespaid->amount ) && ($feespaid->amount !== '0'))
                    <tr>
                        <th>Amount Paid</th>
                        <td>{{ $feespaid->currency }} {{ number_format($feespaid->amount, 2) }}</td>
                    </tr>
                @endif
                @if(($feespaid->amount == '0') && ($feespaid->other_fees !== null))
                <tr>
                    <th>Other Fees Paid</th>
                    <td>{{ $feespaid->currency }} {{ number_format($feespaid->other_fees, 2) }}</td>
                </tr>
                @endif
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

                @if ($student->late_fees_charges !== '0')
                <tr>
                    <th>Late Fees Charges</th>
                    <td>{{ $student->late_fees_charges }}</td>
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
            <p>This is a system generated receipt.No need for signature</p>       
            <p>&copy; {{ now()->format('Y') }} SIIMT University College. All rights reserved.</p>
        </div>
    </div>
</body>
</html>