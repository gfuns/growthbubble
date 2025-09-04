<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Biometric Report</title>
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
                    Employee Biometric Report

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
                <th>Staff ID.</th>
                <th>Full Name</th>
                <th>Date of Birth</th>
                <th>Pay Group</th>
                <th>BVN</th>
                <th>Bank</th>
                <th>Account No.</th>
                <th>Picture</th>
                <th>First Appt.</th>
                <th>Present Appt.</th>
                <th>Rank</th>
                <th>LGA</th>
                <th>MDA</th>
                <th>Phone</th>
            </tr>
            @foreach ($biodataRecords as $data)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $data->employee_number }}</td>
                    <td>{{ $data->surname . ' ' . $data->other_names }}</td>
                    <td>{{ $data->date_of_birth }}</td>
                    <td>{{ $data->paygroup . ' > ' . $data->level . ' > ' . $data->step }}</td>
                    <td>{{ $data->bvn }}</td>
                    <td>{{ $data->bank }}</td>
                    <td>{{ $data->account_number }}</td>
                    <td>
                        <img src="{{ $data->employee_photo == null ? asset('assets/images/avatar/avatar.webp') : $data->employee_photo }}"
                            class="img-fluid" style="max-height: 30px" />
                    </td>

                    <td>{{ $data->employment_date }}</td>
                    <td>{{ $data->last_promotion }}</td>
                    <td>{{ $data->rank }}</td>
                    <td>{{ $data->lga_origin }}</td>
                    <td>{{ $data->branch }}</td>
                    <td>{{ $data->phone_number }}</td>

                </tr>
            @endforeach

        </table>

    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
