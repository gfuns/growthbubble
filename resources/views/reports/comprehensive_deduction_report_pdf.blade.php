<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprehensive Deduction Report</title>
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



        .table-striped tbody tr:nth-child(even) {
            background-color: white;
        }

        */
    </style>
</head>

<body>
    <div class="container">

        <div class="ms-3 row mb-5 mt-5 me-2">
            <div class="col-2">
                <img src="https://fastpaymita.com/images/logo.png" alt="Logo"
                    class="logo-img">
            </div>
            <div class="col-6" style="color:black">
                <span style="font-weight: bold; font-size:24px; display:block;">{{ $workgroup }}</span>
                <span style="font-size:16px; display:block;">
                    @if ($period == 'All')
                        All Time Comprehensive Deduction Report
                    @else
                        Comprehensive Deduction Report For {{ $period }}
                    @endif
                </span>
                <span style="font-size:10px;">Generated @
                    {{ date('Y-m-d H:i A') }}</span>
            </div>
            <div class="col-4 text-end" style="color:black">
                <span class="text-end" style="font-size:10px;">
                    <img src="https://fastpaymita.com/images/kogi_logo.png" alt="Logo" class="logo-img">
                </span>
            </div>

        </div>



        <table class="table table-bordered table-striped mb-5"
            style="font-size:10px; font-family:Arial, Helvetica, sans-serif">
            <tr class="cate table-light">
                <th>#</th>
                <th>Employee No.</th>
                <th>Full Name</th>
                <th>Pay Group</th>
                <th>Deduction</th>
                <th class="text-end">Amount</th>
                <th>Branch</th>
                <th>Department</th>
                <th>Unit</th>
            </tr>
            @php
                $deductions = 0;
                $index = 1;
            @endphp
            @foreach ($deductionRecords as $data)
                @foreach ($groupDeductions as $ded)
                    @if ($data->{$ded->sql_label} > 0)
                        @php
                            $deductions = $deductions + $data->{$ded->sql_label};
                        @endphp
                        <tr>
                            <td>{{ $index++ }}</td>
                            <td>{{ $data->employee_number }}</td>
                            <td>{{ $data->full_name }}</td>
                            <td>{{ $data->paygroup }}</td>
                            <td>{{ ucwords(strtolower($ded->deduction_name)) }}</td>
                            <td class="text-end"> &#8358;{{ number_format($data->{$ded->sql_label}, 2) }}</td>
                            <td>{{ $data->branch }}</td>
                            <td>{{ $data->department }}</td>
                            <td>{{ $data->unit }}</td>
                        </tr>
                    @endif
                @endforeach
            @endforeach
            <tr>
                <th colspan="5" class="text-end">TOTALS</th>
                <th class="text-end">&#8358;{{ number_format($deductions, 2) }}</th>
                <th colspan="3"></th>
            </tr>

        </table>

        {{-- <table class="table table-bordered table-striped mb-5"
            style="font-size:10px; font-family:Arial, Helvetica, sans-serif">
            <tr class="cate table-light">
                <th>#</th>
                <th>Employee No.</th>
                <th>Full Name</th>
                <th>Pay Group</th>
                <th>Deductions</th>
                <th>Total Deduction</th>
            </tr>
            @foreach ($deductionRecords as $data)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $data->employee_number }}</td>
                    <td>{{ $data->full_name }}</td>
                    <td>{{ $data->paygroup }}</td>
                    <td>
                        @foreach ($groupDeductions as $ded)
                            <li style="list-style: none">
                                <strong>{{ ucwords(strtolower($ded->deduction_name)) }}:</strong>
                                &#8358;{{ number_format($data->{$ded->sql_label}, 2) }}</li>
                        @endforeach

                    </td>
                    <td>&#8358;{{ number_format($data->total_deductions, 2) }}</td>
                </tr>
            @endforeach

        </table> --}}

    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
