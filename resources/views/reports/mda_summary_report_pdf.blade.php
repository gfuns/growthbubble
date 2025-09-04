<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MDA Summary Report</title>
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

        <div class="ms-3 row mb-5 mt-5 me-2">
            <div class="col-2">
                <img src="https://fastpaymita.com/images/logo.png" alt="Logo" class="logo-img">
            </div>
            <div class="col-6" style="color:black">
                <span style="font-weight: bold; font-size:24px; display:block;">{{ $workgroup->work_group }}</span>
                <span style="font-size:16px; display:block;">MDA Summary Report For {{ $period }}</span>
                <span style="font-size:10px;">Generated @
                    {{ date('Y-m-d H:i A') }}</span>
            </div>
            <div class="col-4 text-end" style="color:black">
                <span class="text-end" style="font-size:10px;">
                    <span style="font-size:10px;">
                        <img src="https://fastpaymita.com/images/kogi_logo.png" alt="Logo" class="logo-img">
                    </span>
            </div>

        </div>


        <table class="table table-bordered" style="font-size:10px; font-family:Arial, Helvetica, sans-serif">
            <tr class="cate table-light">
                <th>#</th>
                <th>MDA Name</th>
                <th class="text-end">Head Count</th>
                {{-- @foreach ($groupAllowances as $all)
                    <th>{{ ucwords(strtolower($all->allowance_name)) }}</th>
                @endforeach --}}
                <th class="text-end">Gross Amount (=N=)</th>
                @foreach ($groupDeductions as $ded)
                    <th class="text-end">{{ ucwords(strtolower($ded->deduction_name)) }} (=N=)</th>
                @endforeach
                <th class="text-end">Total Deductions (=N=)</th>
                <th class="text-end">Net Pay (=N=)</th>
                {{-- <th>Period</th> --}}
            </tr>
            @php
                $index = 1;
            @endphp
            @foreach ($mdas as $data)
                @if ($data->headCount($period, $data->id, $workgroup->id) > 0)
                    <tr>
                        <td>{{ $index++ }}</td>
                        <td>{{ $data->branch }}</td>
                        <td class="text-end">
                            {{ number_format($data->headCount($period, $data->id, $workgroup->id), 0) }}
                        </td>
                        {{-- @foreach ($groupAllowances as $all)
                        <td>&#8358;{{ number_format($data->dynamicAttribute($all->sql_label, $period, $data->id, $workgroup->id)) }}
                        </td>
                    @endforeach --}}
                        <td class="text-end">
                            &#8358;{{ number_format($data->grossAmount($period, $data->id, $workgroup->id)) }}
                        </td>
                        @foreach ($groupDeductions as $ded)
                            <td class="text-end">
                                &#8358;{{ number_format($data->dynamicAttribute($ded->sql_label, $period, $data->id, $workgroup->id), 2) }}
                            </td>
                        @endforeach
                        <td class="text-end">
                            &#8358;{{ number_format($data->totalDeductions($period, $data->id, $workgroup->id)) }}
                        <td class="text-end">
                            &#8358;{{ number_format($data->netPay($period, $data->id, $workgroup->id)) }}
                            {{-- <td>{{ $period }} --}}
                    </tr>
                @endif
            @endforeach

            <tr class="table-warning">
                <th colspan="2" class="text-end">TOTAL</th>
                <th class="text-end">{{ number_format($data->totalHeadCount($period, $workgroup->id), 0) }}</th>
                {{-- @foreach ($groupAllowances as $all)
                    <td>&#8358;{{ number_format($data->grossDynamicAttribute($all->sql_label, $period, $workgroup->id)) }}
                    </td>
                @endforeach --}}
                <td class="text-end">&#8358;{{ number_format($data->grossTotalAmount($period, $workgroup->id)) }}
                </td>
                @foreach ($groupDeductions as $ded)
                    <td class="text-end">
                        &#8358;{{ number_format($data->grossDynamicAttribute($ded->sql_label, $period, $workgroup->id), 2) }}
                    </td>
                @endforeach

                <td class="text-end">&#8358;{{ number_format($data->grossTotalDeductions($period, $workgroup->id)) }}
                <td class="text-end">&#8358;{{ number_format($data->grossNetPay($period, $workgroup->id)) }}
            </tr>

        </table>

        <div class="row mt-5" style="font-size: 11px">
            <table class="table table-borderless" style="width:100%; font-size: 10px; margin-top: 45px;">
                <thead>
                    <tr>
                        <th class="" style="border-top:0;">PREPARED BY</th>
                        <th class="" style="border-top:0;">CHECKED BY</th>
                        <th class="" style="border-top:0;">INSPECTED BY</th>
                        <th class="" style="border-top:0;">APPROVED BY</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="rptstyle">Name: ______________________________________________</td>
                        <td class="rptstyle">Name: ______________________________________________</td>
                        <td class="rptstyle">Name: ______________________________________________</td>
                        <td class="rptstyle">Name: ______________________________________________</td>
                    </tr>
                    <tr>
                        <td class="rptstyle">Rank: _______________________________________________</td>
                        <td class="rptstyle">Rank: _______________________________________________</td>
                        <td class="rptstyle">Rank: _______________________________________________</td>
                        <td class="rptstyle">Rank: _______________________________________________</td>
                    </tr>
                    <tr>
                        <td class="rptstyle">Date: _______________________________________________</td>
                        <td class="rptstyle">Date: _______________________________________________</td>
                        <td class="rptstyle">Date: _______________________________________________</td>
                        <td class="rptstyle">Date: _______________________________________________</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
