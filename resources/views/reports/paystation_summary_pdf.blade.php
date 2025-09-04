<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Station Summary Report</title>
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

        /* .table-striped tbody tr:nth-child(odd) {
            background-color: #fff3cd;

        }

        .table-striped tbody tr:nth-child(even) {
            background-color: white;
        } */
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
                        All Time Pay Station Summary Report
                    @else
                        Pay Station Summary Report For {{ $period }}
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
                <th>Employee Name</th>
                <th>Pay Group</th>
                <th>Pay Station</th>
                <th class="text-end">Allowances</th>
                <th class="text-end">Gross Pay</th>
                <th class="text-end">Deductions</th>
                <th class="text-end">Total Deductions</th>
                <th class="text-end">Net Pay</th>
                <th>Bank</th>
                <th>Account No.</th>
                {{-- <th>BVN</th>
                <th>Period</th> --}}
            </tr>
            @php
                $allowances = 0;
                $grosspay = 0;
                $deductions = 0;
                $totalded = 0;
                $netpay = 0;
            @endphp
            @foreach ($payrolReport as $data)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $data->employee_number }}</td>
                    <td>{{ $data->full_name }}</td>
                    <td>{{ $data->paygroup }}</td>
                    <td>{{ $data->branch }}</td>
                    <td class="text-end">
                        @foreach ($groupAllowances as $all)
                            @php
                                $av = $data->{$all->sql_label};
                            @endphp
                            @if ($av > 0)
                                <li style="list-style: none">
                                    @php
                                        $allowances = $allowances + $av;
                                    @endphp
                                    <strong>{{ ucwords(strtolower($all->allowance_name)) }}:</strong>
                                    &#8358;{{ number_format($av, 2) }}
                                </li>
                            @endif
                        @endforeach
                    </td>
                    @php
                        $grosspay = $grosspay + $data->gross_pay;
                    @endphp
                    <td class="text-end">&#8358;{{ number_format($data->gross_pay, 2) }}</td>
                    <td class="text-end">
                        @foreach ($groupDeductions as $ded)
                            @php
                                $dv = $data->{$ded->sql_label};
                            @endphp
                            @if ($dv > 0)
                                <li style="list-style: none">
                                    @php
                                        $deductions = $deductions + $dv;
                                    @endphp
                                    <strong>{{ ucwords(strtolower($ded->deduction_name)) }}:</strong>
                                    &#8358;{{ number_format($dv, 2) }}
                                </li>
                            @endif
                        @endforeach
                    </td>
                    @php
                        $totalded = $totalded + $data->total_deductions;
                        $netpay = $netpay + $data->net_pay;
                    @endphp
                    <td class="text-end">&#8358;{{ number_format($data->total_deductions, 2) }}</td>
                    <td class="text-end">&#8358;{{ number_format($data->net_pay, 2) }}</td>
                    <td>{{ $data->bank }}</td>
                    <td>{{ $data->account_number }}</td>
                    {{-- <td>{{ $data->bvn }}</td>
                    <td>{{ $data->period }}</td> --}}
                </tr>
            @endforeach
            <tr>
                <th colspan="5" class="text-end">TOTALS</th>
                <th class="text-end">&#8358;{{ number_format($allowances, 2) }}</th>
                <th class="text-end">&#8358;{{ number_format($grosspay, 2) }}</th>
                <th class="text-end">&#8358;{{ number_format($deductions, 2) }}</th>
                <th class="text-end">&#8358;{{ number_format($totalded, 2) }}</th>
                <th class="text-end">&#8358;{{ number_format($netpay, 2) }}</th>
                <th colspan="2"></th>
            </tr>

        </table>

    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
