<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deduction Summary Report</title>
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
                <img src="https://fastpaymita.com/images/logo.png" alt="Logo" class="logo-img">
            </div>
            <div class="col-6" style="color:black">
                <span style="font-weight: bold; font-size:24px; display:block;">{{ $workgroup->work_group }}</span>
                <span style="font-size:16px; display:block;">
                    @if ($period == 'All')
                        All Time Deduction Summary Report
                    @else
                        Deduction Summary Report For {{ $period }}
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
                <th>Deduction</th>
                <th>Deduction Code</th>
                <th>Status</th>
                <th class="text-end">Head Count</th>
                <th class="text-end">Amount (=N=)</th>
                {{-- <th>NLC Contribution (=N=)</th> --}}
                {{-- <th>Balance</th> --}}
                {{-- <th>Bank Name</th> --}}
                {{-- <th>Bank Code</th> --}}
                {{-- <th>Account Number</th> --}}
                {{-- <th>Account Name</th> --}}
            </tr>
            @php
                $grandTotal = 0;
                $headcount = 0;
            @endphp
            @foreach ($deductions as $data)
                @php
                    $deductionTotal = $data->deductions($workgroup->id, $period, $data->sql_label);
                    $grandTotal = $grandTotal + $deductionTotal;
                @endphp
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $data->deduction_name }}</td>
                    <td>{{ $data->deduction_code }}</td>
                    <td>{{ ucwords($data->status) }}</td>
                    <td class="text-end">
                        @php
                            $headcount = $headcount + $data->headCount($workgroup->id, $period, $data->sql_label);
                        @endphp
                        {{ number_format($data->headCount($workgroup->id, $period, $data->sql_label), 0) }}
                    </td>
                    <td class="text-end">{{ number_format($deductionTotal, 2) }}</td>
                    {{-- <td>{{ $data->nlc_contribution }}</td> --}}
                    {{-- <td>{{ number_format($deductionTotal, 2) }}</td> --}}
                    {{-- <td>{{ $data->bank }}</td> --}}
                    {{-- <td>{{ $data->bank_code }}</td> --}}
                    {{-- <td>{{ $data->account_number }}</td> --}}
                    {{-- <td>{{ $data->account_name }}</td> --}}
                </tr>
            @endforeach
            <tr style="background:#F8E4AC">
                <th colspan="4" class="text-end" style="color:black">TOTALS</th>
                <th style="color:black" class="text-end">{{ number_format($headcount, 0) }}</th>
                <th style="color:black" class="text-end">{{ number_format($grandTotal, 2) }}</th>
                {{-- <th></th> --}}
                {{-- <th></th> --}}
                {{-- <th></th> --}}
                {{-- <th></th> --}}
            </tr>
        </table>

    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
