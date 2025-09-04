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
                <img src="https://res.cloudinary.com/dukani/image/upload/v1711393083/logo_knu340.png" alt="Logo"
                    class="logo-img">
            </div>
            <div class="col-6" style="color:black">
                <span style="font-weight: bold; font-size:24px; display:block;">{{ $workgroup->work_group }}</span>
                <span style="font-size:16px; display:block;">MDA Summary Report For {{ $period }}</span>
            </div>
            <div class="col-4 text-end" style="color:black">
                <span class="text-end" style="font-size:10px;">Generated @
                    {{ date('Y-m-d H:i A') }}</span>
            </div>

        </div>



        <table class="table table-bordered" style="font-size:10px; font-family:Arial, Helvetica, sans-serif">
            <tr class="cate table-light">
                <th>#</th>
                <th>MDA Name</th>
                <th class="text-end">Head Count</th>
                <th class="text-end">Basic Pay (=N=)</th>
                <th class="text-end">Shift Allowance (=N=)</th>
                <th class="text-end">Hazard Allowance (=N=)</th>
                <th class="text-end">Consolidated Allowance (=N=)</th>
                <th class="text-end">Gross Amount (=N=)</th>
                <th class="text-end">Tax (=N=)</th>
                <th class="text-end">NULGE Dues (=N=)</th>
                <th class="text-end">Medical Dues (=N=)</th>
                <th class="text-end">NHF (=N=)</th>
                <th class="text-end">Total Deductions (=N=)</th>
                <th class="text-end">Net Pay (=N=)</th>
            </tr>
            @php
                $totalHeadCount = 0;
                $totalGross = 0;
                $totalDeductions = 0;
                $totalNetPay = 0;
                $totalTax = 0;
                $totalShift = 0;
                $totalHazard = 0;
                $totalConsolidated = 0;
                $totalMedical = 0;
                $totalNulge = 0;
                $totalNhf = 0;
                $totalBasic = 0;
            @endphp
            @foreach ($mdas as $data)
                @php
                    $totalHeadCount = $totalHeadCount + $data->employees->count();
                    $totalGross = $data->grossAmount($period, $data->id, $workgroup->id);
                    $totalDeductions = $data->totalDeductions($period, $data->id, $workgroup->id);
                    $totalNetPay = $data->netPay($period, $data->id, $workgroup->id);
                    $totalTax = $data->dynamicAttribute('tax', $period, $data->id, $workgroup->id);
                    $totalBasic = $data->dynamicAttribute('basic_pay', $period, $data->id, $workgroup->id);
                    $totalShift = $data->dynamicAttribute('shift_allowance', $period, $data->id, $workgroup->id);
                    $totalHazard = $data->dynamicAttribute('hazard_allowance', $period, $data->id, $workgroup->id);
                    $totalConsolidated = $data->dynamicAttribute(
                        'consolidated_allowances',
                        $period,
                        $data->id,
                        $workgroup->id,
                    );
                    $totalMedical = $data->dynamicAttribute('nulge_dues', $period, $data->id, $workgroup->id);
                    $totalNulge = $data->dynamicAttribute('medical_dues', $period, $data->id, $workgroup->id);
                    $totalNhf = $data->dynamicAttribute('nhf', $period, $data->id, $workgroup->id);
                @endphp
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $data->branch }}</td>
                    <td class="text-end">{{ number_format($data->employees->count(), 0) }}</td>
                    <td class="text-end">
                        {{ number_format($data->dynamicAttribute('basic_pay', $period, $data->id, $workgroup->id), 2) }}
                    </td>
                    <td class="text-end">
                        {{ number_format($data->dynamicAttribute('shift_allowance', $period, $data->id, $workgroup->id), 2) }}
                    </td>
                    <td class="text-end">
                        {{ number_format($data->dynamicAttribute('hazard_allowance', $period, $data->id, $workgroup->id), 2) }}
                    </td>
                    <td class="text-end">
                        {{ number_format($data->dynamicAttribute('consolidated_allowances', $period, $data->id, $workgroup->id), 2) }}
                    </td>
                    <td class="text-end">{{ number_format($data->grossAmount($period, $data->id, $workgroup->id), 2) }}
                    </td>
                    <td class="text-end">
                        {{ number_format($data->dynamicAttribute('tax', $period, $data->id, $workgroup->id), 2) }}</td>
                    <td class="text-end">
                        {{ number_format($data->dynamicAttribute('nulge_dues', $period, $data->id, $workgroup->id), 2) }}
                    </td>
                    <td class="text-end">
                        {{ number_format($data->dynamicAttribute('medical_dues', $period, $data->id, $workgroup->id), 2) }}
                    </td>
                    <td class="text-end">
                        {{ number_format($data->dynamicAttribute('nhf', $period, $data->id, $workgroup->id), 2) }}</td>
                    <td class="text-end">
                        {{ number_format($data->totalDeductions($period, $data->id, $workgroup->id), 2) }}</td>
                    <td class="text-end">{{ number_format($data->netPay($period, $data->id, $workgroup->id), 2) }}</td>
                </tr>
            @endforeach

            <tr class="table-warning">
                <th colspan="2" class="text-end">TOTAL</th>
                <th class="text-end">{{ number_format($totalHeadCount, 0) }}</th>
                <th class="text-end">{{ number_format($totalBasic, 2) }}</th>
                <th class="text-end">{{ number_format($totalShift, 2) }}</th>
                <th class="text-end">{{ number_format($totalHazard, 2) }}</th>
                <th class="text-end">{{ number_format($totalConsolidated, 2) }}</th>
                <th class="text-end">{{ number_format($totalGross, 2) }}</th>
                <th class="text-end">{{ number_format($totalTax, 2) }}</th>
                <th class="text-end">{{ number_format($totalNulge, 2) }}</th>
                <th class="text-end">{{ number_format($totalMedical, 2) }}</th>
                <th class="text-end">{{ number_format($totalNhf, 2) }}</th>
                <th class="text-end">{{ number_format($totalDeductions, 2) }}</th>
                <th class="text-end">{{ number_format($totalNetPay, 2) }}</th>
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
