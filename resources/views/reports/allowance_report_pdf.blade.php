<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allowance Report</title>
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
                        All Time Allowance Report
                    @else
                        Allowance Report For {{ $period }}
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
                @if ($selAll == 'All')
                    <th class="text-right">Basic Pay</th>
                    <th class="text-right">Allowances</th>
                @else
                    <th class="text-right">{{ $groupAllowances->allowance_name }}</th>
                @endif
                {{-- <th>Period</th> --}}
            </tr>
            @php
                $basic = 0;
                $allowances = 0;
            @endphp
            @foreach ($allowanceRecords as $data)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $data->employee_number }}</td>
                    <td>{{ $data->full_name }}</td>
                    <td>{{ $data->paygroup }}</td>
                    @if ($selAll == 'All')
                        @php
                            $basic = $basic + $data->{$basicAllowance->sql_label};
                        @endphp
                        <td class="text-right">&#8358;{{ number_format($data->{$basicAllowance->sql_label}, 2) }}</td>
                        <td class="text-right">
                            @foreach ($data->getPaidAllowances($data->level_id) as $allowance)
                                @if ($data->{$allowance->sql_label} > 0)
                                    <li style="list-style: none">
                                        @php
                                            $allowances = $allowances + $data->{$allowance->sql_label};
                                        @endphp
                                        <strong>{{ ucwords(strtolower($allowance->allowance_name)) }}:</strong>
                                        &#8358;{{ number_format($data->{$allowance->sql_label}, 2) }}
                                    </li>
                                @endif
                            @endforeach

                        </td>
                    @else
                        <td>&#8358;{{ number_format($data->{$allowanceType}, 2) }}</td>
                    @endif
                    {{-- <td>{{ $data->period }}</td> --}}
                </tr>
            @endforeach
            <tr>
                <th colspan="4" class="text-right">TOTALS</th>
                <th class="text-right">&#8358;{{ number_format($basic, 2) }}</th>
                <th class="text-right">&#8358;{{ number_format($allowances, 2) }}</th>
            </tr>

        </table>

    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
