<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Slips Report</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom CSS for layout */
        .logo-text {
            display: flex;
            align-items: center;
        }

        .logo-img {
            max-width: 100px;
            /* Adjust size as needed */
            margin-right: 10px;
            /* Adjust spacing as needed */
        }
    </style>
</head>

<body>
    <div class="container">

        @php
            $groupedPayments = $payslipReports->groupBy('period');
        @endphp
        <!-- Table -->
        <div id="printable-area" class="table-responsive">
            @foreach ($groupedPayments as $period => $records)

                @foreach ($records as $psr)
                    <div class="payslip page-break">
                        <div class="ms-3 row mb-5 mt-5 me-2">
                            <div class="col-2">
                                <img src="https://fastpaymita.com/images/logo.png" alt="Logo" class="logo-img">
                            </div>
                            <div class="col-6">
                                <span
                                    style="font-weight: bold; font-size:24px; display:block;">{{ $workgroup }}</span>
                                <span style="font-size:16px; display:block;">PAYSLIP For
                                    {{ $period }}</span>
                                    <span style="font-size:10px;">Generated @
                                        {{ date('Y-m-d H:i A') }}</span>
                            </div>
                            <div class="col-4 text-end">
                                <span class="text-end" style="font-size:10px;">
                                    <img src="https://fastpaymita.com/images/kogi_logo.png" alt="Logo" class="logo-img">
                                </span>
                            </div>

                        </div>
                        <h3 class="ms-3">
                            <strong>{{ $psr->full_name }}
                                ({{ $psr->employee_number }})
                            </strong>
                        </h3>
                        <table class="table table-borderless " style="font-size:12px;">
                            <tr>
                                <th style="width:25%">Period:</th>
                                <td style="width:35%">{{ $psr->period }}</td>
                                <th style="width:15%">Department:</th>
                                <td style="width:30%">
                                    {{ $psr->department }}</td>
                            </tr>
                            <tr>
                                <th>Pay Group:</th>
                                <td>{{ $psr->paygroup }}</td>
                                <th>Unit:</th>
                                <td>{{ $psr->unit }}</td>
                            </tr>
                            <tr>
                                <th>Rank:</th>
                                <td>{{ $psr->rank }}</td>
                                <th>Bank:</th>
                                <td>{{ $psr->bank }}</td>
                            </tr>
                            <tr>
                                <th>Branch:</th>
                                <td>{{ $psr->branch }}</td>
                                <th>Account Number:</th>
                                <td>{{ $psr->account_number }}</td>
                            </tr>
                        </table>
                        <table id="" class="table mt-5 mb-0 text-nowrap table-centered "
                            style="font-size:12px; border-top: 1px solid #e2e8f0">
                            <thead class="" style="background: #e4eaf2;">
                                <tr>
                                    <th colspan="5" style="color: black">PAY
                                        ITEMS</th>
                                </tr>
                            </thead>
                            <thead class="">
                                <tr>
                                    <th>#</th>
                                    <th>Pay Item</th>
                                    <th>Total Amount (&#8358;)</th>
                                    <th>Current (&#8358;)</th>
                                    <th>Year To Date (&#8358;)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $acurrent = 0;
                                    $aytd = 0;
                                    $allowances = \App\Models\DefaultAllowances::where('step_id', $psr->step_id)->get();

                                @endphp
                                @foreach ($allowances as $allow)
                                    @php
                                        $currentallowance = $psr->{$allow->allowance->sql_label};
                                        $totalallowances = $psr->ytdallowance(
                                            $psr->employee_number,
                                            $allow->allowance->sql_label,
                                        );
                                        $acurrent = $acurrent + $currentallowance;
                                        $aytd = $aytd + $totalallowances;
                                    @endphp
                                    <tr class="sub">
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $allow->allowance->allowance_name }}
                                        </td>
                                        <td>{{ number_format($psr->{$allow->allowance->sql_label}, 2) }}
                                        </td>
                                        <td>{{ number_format($currentallowance, 2) }}
                                        </td>
                                        <td>{{ number_format($psr->ytdallowance($psr->employee_number, $allow->allowance->sql_label), 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="cate" style="background:#F8E4AC">
                                    <th colspan="2" class="text-center" style="color: black">Gross Pay
                                    </th>
                                    <th style="color: black">
                                        {{ number_format($psr->gross_pay, 2) }}
                                    </th>
                                    <th style="color: black">
                                        {{ number_format($acurrent, 2) }}
                                    </th>
                                    <th style="color: black">
                                        {{ number_format($aytd, 2) }}
                                    </th>
                                </tr>
                            </tbody>
                            <thead class="" style="background: #e4eaf2">
                                <tr>
                                    <th colspan="5" style="color: black">
                                        DEDUCTIONS</th>
                                </tr>
                            </thead>
                            <thead class="">
                                <tr>
                                    <th>#</th>
                                    <th>Deductions</th>
                                    <th>Total Amount (&#8358;)</th>
                                    <th>Current (&#8358;)</th>
                                    <th>Year To Date (&#8358;)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $dcurrent = 0;
                                    $dytd = 0;
                                    $deductions = \App\Models\DefaultDeductions::where('step_id', $psr->step_id)->get();

                                @endphp
                                @foreach ($deductions as $ded)
                                    @php
                                        $currentdeduction = $psr->{$ded->deduction->sql_label};
                                        $totaldeductions = $psr->ytddeduction(
                                            $psr->employee_number,
                                            $ded->deduction->sql_label,
                                        );
                                        $dcurrent = $dcurrent + $currentdeduction;
                                        $dytd = $dytd + $totaldeductions;
                                    @endphp
                                    <tr class="sub">
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $ded->deduction->deduction_name }}
                                        </td>
                                        <td>{{ number_format($psr->{$ded->deduction->sql_label}, 2) }}
                                        </td>
                                        <td>{{ number_format($currentdeduction, 2) }}
                                        </td>
                                        <td>{{ number_format($totaldeductions, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="cate" style="background:#F8E4AC">
                                    <th colspan="2" class="text-center" style="color: black">Total
                                        Deductions</th>
                                    <th style="color: black">
                                        {{ number_format($psr->total_deductions, 2) }}
                                    </th>
                                    <th style="color: black">
                                        {{ number_format($dcurrent, 2) }}
                                    </th>
                                    <th style="color: black">
                                        {{ number_format($dytd, 2) }}
                                    </th>
                                </tr>
                            </tbody>
                            <thead class="" style="background: #e4eaf2">
                                <tr>
                                    <th colspan="5" style="color: black">NET PAY
                                    </th>
                                </tr>
                                <tr class="cate" style="background:#F8E4AC">
                                    <th colspan="2" class="text-center" style="color: black">Net Pay</th>
                                    <th colspan="3" style="color: black">
                                        {{ number_format($psr->net_pay, 2) }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div style="page-break-after: always;"></div>
                @endforeach
            @endforeach

        </div>





    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Store the session token in sessionStorage
        sessionStorage.setItem('post_token', postToken);

        function printNau(id, title) {
            var contents = $("#" + id).html();
            var frame1 = $('<iframe />');
            frame1[0].name = "frame1";
            frame1.css({
                "position": "absolute",
                "top": "-1000000px",
                "pointer-events": "none"
            });
            $("body").append(frame1);
            var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[
                0].contentDocument.document : frame1[0].contentDocument;
            frameDoc.document.open();
            frameDoc.document.write('<html><head><title>Print ' + title + '</title>');
            frameDoc.document.write('</head><body>');
            frameDoc.document.write(
                '<link href="http://127.0.0.1:8000/assets/css/theme.min.css" rel="stylesheet" type="text/css" />');
            frameDoc.document.write(
                '<link href="http://127.0.0.1:8000/assets/css/gfuns.css" rel="stylesheet" type="text/css" />');
            frameDoc.document.write(contents);
            frameDoc.document.write('</body></html>');
            frameDoc.document.close();
            setTimeout(function() {
                window.frames["frame1"].focus();
                window.frames["frame1"].print();
                frame1.remove();
            }, 500);
        }
    </script>
</body>

</html>
