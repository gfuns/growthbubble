<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll MDA Report By Bank</title>
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
            /* Light Yellow */
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
                        All Time Payroll MDA Report By Bank
                    @else
                        Payroll MDA Report By Bank For {{ $period }}
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


        @php
            $groupedPayments = $payrollMdaByBank->groupBy('branch');
        @endphp
        @foreach ($groupedPayments as $branch => $mdas)
            @php
                $groupedRecords = $mdas->groupBy('bank');
            @endphp
            @foreach ($groupedRecords as $bank => $records)
                <h6>{{ $branch }} ({{ $bank }})</h6>
                <table class="table table-bordered table-striped mb-5"
                    style="font-size:10px; font-family:Arial, Helvetica, sans-serif">
                    <tr class="cate table-light">
                        <th>#</th>
                        <th>Employee No</th>
                        <th>Employee Names</th>
                        <th>Pay Group</th>
                        <th>Basic Pay</th>
                        <th>Allowances</th>
                        <th>Gross Pay</th>
                        <th>Deductions</th>
                        <th>Total Deductions</th>
                        <th>Net Pay</th>
                        {{-- <th>BVN</th> --}}
                        {{-- <th>Period</th> --}}
                    </tr>
                    @foreach ($records as $data)

                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $data->employee_number }}</td>
                            <td>{{ $data->employee->surname . ', ' . $data->employee->other_names }}</td>
                            <td>{{ $data->paygroup }}</td>
                            <td>&#8358;{{ number_format($data->{$basicAllowance->sql_label}, 2) }}</td>
                            <td>
                                @foreach ($data->getPaidAllowances($data->level_id) as $allowance)
                                    <li style="list-style: none">
                                        <strong>{{ ucwords(strtolower($allowance->allowance_name)) }}:</strong>
                                        &#8358;{{ number_format($data->{$allowance->sql_label}, 2) }}</li>
                                @endforeach

                            </td>
                            <td>&#8358;{{ number_format($data->gross_pay, 2) }}</td>
                            <td>
                                @foreach ($data->getPaidDeductions($data->level_id) as $deduction)
                                    <li style="list-style: none">
                                        <strong>{{ ucwords(strtolower($deduction->deduction_name)) }}:</strong>
                                        &#8358;{{ number_format($data->{$deduction->sql_label}, 2) }}</li>
                                @endforeach

                            </td>
                            <td>&#8358;{{ number_format($data->total_deductions, 2) }}</td>
                            <td>&#8358;{{ number_format($data->net_pay, 2) }}</td>
                            {{-- <td>{{ $data->bvn }}</td> --}}
                            {{-- <td>{{ $data->period }}</td> --}}
                        </tr>
                    @endforeach
                    <tr class="table-light;" style="font-weight: bold">
                        <td colspan="4">Total Number of {{ $branch }} ({{ $bank }}) Employees:
                            {{ number_format($data->getTotalEmployees($data->branch_id, $period, $data->bank), 0) }} </td>
                        <td>&#8358;{{ number_format($data->getTotalBasicPay($data->branch_id, $period, $data->bank, $basicAllowance->sql_label), 2) }}
                        </td>
                        <td>&nbsp;</td>
                        <td>&#8358;{{ number_format($data->getTotalGrossPay($data->branch_id, $period, $data->bank), 2) }}
                        </td>
                        <td>&nbsp;</td>
                        <td>&#8358;{{ number_format($data->getTotalDeductions($data->branch_id, $period, $data->bank), 2) }}
                        </td>
                        <td>&#8358;{{ number_format($data->getTotalNetPay($data->branch_id, $period, $data->bank), 2) }}
                        </td>
                    </tr>
                </table>
            @endforeach

            <h6 style="margin-top: 150px">Summary ({{ $branch }})</h6>
            <table class="table table-bordered table-striped mb-5"
                style="font-size:10px; font-family:Arial, Helvetica, sans-serif; width:30%">
                <tr class="cate table-light">
                    <th>Grand Total Number of Employees:</th>
                    <td>{{ number_format($data->getTESummary($data->branch_id, $period), 0) }}</td>
                </tr>
                <tr class="cate table-light">
                    <th>Grand Total Gross Pay:</th>
                    <td>&#8358;{{ number_format($data->getGPSummary($data->branch_id, $period), 2)}}</td>
                </tr>
                <tr class="cate table-light">
                    <th>Grand Total Deductions:</th>
                    <td>&#8358;{{ number_format($data->getTDSummary($data->branch_id, $period), 2) }}</td>
                </tr>
                <tr class="cate table-light">
                    <th>Grand Total Net Pay:</th>
                    <td>&#8358;{{ number_format($data->getNPSummary($data->branch_id, $period), 2) }}</td>
                </tr>
            </table>


            <h6 style="margin-top: 150px">Overall Summary</h6>
            <table class="table table-bordered table-striped mb-5"
                style="font-size:10px; font-family:Arial, Helvetica, sans-serif; width:30%">
                <tr class="cate table-light">
                    <th>Grand Total Number of Employees:</th>
                    <td>{{ number_format($data->getTESummary($data->branch_id, $period), 0) }}</td>
                </tr>
                <tr class="cate table-light">
                    <th>Grand Total Gross Pay:</th>
                    <td>&#8358;{{ number_format($data->getGPSummary($data->branch_id, $period), 2)}}</td>
                </tr>
                <tr class="cate table-light">
                    <th>Grand Total Deductions:</th>
                    <td>&#8358;{{ number_format($data->getTDSummary($data->branch_id, $period), 2) }}</td>
                </tr>
                <tr class="cate table-light">
                    <th>Grand Total Net Pay:</th>
                    <td>&#8358;{{ number_format($data->getNPSummary($data->branch_id, $period), 2) }}</td>
                </tr>
            </table>
        @endforeach


    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
