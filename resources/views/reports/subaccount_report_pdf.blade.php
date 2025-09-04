<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sub Account Report</title>
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

        .text-right {
            text-align: right;
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
                <img src="https://fastpaymita.com/images/logo.png" alt="Logo" class="logo-img">
            </div>
            <div class="col-6" style="color:black">
                <span style="font-weight: bold; font-size:24px; display:block;">{{ $workgroup->work_group }}</span>
                <span style="font-size:16px; display:block;">
                    @if ($period == 'All')
                        All Time Sub Account Report
                    @else
                        Sub Account Report For {{ $period }}
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
            <tr>
                <th>#</th>
                <th>COMPONENT NAME</th>
                <th class="text-end">EARNINGS (=N=)</th>
                <th class="text-end">DEDUCTIONS (=N=)</th>
            </tr>
            </tr>
            @php
                $totalEarnings = 0;
                $totalDeductions = 0;
                $index = 1;
            @endphp
            @foreach ($allowances as $data)
                @php
                    $totalEarnings =
                        $totalEarnings + $data->dynamicAttribute($data->sql_label, $period, $branchId, $workgroup->id);
                @endphp
                <tr>
                    <td>{{ $index++ }}</td>
                    <td>{{ $data->allowance_name }}</td>
                    <td class="text-end">{{ number_format($data->dynamicAttribute($data->sql_label, $period, $branchId, $workgroup->id), 2) }}
                    </td>
                    <td class="text-end">0.00</td>
                </tr>
            @endforeach
            @foreach ($deductions as $data)
                @php
                    $totalDeductions =
                        $totalDeductions +
                        $data->dynamicAttribute($data->sql_label, $period, $branchId, $workgroup->id);
                @endphp
                <tr>
                    <td>{{ $index++ }}</td>
                    <td>{{ $data->deduction_name }}</td>
                    <td class="text-end">0.00</td>
                    <td class="text-end">{{ number_format($data->dynamicAttribute($data->sql_label, $period, $branchId, $workgroup->id), 2) }}
                    </td>
                </tr>
            @endforeach
            <tr class="table-warning">
                <th style="color:black; " class="text-end" colspan="2">TOTALS</th>
                <th style="color:black; " class="text-end">{{ number_format($totalEarnings, 2) }}</th>
                <th style="color:black; " class="text-end">{{ number_format($totalDeductions, 2) }}</th>
            </tr>

        </table>

    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
