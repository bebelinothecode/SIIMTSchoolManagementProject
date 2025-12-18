<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admission Letter</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: "Times New Roman", serif;
            font-size: 13px;
            line-height: 1.3;
            position: relative;
            min-height: 297mm;
        }

        /* Watermark */
        .watermark {
            position: absolute;
            top: 40%;
            left: 10%;
            width: 80%;
            opacity: 0.05;
            z-index: -1;
            transform: translateY(-50%);
        }

        /* Main container */
        .letter-container {
            padding: 20mm;
            position: relative;
        }

        /* Header - Top aligned like PDF */
        .letterhead {
            margin-bottom: 10mm;
            text-align: center;
            position: relative;
        }

        .university-name {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 2px;
        }

        .contact-info {
            font-size: 12px;
            line-height: 1.2;
            margin-bottom: 3px;
        }

        .accreditation {
            font-size: 11px;
            font-style: italic;
            margin-top: 2px;
            padding-top: 2px;
            border-top: 1px solid #000;
        }

        /* Reference and Date section */
        .reference-section {
            margin: 15mm 0 5mm 0;
            font-size: 12px;
        }

        .reference-line {
            margin-bottom: 3px;
        }

        /* Main content */
        .content {
            font-size: 13px;
            line-height: 1.4;
        }

        .salutation {
            margin: 8mm 0 3mm 0;
        }

        .admission-title {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 5mm 0 4mm 0;
            text-align: center;
            text-decoration: underline;
        }

        .paragraph {
            margin-bottom: 3mm;
            text-align: justify;
        }

        .student-info {
            margin: 3mm 0;
            padding-left: 5mm;
        }

        .fee-table {
            width: 100%;
            border-collapse: collapse;
            margin: 3mm 0;
            font-size: 11px;
        }

        .fee-table th,
        .fee-table td {
            border: 1px solid #000;
            padding: 2mm;
            text-align: left;
        }

        .fee-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .bank-details {
            margin: 3mm 0;
            padding-left: 5mm;
        }

        .bank-details strong {
            display: block;
            margin-bottom: 1mm;
        }

        /* Numbered paragraphs */
        .numbered {
            margin-left: 5mm;
            text-indent: -5mm;
            margin-bottom: 2mm;
        }

        /* Closing section */
        .closing {
            margin-top: 15mm;
        }

        .signature {
            margin-top: 10mm;
            width: 60mm;
        }

        .signatory {
            font-weight: bold;
            margin-bottom: 1mm;
            text-decoration: underline;
        }

        .signatory-title {
            font-size: 11px;
        }

        .correspondence {
            margin-top: 8mm;
            font-size: 11px;
            line-height: 1.2;
        }

        .correspondence strong {
            display: block;
            margin-bottom: 1mm;
        }

        .congratulations {
            margin-top: 5mm;
            font-style: italic;
        }
    </style>
</head>

