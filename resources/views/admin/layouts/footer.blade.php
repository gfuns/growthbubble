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

    @include('sweetalert::alert')

    <script src="{{ asset('assets/js/vendors/sweetalert2.all.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#dataTableBasic').DataTable();
            table.page.len(100).draw(); // Set the page length to 100
        });

        $('#myTasks').DataTable({
            search: true, // disable pagination
            paging: true, // disable pagination
            info: false,
            language: {
                lengthMenu: "_MENU_" // only show the dropdown
            },
            drawCallback: function(settings) {
                $('.dataTables_paginate').hide(); // hide pagination controls
            }
        });


        $(document).ready(function() {
            $('#status').select2();
        });

        $('#selProduct').select2({
            dropdownParent: $('#offcanvasRight')
        });

        $('#frequency').select2({
            dropdownParent: $('#offcanvasRight')
        });

        $('#userrole').select2({
            dropdownParent: $('#offcanvasRight')
        });


        $('#editProduct').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var name = button.data('name') // Extract info from data-* attributes
            var description = button.data('description') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #prodname').val(name)
            offcanvas.find('.offcanvas-body #proddesc').val(description)
        })

        $('#editProductPlan').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var product = button.data('product') // Extract info from data-* attributes
            var plan = button.data('plan') // Extract info from data-* attributes
            var frequency = button.data('frequency') // Extract info from data-* attributes
            var pricing = button.data('pricing') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #plan').val(plan)
            offcanvas.find('.offcanvas-body #pricing').val(pricing)
            $("#freq").select2({
                    dropdownParent: $("#editProductPlan"),
                }).val(frequency)
                .trigger("change");
            $("#productSel").select2({
                    dropdownParent: $("#editProductPlan"),
                }).val(product)
                .trigger("change");
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


        $('#editStaff').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var othernames = button.data('othernames') // Extract info from data-* attributes
            var lastname = button.data('lastname') // Extract info from data-* attributes
            var email = button.data('email') // Extract info from data-* attributes
            var phone = button.data('phone') // Extract info from data-* attributes
            var role = button.data('role') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #othernames').val(othernames)
            offcanvas.find('.offcanvas-body #lastname').val(lastname)
            offcanvas.find('.offcanvas-body #email').val(email)
            offcanvas.find('.offcanvas-body #phone').val(phone)
            $('#uuserrole').select2({
                dropdownParent: $('#editStaff'),
            }).val(role).trigger('change');
        })

        $('#editCustomer').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var othernames = button.data('othernames') // Extract info from data-* attributes
            var lastname = button.data('lastname') // Extract info from data-* attributes
            var email = button.data('email') // Extract info from data-* attributes
            var phone = button.data('phone') // Extract info from data-* attributes
            var organization = button.data('organization') // Extract info from data-* attributes
            var address = button.data('address') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #othernames').val(othernames)
            offcanvas.find('.offcanvas-body #lastname').val(lastname)
            offcanvas.find('.offcanvas-body #email').val(email)
            offcanvas.find('.offcanvas-body #phone').val(phone)
            offcanvas.find('.offcanvas-body #organization').val(organization)
            offcanvas.find('.offcanvas-body #address').val(address)
        })


        $('#viewCustomer').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var model = button.data('model') // Extract info from data-* attributes
            var lastname = button.data('lastname') // Extract info from data-* attributes
            var othernames = button.data('othernames') // Extract info from data-* attributes
            var email = button.data('email') // Extract info from data-* attributes
            var phone = button.data('phone') // Extract info from data-* attributes
            var organization = button.data('organization') // Extract info from data-* attributes
            var address = button.data('address') // Extract info from data-* attributes
            var photo = button.data('photo') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var modal = $(this)
            document.getElementById("vlastname").innerHTML = lastname;
            document.getElementById("vothernames").innerHTML = othernames;
            document.getElementById("vemail").innerHTML = email;
            document.getElementById("vphone").innerHTML = phone;
            document.getElementById("vorganization").innerHTML = organization;
            document.getElementById("vaddress").innerHTML = address;
            document.getElementById("vphoto").src = photo;
        })


        function validateInput(event) {
            const input = event.target;
            let value = input.value;

            // Remove commas from the input value
            value = value.replace(/,/g, '');

            // Regular expression to match non-numeric and non-decimal characters
            const nonNumericDecimalRegex = /[^0-9.]/g;

            if (nonNumericDecimalRegex.test(value)) {
                // If non-numeric or non-decimal characters are found, remove them from the input value
                value = value.replace(nonNumericDecimalRegex, '');
            }

            // Ensure there is only one decimal point in the value
            const decimalCount = value.split('.').length - 1;
            if (decimalCount > 1) {
                value = value.replace(/\./g, '');
            }

            // Assign the cleaned value back to the input field
            input.value = value;
        }
    </script>
