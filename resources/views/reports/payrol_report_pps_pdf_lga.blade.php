<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payrol Report Per Pay Station</title>
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
                <span style="font-weight: bold; font-size:24px; display:block;">{{ $workgroup }}</span>
                <span style="font-size:16px; display:block;">Payrol Report For {{ $period }}</span>
            </div>
            <div class="col-4 text-end" style="color:black">
                <span class="text-end" style="font-size:10px;">Generated @
                    {{ date('Y-m-d H:i A') }}</span>
            </div>

        </div>



        <table class="table table-bordered" style="font-size:10px; font-family:Arial, Helvetica, sans-serif">
            <tr class="cate table-light">
                <th>#</th>
                <th>Employee No</th>
                <th>Surname</th>
                <th>Other Names</th>
                <th>Pay Group</th>
                <th>Basic Salary (=N=)</th>
                <th>Gross Pay (=N=)</th>
                <th>Total Deduction (=N=)</th>
                <th>Net Pay (=N=)</th>
                <th>Bank</th>
                <th>Account No.</th>
                <th>BVN</th>
            </tr>
            @foreach ($payrolReport as $data)
                <tr  class="table-warning">
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $data->employee_number }}</td>
                    <td>{{ $data->employee->surname }}</td>
                    <td>{{ $data->employee->other_names }}</td>
                    <td>{{ $data->paygroup }}</td>
                    <td>{{ number_format($data->basic_pay, 2) }}</td>
                    <td>{{ number_format($data->gross_pay, 2) }}</td>
                    <td>{{ number_format($data->total_deductions, 2) }}</td>
                    <td>{{ number_format($data->net_pay, 2) }}</td>
                    <td>{{ $data->bank }}</td>
                    <td>{{ $data->account_number }}</td>
                    <td>{{ $data->bvn }}</td>
                </tr>
                <tr>
                    <td colspan="4">BASIC PAY: {{ number_format($data->basic_pay, 2) }} &nbsp; | &nbsp; Shift Duty Allowance: {{ number_format($data->shift_allowance, 2) }} &nbsp; | &nbsp; Hazard Allowance: {{ number_format($data->hazard_allowance, 2) }}</td>
                    <td colspan="8">Tax: {{ number_format($data->tax, 2) }} &nbsp; | &nbsp; NULGE Dues: {{ number_format($data->nulge_dues, 2) }} &nbsp; | &nbsp; Medical Dues {{ number_format($data->medical_dues, 2) }}</td>
                </tr>

            @endforeach

        </table>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
