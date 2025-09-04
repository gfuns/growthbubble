<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tax Summary Report</title>
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
                <span style="font-weight: bold; font-size:24px; display:block;">{{ $workgroup }}</span>
                <span style="font-size:16px; display:block;">
                    @if ($period == 'All')
                        All Time Tax Summary
                    @else
                        Tax Summary For {{ $period }}
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
                <th>Employee No</th>
                <th>Full Name</th>
                <th>Pay Group</th>
                <th class="text-end">Basic Pay (&#8358;)</th>
                <th class="text-end">Gross Pay (&#8358;)</th>
                <th class="text-end">Tax (&#8358;)</th>
            </tr>
            @php
                $basic = 0;
                $gross = 0;
                $arrears = 0;
            @endphp

            @foreach ($taxReports as $data)
                @php
                    $basic = $basic + $data->{$basicAllowance->sql_label};
                    $gross = $gross + $data->gross_pay;
                    $arrears = $arrears + $data->tax;
                @endphp
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $data->employee_number }}</td>
                    <td>{{ $data->full_name }}</td>
                    <td>{{ $data->paygroup }}</td>
                    <td class="text-end">{{ number_format($data->{$basicAllowance->sql_label}, 2) }}</td>
                    <td class="text-end">{{ number_format($data->gross_pay, 2) }}</td>
                    <td class="text-end">{{ number_format($data->tax, 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <th colspan="4" class="text-right">TOTALS</th>
                <th class="text-right">{{ number_format($basic, 2) }}</th>
                <th class="text-right">{{ number_format($gross, 2) }}</th>
                <th class="text-right">{{ number_format($arrears, 2) }}</th>
            </tr>

        </table>

    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
