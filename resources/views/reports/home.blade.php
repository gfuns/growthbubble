@extends('layouts.app')

@section('content')
@section('title', env('APP_NAME') . ' | Reports')

<style>
    legend {
        display: block;
        width: 100%;
        padding: 0;
        margin-bottom: 20px;
        font-size: 21px;
        line-height: inherit;
        color: #333;
        border: 0;
        border-bottom: 1px solid #e5e5e5;
    }

    legend {
        background-color: #fff;
        box-shadow: none;
        border-radius: 0px;

    }
</style>

@php
    $navWG = Session::get('workGroup');
@endphp

<!-- Container fluid -->
<section class="container-fluid p-2">
    <div class="row ">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="border-bottom pb-2 pt-2 d-lg-flex align-items-center justify-content-between">
                <div class="mb-2 mb-lg-0">
                    <h1 class="mb-0 h4 fw-bold">Reports </h1>
                    <!-- Breadcrumb -->
                </div>
            </div>

        </div>
    </div>
    <div class="py-3">
        <!-- row -->
        <div class="row">
            <div class="col-xl-12 col-md-12 col-12">
                <!-- card -->
                <div class="card">
                    <!-- card body -->
                    <div class="card-body ">
                        <!-- form -->

                        <div class="row">

                            <div class="col-lg-4 col-12" style="font-size: 11px;">
                                <fieldset>
                                    <legend>
                                        <h4 class=" fw-bold text-left">Payroll Reports</h4>
                                    </legend>
                                    <div class="list-group">
                                        <a class="list-group-item"
                                            href="{{ route('report.allowanceReport', [$navWG->id]) }}">Allowance Report
                                            <span class="text-danger">(Available Formats: Excel, PDF)</span></a>

                                        <a class="list-group-item" href="{{ route("report.arrears", [$navWG->id]) }}">Arrears Report
                                            <span class="text-danger">(Available Formats: Excel, PDF)</span>
                                        </a>

                                        <a class="list-group-item"
                                            href="{{ route('report.deductionReport', [$navWG->id]) }}">Deduction Report
                                            <span class="text-danger">(Available Formats: Excel, PDF)</span></a>

                                        <a class="list-group-item"
                                            href="{{ route('report.compAllowanceReport', [$navWG->id]) }}">Comprehensive
                                            Allowance Report <span class="text-danger">(Available Formats:
                                                Excel, PDF)</span></a>

                                                <a class="list-group-item"
                                            href="{{ route('report.compDeductionReport', [$navWG->id]) }}">Comprehensive
                                            Deduction Report <span class="text-danger">(Available Formats:
                                                Excel, PDF)</span></a>

                                        <a class="list-group-item"
                                            href="{{ route('report.payslipsReport', [$navWG->id]) }}">Payslips
                                            Report <span class="text-danger">(Available Formats: PDF)</span></a>

                                        <a class="list-group-item"
                                            href="{{ route('report.allowanceSummaryReport', [$navWG->id]) }}">Allowance
                                            Summary Report <span class="text-danger">(Available Formats: Excel,
                                                PDF)</span></a>

                                        <a class="list-group-item"
                                            href="{{ route('report.deductionSummaryReport', [$navWG->id]) }}">Deduction
                                            Summary Report <span class="text-danger">(Available Formats: Excel,
                                                PDF)</span></a>

                                        <a class="list-group-item" href="{{ route("report.deductionSummaryReportPPS", [$navWG->id]) }}">Deduction
                                            Summary Report per PayStation <span class="text-danger">(Available Formats:
                                                Excel, PDF)</span></a>

                                        <a class="list-group-item"
                                            href="{{ route('report.taxSummaryReport', [$navWG->id]) }}">Tax
                                            Summary Report <span class="text-danger">(Available Formats: Excel,
                                                PDF)</span></a>

                                        <a class="list-group-item"
                                            href="{{ route('report.payRegister', [$navWG->id]) }}">Pay
                                            Register <span class="text-danger">(Available Formats: Excel,
                                                PDF)</span></a>

                                        <a class="list-group-item"
                                            href="{{ route('report.userDefinedReport', [$navWG->id]) }}">User-defined
                                            Report <span class="text-danger">(Available Formats: Excel, PDF)</span></a>



                                        <a class="list-group-item"
                                            href="{{ route('report.payrolReportPPS', [$navWG->id]) }}">Payroll
                                            Report per Pay Station <span class="text-danger">(Available Formats: Excel,
                                                PDF)</span></a>

                                        <a class="list-group-item" href="{{ route("report.paystationSummary", [$navWG->id]) }}">Paystation
                                            Summary Report <span class="text-danger">(Available Formats: Excel, PDF)</span></a>

                                        <a class="list-group-item" href="{{ route("report.payrolReportMDA", [$navWG->id]) }}">Payroll Report by MDA<span
                                                class="text-danger"> (Available Formats: Excel, PDF)</span></a>

                                        <a class="list-group-item" href="{{ route('report.payrolMDAReportBank', [$navWG->id]) }}">Payroll MDA Report By Bank
                                            <span class="text-danger">(Available Formats: Excel, PDF)</span>
                                        </a>

                                        <a class="list-group-item"
                                            href="{{ route('report.mdaSummaryReport', [$navWG->id]) }}">MDA Summary
                                            Report
                                            <span class="text-danger">(Available Formats: Excel, PDF)</span>
                                        </a>

                                        <a class="list-group-item"
                                            href="{{ route('report.subAccountReport', [$navWG->id]) }}">Sub Account
                                            Report
                                            <span class="text-danger">(Available Formats: Excel, PDF)</span>
                                        </a>

                                        <a class="list-group-item"
                                            href="{{ route('report.bankScheduleReport', [$navWG->id]) }}">Bank Schedule
                                            Report
                                            <span class="text-danger">(Available Formats: Excel, PDF)</span>
                                        </a>
                                    </div>
                                </fieldset>

                            </div>

                            <div class="col-lg-4 col-12" style="font-size: 11px;">
                                <div>
                                    <fieldset>
                                        <legend>
                                            <h4 class=" fw-bold text-left">Employee Data Reports</h4>
                                        </legend>
                                        <div class="list-group">
                                            <a class="list-group-item"
                                                href="{{ route('report.employeeBiodata', [$navWG->id]) }}">Bio
                                                Data
                                                Report <span class="text-danger">(Available Formats: Excel,
                                                    PDF)</span></a>

                                            <a class="list-group-item"
                                                href="{{ route('report.officialData', [$navWG->id]) }}">Official
                                                Data Report <span class="text-danger">(Available Formats:
                                                    Excel, PDF)</span></a>

                                            <a class="list-group-item"
                                                href="{{ route('report.accountDetails', [$navWG->id]) }}">Account
                                                Details Report <span class="text-danger">(Available Formats:
                                                    Excel, PDF)</span></a>

                                            <a class="list-group-item"
                                                href="{{ route('report.employeeDisengagement', [$navWG->id]) }}">Disengagement
                                                Report <span class="text-danger">(Available Formats: Excel,
                                                    PDF)</span></a>

                                            <a class="list-group-item"
                                                href="{{ route('report.employeeReinstatement', [$navWG->id]) }}">Re-instatement
                                                Report <span class="text-danger">(Available Formats: Excel,
                                                    PDF)</span></a>

                                            <a class="list-group-item"
                                                href="{{ route('report.promotionsReport', [$navWG->id]) }}">Variations
                                                Report <span class="text-danger">(Available Formats: Excel,
                                                    PDF)</span></a>

                                            <a class="list-group-item"
                                                href="{{ route('report.stepIncrementReport', [$navWG->id]) }}">Annual
                                                Step Increment Report <span class="text-danger">(Available Formats:
                                                    Excel, PDF)</span></a>

                                            <a class="list-group-item" href="{{ route("report.biometricReport", [$navWG->id]) }}">Biometric Report <span
                                                    class="text-danger">(Available Formats: PDF)</span></a>

                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-lg-12 col-12 mt-5" style="font-size: 11px;">
                                    <fieldset>
                                        <legend>
                                            <h4 class=" fw-bold text-left">Audit Logs Reports</h4>
                                        </legend>
                                        <div class="list-group">
                                            <a class="list-group-item"
                                                href="{{ route('report.userAuthenticationLogs', [$navWG->id]) }}">Authentication
                                                Logs<span class="text-danger"> (Available Formats: PDF)</span></a>

                                            <a class="list-group-item"
                                                href="{{ route('report.userActivityLogs', [$navWG->id]) }}">Activity
                                                Logs<span class="text-danger"> (Available
                                                    Formats: PDF)</span></a>
                                        </div>
                                    </fieldset>
                                </div>

                                {{-- <div class="col-lg-12 col-12 mt-5" style="font-size: 11px;">
                                    <fieldset>
                                        <legend>
                                            <h4 class=" fw-bold text-left">Setup</h4>
                                        </legend>
                                        <div class="list-group">
                                            <a class="list-group-item"
                                                href="{{ route('report.stepList', [$navWG->id]) }}">Step List Report</a>
                                        </div>
                                    </fieldset>
                                </div> --}}
                            </div>

                            <div class="col-lg-4 col-12" style="font-size: 11px;">
                                <div>
                                    <fieldset>
                                        <legend>
                                            <h4 class=" fw-bold text-left">Payment Reports</h4>
                                        </legend>
                                        <div class="list-group">
                                            <a class="list-group-item"
                                                href="{{ route('report.paymentListReport', [$navWG->id]) }}">Payroll
                                                Payment
                                                List
                                                Report <span class="text-danger">(Available Formats: Excel,
                                                    PDF)</span></a>

                                            <a class="list-group-item" href="{{ route('report.manualPaymentFileReport', [$navWG->id]) }}">Manual Payment Files Report
                                                <span class="text-danger">(Available Formats: Excel, PDF)</span></a>

                                            <a class="list-group-item" href="{{ route("report.nonRegularPayments", [$navWG->id]) }}">Non Regular Payments Report
                                                <span class="text-danger">(Available Formats: Excel, PDF)</span></a>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-lg-12 col-12 mt-5" style="font-size: 11px;">
                                    <fieldset>
                                        <legend>
                                            <h4 class=" fw-bold text-left">Repayable Deductions </h4>
                                        </legend>
                                        <div class="list-group">
                                            <a class="list-group-item"
                                                href="{{ route('report.repayableDeductions', [$navWG->id]) }}">Repayable Deductions<span class="text-danger"> (Available Formats: Excel, PDF)</span></a>
                                        </div>
                                    </fieldset>
                                </div>

                            </div>


                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    document.getElementById("navReports").classList.add('show');
    document.getElementById("reports").classList.add('active');
</script>
@endsection