<body>
    <!-- Watermark -->
    <img src="{{ asset('logo/SIIMT-logo.png') }}" class="watermark">

    <div class="letter-container">
        <!-- Letterhead -->
        <div class="letterhead">
            <div class="university-name">SIIMT University College</div>
            <div class="contact-info">
                Tel No - 057 080 1631, 030 2269 885<br>
                Email - info@siimtuni.edu.gh<br>
                Address - Nima Kanda Overpass, Accra Asylum Down, Ghana<br>
                P. O. Box CT 139, Ghana
            </div>
            <div class="accreditation">
                (ACCREDITED BY GTEC | AFFILIATED TO UCC)
            </div>
        </div>

        <!-- Reference Section -->
        <div class="reference-section">
            {{-- <div class="reference-line"><strong>Ref. No. :</strong> SIIMT/{{ $student->index_number }}</div> --}}
            <div class="reference-line"><strong>Date:</strong> {{ date('d F Y') }}</div>
        </div>

        <!-- Main Content -->
        <div class="content">
            <!-- Recipient Address -->
            <div class="salutation">
                <strong>{{ $student->user->name }} ({{ $student->user->gender ?? 'Mr/Ms' }})</strong><br>
                {{ $student->user->address ?? 'Accra-Ghana' }}
            </div>

            <p class="salutation">Dear {{ $student->user->gender == 'Female' ? 'Ms.' : 'Mr.' }} {{ collect(explode(' ', $student->user->name ?? ''))->first() }}</p>

            <!-- Admission Title -->
            <div class="admission-title">
                ADMISSION TO @if($student->student_category === 'Academic') UNDER-GRADUATE PROGRAMME @else DIPLOMA/PROFESSIONAL PROGRAMME @endif 
                @if($student->admission_batch ?? false) ({{ $student->admission_batch }} BATCH ADMISSION) @endif
                AT SIIMT UNIVERSITY COLLEGE FOR THE @if(isset($letter_details)) {{ $letter_details['academic_year'] }} @elseif($academicyear) {{ $academicyear->startyear }}/{{ substr($academicyear->endyear, 2) }} @else {{ date('Y') }}/{{ substr(date('Y') + 1, 2) }} @endif ACADEMIC YEAR
            </div>

            <!-- Paragraph 1 -->
            <p class="paragraph">
                <strong>1.</strong> This is to inform you that @if($student->student_category === 'Academic' && ($student->entry_mode ?? '') === 'Mature') you were successful at the Mature Entrance Examinations, and @endif the Academic Board of SIIMT University College has admitted you to pursue a 
                @if($student->student_category === 'Academic')
                    degree programme in {{ $student->course->course_name ?? "N/A" }} level {{ $student->level ?? "N/A" }}, Semester - {{ $student->session ?? "N/A" }}.
                @else
                    Diploma/Professional course in {{ $student->diploma->name ?? "N/A" }}.
                @endif
                This will lead to the award of a 
                @if($student->student_category === 'Academic')
                    Bachelor of Science in {{ $student->course->course_name ?? "N/A" }} (BSc-{{ strtoupper(substr($student->course->course_code ?? 'IS', 0, 2)) }}) certificate by the University of Cape-Coast.
                @else
                    {{ $student->diploma->name ?? "N/A" }} certificate by the University of Cape-Coast.
                @endif
            </p>

            <div class="student-info">
                Your student ID Number is {{ $student->index_number }}. Your student number and programme of study should be quoted on all official documents.
            </div>

            @php
                $fees = $student->course->fees ?? $student->diploma->fees ?? 0;
                $amountToPaid = $fees - ($student->Scholarship_amount ?? 0);
            @endphp

            <!-- Fees Section -->
            @if($student->Scholarship === 'Yes')
                <p class="paragraph">
                    <strong>2.</strong> We are pleased to inform you that the academic board has offered you a scholarship on tuition fees.
                    Continuation of the scholarship will be based on academic progress requiring a GPA of 3.1 or higher every semester.
                    Below is the breakdown of your fees per semester:
                </p>

                <table class="fee-table">
                    <thead>
                        <tr>
                            <th>Actual Fees (GHC)</th>
                            <th>Tuition (GHC)</th>
                            <th>Other Charges (GHC)</th>
                            <th>Scholarship (GHC)</th>
                            <th>Payable (GHC)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ number_format($fees, 2) }}</td>
                            <td>{{ number_format($fees - 750, 2) }}</td>
                            <td>750.00</td>
                            <td>{{ number_format($student->Scholarship_amount ?? 0, 2) }}</td>
                            <td>{{ number_format($amountToPaid, 2) }}</td>
                        </tr>
                    </tbody>
                </table>

                <p class="paragraph">
                    Your school fees per semester is {{ number_format($amountToPaid, 2) }}.
                </p>
            @else
                <p class="paragraph">
                    <strong>2.</strong> School fees for the first semester is GH¢{{ number_format($fees, 2) }}
                </p>
            @endif

            <p class="paragraph">
                Please note that the tuition fees quoted above includes tuition, sundry charges, identity card and Students Representative Council (SRC) Dues.
            </p>

            <p class="paragraph">
                The School fees of GH¢{{ number_format($student->Scholarship === 'Yes' ? $amountToPaid : $fees, 2) }} should be paid into:
            </p>

            <!-- Bank Details -->
            <div class="bank-details">
                <strong>ACCOUNT NAME: SIIMT UNIVERSITY COLLEGE</strong>
                <strong>BANK NAME : ECOBANK LTD</strong>
                <strong>BRANCH : LABONE</strong>
                <strong>GH¢ ACCOUNT : 1441002146601</strong>
            </div>

            <!-- Additional Information -->
            <p class="numbered"><strong>3.</strong> School resumes for freshmen and women on @if(isset($letter_details)){{ $letter_details['resumption_date_formatted'] }}@else Monday, 17 February 2025. Registration begins from @if(isset($letter_details)){{ $letter_details['registration_start_date_formatted'] }} to {{ $letter_details['registration_end_date_formatted'] }}@else Monday, 17 February 2025 to Monday, 24 February 2025@endif.</p>
            <p class="numbered"><strong>4.</strong> The original receipt for payment of school fees and the original letter of admission are required for registration.</p>
            <p class="numbered"><strong>5.</strong> You are required to be declared medically fit by a qualified Medical Officer. This will be arranged during orientation.</p>
            <p class="numbered"><strong>6.</strong> Orientation is compulsory for all freshmen on @if(isset($letter_details)){{ $letter_details['orientation_date_formatted'] }}@else Friday 28 February 2025@endif.</p>
            <p class="numbered"><strong>7.</strong> Lectures begin on @if(isset($letter_details)){{ $letter_details['lectures_begin_date_formatted'] }}@else Monday 24 February 2025@endif.</p>
            <p class="numbered"><strong>8.</strong> School fees are subject to adjustment based on economic conditions.</p>
            <p class="numbered"><strong>9.</strong> If you accept this offer, please arrange to pay at least 70% of your fees at any Ecobank branch and submit the slip to the Finance Office.</p>

            <!-- Correspondence -->
            <div class="correspondence">
                <strong>All correspondence regarding admission should be addressed to:</strong><br>
                <strong>THE REGISTRAR,</strong><br>
                <strong>SIIMT University College,</strong><br>
                <strong>P.O. BOX CT 139, CANTONMENT ACCRA</strong><br>
                <strong>Tel: 0302 269 885</strong>
            </div>

            <!-- Congratulations -->
            <p class="congratulations">We congratulate you on your admission to SIIMT University College.</p>

            <!-- Signature -->
            <div class="signature">
                <p>Yours sincerely,</p>
                <p class="signatory">Yvonne Owiredu (Mrs)</p>
                <p class="signatory-title">For: Registrar</p>
            </div>
        </div>
    </div>
</body>
</html>