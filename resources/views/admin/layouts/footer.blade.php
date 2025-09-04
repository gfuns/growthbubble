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

        $('#selProduct').select2({
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
            var pricing = button.data('pricing') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #plan').val(plan)
            offcanvas.find('.offcanvas-body #pricing').val(pricing)
            $("#productSel").select2({
                    dropdownParent: $("#editProductPlan"),
                }).val(product)
                .trigger("change");
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
