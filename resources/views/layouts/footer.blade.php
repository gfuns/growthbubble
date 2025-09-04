    <!-- Libs JS -->
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>

    <!-- Theme JS -->
    <script src="{{ asset('assets/js/theme.min.js') }}"></script>

    <script src="{{ asset('assets/libs/jsvectormap/dist/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jsvectormap/dist/maps/world.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/chart.js') }}"></script>
    <script src="{{ asset('assets/libs/flatpickr/dist/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/libs/quill/dist/quill.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/editor.js') }}"></script>
    <script src="{{ asset('assets/libs/dropzone/dist/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/libs/popperjs/core/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/libs/tippy.js/dist/tippy-bundle.umd.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/tooltip.js') }}"></script>
    <script src="{{ asset('assets/libs/yaireo/tagify/dist/tagify.min.js') }}"></script>
    <script src="{{ asset('assets/libs/imask/dist/imask.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/inputmask.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/validation.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>


    {{-- <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/datatables.js') }}"></script> --}}

    @include('sweetalert::alert')

    {{-- @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"]) --}}


    <script src="{{ asset('assets/js/vendors/sweetalert2.all.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#dataTableBasic').DataTable();
            table.page.len(100).draw(); // Set the page length to 100
        });

        $('#editWorkGroup').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var workgroup = button.data('workgroup') // Extract info from data-* attributes
            var classification = button.data('classification') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #wg').val(workgroup)
            $('#uwgclass').select2({
                dropdownParent: $('#editWorkGroup'),
            }).val(classification).trigger('change');
        })

        $('#payrolRights').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var accesstype = button.data('accesstype') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #accesstype').val(accesstype)
        })

        $('#editUserRole').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var role = button.data('userole') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #userole').val(role)
        })

        $('#editPayGroup').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var pg = button.data('pg') // Extract info from data-* attributes
            var pgc = button.data('pgc') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #pg').val(pg)
            offcanvas.find('.offcanvas-body #pgc').val(pgc)
        })

        $('#editGradeLevel').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var gl = button.data('gl') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #gl').val(gl)
        })

        $('#editStep').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var step = button.data('step') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #pstep').val(step)
        })

        $('#reviewTenure').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var tenure = button.data('tenure') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #tenure').val(tenure)
        })

        $('#editBranch').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var branch = button.data('branch') // Extract info from data-* attributes
            var branchcode = button.data('branchcode') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #xbranch').val(branch)
            offcanvas.find('.offcanvas-body #branchcode').val(branchcode)
        })

        $('#editDepartment').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var department = button.data('department') // Extract info from data-* attributes
            var code = button.data('code') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #xdepartment').val(department)
            offcanvas.find('.offcanvas-body #code').val(code)
        })

        $('#editUnit').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var unitname = button.data('unitname') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #unitname').val(unitname)
        })


        $('#viewAdmin').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var firstname = button.data('firstname') // Extract info from data-* attributes
            var lastname = button.data('lastname') // Extract info from data-* attributes
            var email = button.data('email') // Extract info from data-* attributes
            var phone = button.data('phone') // Extract info from data-* attributes
            var gender = button.data('gender') // Extract info from data-* attributes
            var role = button.data('role') // Extract info from data-* attributes
            var photo = button.data('photo') // Extract info from data-* attributes
            var datejoined = button.data('datejoined') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var modal = $(this)
            document.getElementById("vfirstname").innerHTML = firstname;
            document.getElementById("vlastname").innerHTML = lastname;
            document.getElementById("vrole").innerHTML = role;
            document.getElementById("vemail").innerHTML = email;
            document.getElementById("vphone").innerHTML = phone;
            document.getElementById("vgender").innerHTML = gender;
            document.getElementById("vregdate").innerHTML = datejoined;
            document.getElementById("vphoto").src = photo;
        })


        $('#editAdmin').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var firstname = button.data('firstname') // Extract info from data-* attributes
            var lastname = button.data('lastname') // Extract info from data-* attributes
            var email = button.data('email') // Extract info from data-* attributes
            var phone = button.data('phone') // Extract info from data-* attributes
            var workgroup = button.data('workgroup') // Extract info from data-* attributes
            var role = button.data('role') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #firstname').val(firstname)
            offcanvas.find('.offcanvas-body #lastname').val(lastname)
            offcanvas.find('.offcanvas-body #email').val(email)
            offcanvas.find('.offcanvas-body #phone').val(phone)
            $('#eworkgroup').select2({
                dropdownParent: $('#editAdmin'),
            }).val(workgroup).trigger('change');
            $('#role').select2({
                dropdownParent: $('#editAdmin'),
            }).val(role).trigger('change');
        })




        $('#editVendor').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var firstname = button.data('firstname') // Extract info from data-* attributes
            var lastname = button.data('lastname') // Extract info from data-* attributes
            var othernames = button.data('othernames') // Extract info from data-* attributes
            var email = button.data('email') // Extract info from data-* attributes
            var phone = button.data('phone') // Extract info from data-* attributes
            var gender = button.data('gender') // Extract info from data-* attributes
            var address = button.data('address') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #firstname').val(firstname)
            offcanvas.find('.offcanvas-body #lastname').val(lastname)
            offcanvas.find('.offcanvas-body #othernames').val(othernames)
            offcanvas.find('.offcanvas-body #email').val(email)
            offcanvas.find('.offcanvas-body #phone').val(phone)
            offcanvas.find('.offcanvas-body #address').val(address)
            $('#gender').select2({
                dropdownParent: $('#editVendor'),
            }).val(gender).trigger('change');

        })


        $('#viewStation').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var stationname = button.data('stationname') // Extract info from data-* attributes
            var stationaddress = button.data('stationaddress') // Extract info from data-* attributes
            var established = button.data('established') // Extract info from data-* attributes
            var defaulted = button.data('defaulted') // Extract info from data-* attributes
            var taxcategory = button.data('taxcategory') // Extract info from data-* attributes
            var taxamount = button.data('taxamount') // Extract info from data-* attributes
            var totaldebt = button.data('totaldebt') // Extract info from data-* attributes
            var photo = button.data('photo') // Extract info from data-* attributes
            var remittance = button.data('remittance') // Extract info from data-* attributes
            var oustanding = button.data('oustanding') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var modal = $(this)
            document.getElementById("vname").innerHTML = stationname;
            document.getElementById("vaddress").innerHTML = stationaddress;
            document.getElementById("vestablished").innerHTML = established;
            document.getElementById("vdefaulted").innerHTML = defaulted;
            document.getElementById("vcategory").innerHTML = taxcategory;
            document.getElementById("vtaxamount").innerHTML = taxamount;
            document.getElementById("vdebt").innerHTML = totaldebt;
            document.getElementById("vremittance").innerHTML = remittance;
            document.getElementById("voutstanding").innerHTML = oustanding;
        })



        $('#usergender').select2({
            dropdownParent: $('#offcanvasRight')
        });

        $('#wgal').select2({
            dropdownParent: $('#addStepAllowance')
        });

        $('#coursecatsel').select2({
            dropdownParent: $('#offcanvasRight')
        });

        $('#userrole').select2({
            dropdownParent: $('#offcanvasRight')
        });

        $('#workgroup').select2({
            dropdownParent: $('#offcanvasRight')
        });

        $('#paygroup').select2({
            dropdownParent: $('#offcanvasRight')
        });

        $('#droppt').select2({
            dropdownParent: $('#offcanvasRight')
        });

        $('#dropmonth').select2({
            dropdownParent: $('#offcanvasRight')
        });

        $('#dropyear').select2({
            dropdownParent: $('#offcanvasRight')
        });

        $('#wgclass').select2({
            dropdownParent: $('#offcanvasRight')
        });

        $('#bank').select2({
            dropdownParent: $('#resolveBankIssue')
        });

        $('#bankd').select2({
            dropdownParent: $('#offcanvasRight')
        });

        $("#configType").select2({
            dropdownParent: $("#addStepAllowance"),
        });

        $("#rejereason").select2({
            dropdownParent: $("#rejectPayroll"),
        });

        $("#rejeappreason").select2({
            dropdownParent: $("#rejectAppFile"),
        });

        $("#rejerevreason").select2({
            dropdownParent: $("#rejectRevFile"),
        });

        $("#rejeauthreason").select2({
            dropdownParent: $("#rejectAuthFile"),
        });

        $("#rejefinauthreason").select2({
            dropdownParent: $("#rejectFinAuthFile"),
        });

        $('#editRole').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var role = button.data('role') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #role').val(role)
        })



        // In your Javascript (external .js resource or <script> tag)


        $(document).ready(function() {
            $('#gender').select2();
        });

        $(document).ready(function() {
            $('#category').select2();
        });

        $(document).ready(function() {
            $('#maritalstatus').select2();
        });

        $(document).ready(function() {
            $('#religion').select2();
        });

        $(document).ready(function() {
            $('#nokrel').select2();
        });

        $(document).ready(function() {
            $('#state').select2();
        });

        $(document).ready(function() {
            $('#euwg').select2();
        });

        $(document).ready(function() {
            $('#eupg').select2();
        });

        $(document).ready(function() {
            $('#eudpt').select2();
        });

        $(document).ready(function() {
            $('#taxstation').select2();
        });

        $(document).ready(function() {
            $('#taxmonthyear').select2();
        });

        $(document).ready(function() {
            $('#taxperiod').select2();
        });

        $('#banks').select2({});
        $('#paygroup').select2({});
        $('#level').select2({});
        $('#step').select2({});
        $('#period').select2({});
        $('#branch').select2({});
        $('#department').select2({});
        $('#unit').select2({});
        $('#format').select2({});
        $('#allowance').select2({});
        $('#deduction').select2({});
        $('#month').select2({});
        $('#year').select2({});
        $('#pt').select2({});
        $('#paystattion').select2({});
    </script>



    <script type="text/javascript">
        $('#editWorkGroup').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var workgroup = button.data('workgroup') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #dwg').val(workgroup)
        })

        $('#editAllowance').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var allowancename = button.data('allowancename') // Extract info from data-* attributes
            var allowancecode = button.data('allowancecode') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #allowancename').val(allowancename)
            offcanvas.find('.offcanvas-body #allowancecode').val(allowancecode)
        })

        $('#editStepAllowance').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var allowanceid = button.data('allowanceid') // Extract info from data-* attributes
            var amount = button.data('amount') // Extract info from data-* attributes
            var amounttype = button.data('amounttype') // Extract info from data-* attributes
            var percentage = button.data('percentage') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #uamount').val(amount)
            offcanvas.find('.offcanvas-body #amounttype').val(amounttype)
            offcanvas.find('.offcanvas-body #upercentage').val(percentage)
            $('#dwgal').select2({
                dropdownParent: $('#editStepAllowance'),
            }).val(allowanceid).trigger('change');

            $("#uconfigType").select2({
                    dropdownParent: $("#editStepAllowance"),
                }).val(amounttype)
                .trigger("change");
        })

        $('#addStepAllowance').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
        })

        $('#editStepDeduction').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var deductionid = button.data('deductionid') // Extract info from data-* attributes
            var amount = button.data('amount') // Extract info from data-* attributes
            var amounttype = button.data('amounttype') // Extract info from data-* attributes
            var percentage = button.data('percentage') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #amount').val(amount)
            offcanvas.find('.offcanvas-body #amounttype').val(amounttype)
            offcanvas.find('.offcanvas-body #percentage').val(percentage)
            $('#dwded').select2({
                dropdownParent: $('#editStepDeduction'),
            }).val(deductionid).trigger('change');

            $("#uconfigType").select2({
                    dropdownParent: $("#editStepDeduction"),
                }).val(amounttype)
                .trigger("change");
        })

        $('#addStepDeduction').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
        })

        $('#editDeduction').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var deductionname = button.data('deductionname') // Extract info from data-* attributes
            var deductioncode = button.data('deductioncode') // Extract info from data-* attributes
            var statutory = button.data('statutory') // Extract info from data-* attributes
            var union = button.data('union') // Extract info from data-* attributes
            var contributenlc = button.data('contributenlc') // Extract info from data-* attributes
            var repayable = button.data('repayable') // Extract info from data-* attributes
            var status = button.data('status') // Extract info from data-* attributes
            var bank = button.data('bank') // Extract info from data-* attributes
            var accountname = button.data('accountname') // Extract info from data-* attributes
            var accountnumber = button.data('accountnumber') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #deductionname').val(deductionname)
            offcanvas.find('.offcanvas-body #deductioncode').val(deductioncode)
            offcanvas.find('.offcanvas-body #accountname').val(accountname)
            offcanvas.find('.offcanvas-body #accountnumber').val(accountnumber)
            $('#opt1').select2({
                dropdownParent: $('#editDeduction'),
            }).val(statutory).trigger('change');
            $('#opt2').select2({
                dropdownParent: $('#editDeduction'),
            }).val(union).trigger('change');
            $('#opt3').select2({
                dropdownParent: $('#editDeduction'),
            }).val(contributenlc).trigger('change');
            $('#opt4').select2({
                dropdownParent: $('#editDeduction'),
            }).val(repayable).trigger('change');
            $('#opt5').select2({
                dropdownParent: $('#editDeduction'),
            }).val(status).trigger('change');
            $('#banked').select2({
                dropdownParent: $('#editDeduction'),
            }).val(bank).trigger('change');
        })



        $('#editPayGroup').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var pg = button.data('pg') // Extract info from data-* attributes
            var pgc = button.data('pgc') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #pg').val(pg)
            offcanvas.find('.offcanvas-body #pgc').val(pgc)
        })

        $('#editGradeLevel').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var gl = button.data('gl') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #gl').val(gl)
        })

        $('#editStep').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var step = button.data('step') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #step').val(step)
        })

        $('#uploadComment').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var comment = button.data('comment') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var modal = $(this)
            // modal.find('.modal-body #myid').val(myid)
            document.getElementById("comment").innerHTML = comment;
        })

        $('#resolveNGUploadIssue').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var empno = button.data('empno') // Extract info from data-* attributes
            var bank = button.data('bank') // Extract info from data-* attributes
            var accountno = button.data('accountno') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #empno').val(empno)
            offcanvas.find('.offcanvas-body #accountno').val(accountno)
            $('#bank').select2({
                dropdownParent: $('#resolveNGUploadIssue'),
            }).val(bank).trigger('change');
        })

        $('#resolveUploadIssue').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var paygroup = button.data('paygroup') // Extract info from data-* attributes
            var level = button.data('level') // Extract info from data-* attributes
            var step = button.data('step') // Extract info from data-* attributes
            var branch = button.data('branch') // Extract info from data-* attributes
            var bank = button.data('bank') // Extract info from data-* attributes
            var accno = button.data('accno') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #accno').val(accno)
            $('#paygroup').select2({
                dropdownParent: $('#resolveUploadIssue'),
            }).val(paygroup).trigger('change');
            $('#level').select2({
                dropdownParent: $('#resolveUploadIssue'),
            }).val(level).trigger('change');
            $('#step').select2({
                dropdownParent: $('#resolveUploadIssue'),
            }).val(step).trigger('change');
            $('#branch').select2({
                dropdownParent: $('#resolveUploadIssue'),
            }).val(branch).trigger('change');
            $('#bank').select2({
                dropdownParent: $('#resolveUploadIssue'),
            }).val(bank).trigger('change');
        })

        $('#resolveEAUploadIssue').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var employeeno = button.data('employeeno') // Extract info from data-* attributes
            var tenure = button.data('tenure') // Extract info from data-* attributes
            var amount = button.data('amount') // Extract info from data-* attributes
            var allowance = button.data('allowance') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #employeeno').val(employeeno)
            offcanvas.find('.offcanvas-body #tenure').val(tenure)
            offcanvas.find('.offcanvas-body #amount').val(amount)
            $('#allowance').select2({
                dropdownParent: $('#resolveEAUploadIssue'),
            }).val(allowance).trigger('change');
        })

        $('#resolveEDUploadIssue').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var employeeno = button.data('employeeno') // Extract info from data-* attributes
            var tenure = button.data('tenure') // Extract info from data-* attributes
            var amount = button.data('amount') // Extract info from data-* attributes
            var deduction = button.data('deduction') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #employeeno').val(employeeno)
            offcanvas.find('.offcanvas-body #tenure').val(tenure)
            offcanvas.find('.offcanvas-body #amount').val(amount)
            $('#deduction').select2({
                dropdownParent: $('#resolveEDUploadIssue'),
            }).val(deduction).trigger('change');
        })

        $('#resolveELUploadIssue').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var employeeno = button.data('employeeno') // Extract info from data-* attributes
            var monthlyamount = button.data('monthlyamount') // Extract info from data-* attributes
            var amount = button.data('amount') // Extract info from data-* attributes
            var deduction = button.data('deduction') // Extract info from data-* attributes
            var startperiod = button.data('startperiod') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #employeeno').val(employeeno)
            offcanvas.find('.offcanvas-body #amount').val(amount)
            offcanvas.find('.offcanvas-body #monthlyamount').val(monthlyamount)
            offcanvas.find('.offcanvas-body #startperiod').val(startperiod)
            $('#deduction').select2({
                dropdownParent: $('#resolveELUploadIssue'),
            }).val(deduction).trigger('change');
        })

        $('#resolveEDisUploadIssue').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var employeeno = button.data('employeeno') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #employeeno').val(employeeno)
        })

        $('#rejectPayroll').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var modal = $(this)
            // modal.find('.modal-body #myid').val(myid)
            modal.find('.modal-body #myid').val(myid)
        })

        $('#rejectAuthFile').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var modal = $(this)
            // modal.find('.modal-body #myid').val(myid)
            modal.find('.modal-body #myid').val(myid)
        })

        $('#rejectFinAuthFile').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var modal = $(this)
            // modal.find('.modal-body #myid').val(myid)
            modal.find('.modal-body #myid').val(myid)
        })

        $('#rejectAppFile').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var modal = $(this)
            // modal.find('.modal-body #myid').val(myid)
            modal.find('.modal-body #myid').val(myid)
        })

        $('#rejectRevFile').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var modal = $(this)
            // modal.find('.modal-body #myid').val(myid)
            modal.find('.modal-body #myid').val(myid)
        })



        $("#configType").change(function() {
            var configType = $(this).val();
            if (configType == "Fixed") {
                $("#camo").css("display", "block");
                $("#camount").attr("required", true);
                $("#cper").css("display", "none");
                $("#cpercentage").removeAttr("required");
            } else if (configType == "Percentage") {
                $("#cper").css("display", "block");
                $("#cpercentage").attr("required", true);
                $("#camo").css("display", "none");
                $("#camount").removeAttr("required");
            } else {
                $("#camo").css("display", "none");
                $("#cper").css("display", "none");
                $("#camount").removeAttr("required");
                $("#cpercentage").removeAttr("required");
            }
        });

        $("#uconfigType").change(function() {
            var configType = $(this).val();
            if (configType == "Fixed") {
                $("#uamo").css("display", "block");
                $("#uamount").attr("required", true);
                $("#uper").css("display", "none");
                $("#upercentage").removeAttr("required");
            } else if (configType == "Percentage") {
                $("#uper").css("display", "block");
                $("#upercentage").attr("required", true);
                $("#uamo").css("display", "none");
                $("#uamount").removeAttr("required");
            } else {
                $("#uamo").css("display", "none");
                $("#uper").css("display", "none");
                $("#uamount").removeAttr("required");
                $("#upercentage").removeAttr("required");
            }
        });

        $('#resolveBankIssue').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var bank = button.data('bank') // Extract info from data-* attributes
            var accountno = button.data('accountno') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #accountno').val(accountno)
             $('#bank').select2({
                dropdownParent: $('#resolveBankIssue'),
            }).val(bank).trigger('change');
        })


        $('#viewAuthDetails').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var surname = button.data('surname') // Extract info from data-* attributes
            var firstname = button.data('firstname') // Extract info from data-* attributes
            var othernames = button.data('othernames') // Extract info from data-* attributes
            var role = button.data('role') // Extract info from data-* attributes
            var datecreated = button.data('datecreated') // Extract info from data-* attributes
            var event = button.data('event') // Extract info from data-* attributes
            var ip = button.data('ip') // Extract info from data-* attributes
            var agent = button.data('agent') // Extract info from data-* attributes
            var description = button.data('description') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var modal = $(this)
            document.getElementById("vsurname").innerHTML = surname;
            document.getElementById("vfirstname").innerHTML = firstname;
            document.getElementById("vothernames").innerHTML = othernames;
            document.getElementById("vrole").innerHTML = role;
            document.getElementById("vdatecreated").innerHTML = datecreated;
            document.getElementById("vevent").innerHTML = event;
            document.getElementById("vdescription").innerHTML = description;
            document.getElementById("vip").innerHTML = ip;
            document.getElementById("vagent").innerHTML = agent;
        })

        $('#viewAuditDetails').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var surname = button.data('surname') // Extract info from data-* attributes
            var firstname = button.data('firstname') // Extract info from data-* attributes
            var othernames = button.data('othernames') // Extract info from data-* attributes
            var role = button.data('role') // Extract info from data-* attributes
            var datecreated = button.data('datecreated') // Extract info from data-* attributes
            var event = button.data('event') // Extract info from data-* attributes
            var ip = button.data('ip') // Extract info from data-* attributes
            var agent = button.data('agent') // Extract info from data-* attributes
            var model = button.data('table') // Extract info from data-* attributes
            var newvalues = button.data('newrecord') // Extract info from data-* attributes
            var oldvalues = button.data('oldrecord') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var modal = $(this)
            document.getElementById("vsurname").innerHTML = surname;
            document.getElementById("vfirstname").innerHTML = firstname;
            document.getElementById("vothernames").innerHTML = othernames;
            document.getElementById("vrole").innerHTML = role;
            document.getElementById("vdatecreated").innerHTML = datecreated;
            document.getElementById("vevent").innerHTML = event;
            document.getElementById("vip").innerHTML = ip;
            document.getElementById("vagent").innerHTML = agent;
            document.getElementById("vmodel").innerHTML = model;
            document.getElementById("voldvalues").innerHTML = oldvalues;
            document.getElementById("vnewvalues").innerHTML = newvalues;
        })



        $('#resolvePersonalDataUpdateIssue').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var employeeno = button.data('employeeno') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #employeeno').val(employeeno)

        })

        $('#resolveBankUpdateIssue').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var employeeno = button.data('employeeno') // Extract info from data-* attributes
            var bank = button.data('bank') // Extract info from data-* attributes
            var accountno = button.data('accountno') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #employeeno').val(employeeno)
            offcanvas.find('.offcanvas-body #accountno').val(accountno)
            $('#bank').select2({
                dropdownParent: $('#resolveBankUpdateIssue'),
            }).val(bank).trigger('change');

        })

        $('#resolveSGLUpdateIssue').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var employeeno = button.data('employeeno') // Extract info from data-* attributes
            var paygroup = button.data('paygroup') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #employeeno').val(employeeno)
            $('#paygroup').select2({
                dropdownParent: $('#resolveSGLUpdateIssue'),
            }).val(paygroup).trigger('change');

        })


        $('#resolveMDAUpdateIssue').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var employeeno = button.data('employeeno') // Extract info from data-* attributes
            var branch = button.data('branch') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #employeeno').val(employeeno)
            $('#branch').select2({
                dropdownParent: $('#resolveMDAUpdateIssue'),
            }).val(branch).trigger('change');

        })

        $('#resolveBranchUploadIssue').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var branch = button.data('branch') // Extract info from data-* attributes
            var branchcode = button.data('branchcode') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #branchname').val(branch)
            offcanvas.find('.offcanvas-body #branchcode').val(branchcode)

        })

        $('#resolveDeductionUploadIssue').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var dedname = button.data('dedname') // Extract info from data-* attributes
            var dedcode = button.data('dedcode') // Extract info from data-* attributes
            var accname = button.data('accname') // Extract info from data-* attributes
            var accno = button.data('accno') // Extract info from data-* attributes
            var bankcode = button.data('bankcode') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #dedname').val(dedname)
            offcanvas.find('.offcanvas-body #dedcode').val(dedcode)
            offcanvas.find('.offcanvas-body #accname').val(accname)
            offcanvas.find('.offcanvas-body #accno').val(accno)

            $('#bankcode').select2({
                dropdownParent: $('#resolveDeductionUploadIssue'),
            }).val(bankcode).trigger('change');

        })

        $('#resolveAllowanceUploadIssue').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var allname = button.data('allname') // Extract info from data-* attributes
            var allcode = button.data('allcode') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #allname').val(allname)
            offcanvas.find('.offcanvas-body #allcode').val(allcode)

        })

        $('#resolveSimplifiedAllowanceIssue').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var allowance = button.data('allowance') // Extract info from data-* attributes
            var paygroup = button.data('paygroup') // Extract info from data-* attributes
            var level = button.data('level') // Extract info from data-* attributes
            var step = button.data('step') // Extract info from data-* attributes
            var configtype = button.data('configtype') // Extract info from data-* attributes
            var percentage = button.data('percentage') // Extract info from data-* attributes
            var amount = button.data('amount') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #upercentage').val(percentage)
            offcanvas.find('.offcanvas-body #uamount').val(amount)

            $('#paygroup').select2({
                dropdownParent: $('#resolveSimplifiedAllowanceIssue'),
            }).val(paygroup).trigger('change');

            $('#level').select2({
                dropdownParent: $('#resolveSimplifiedAllowanceIssue'),
            }).val(level).trigger('change');

            $('#step').select2({
                dropdownParent: $('#resolveSimplifiedAllowanceIssue'),
            }).val(step).trigger('change');

            $('#uconfigType').select2({
                dropdownParent: $('#resolveSimplifiedAllowanceIssue'),
            }).val(configtype).trigger('change');

            $('#allowance').select2({
                dropdownParent: $('#resolveSimplifiedAllowanceIssue'),
            }).val(allowance).trigger('change');


        })


        function disableAfterClick(link) {
            if (link.classList.contains('clicked')) {
                return false; // Stop multiple clicks
            }
            link.classList.add('clicked'); // Mark as clicked
            link.innerHTML = "Submitting request, please wait...";
            link.style.pointerEvents = "none"; // Prevent further clicks (optional)
            link.style.opacity = "0.6"; // Optional: make it look disabled
            return true; // Allow the link to follow the href
        }


        function disableLink(link) {
            // Prevent double click
            link.onclick = null;
            link.style.pointerEvents = "none"; // Disable further clicks
            link.style.opacity = "0.6"; // Optional: make it look disabled
            link.innerHTML = "Submitting request, please wait...";
        }
    </script>
