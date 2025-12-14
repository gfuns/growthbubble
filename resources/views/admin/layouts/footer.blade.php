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
    {{-- <script src="{{ asset('assets/libs/quill/dist/quill.min.js') }}"></script> --}}
    <script src="{{ asset('assets/libs/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/vendors/editor.js') }}"></script> --}}
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
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    @include('sweetalert::alert')

    <script src="{{ asset('assets/js/vendors/sweetalert2.all.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#dataTableBasic').DataTable();
            table.page.len(100).draw(); // Set the page length to 100
        });

        $('#prodTable1').DataTable({
            search: true, // disable pagination
            paging: true, // disable pagination
            info: false,
            ordering:false,
            language: {
                lengthMenu: "_MENU_" // only show the dropdown
            },
            drawCallback: function(settings) {
                $('.dataTables_paginate').hide(); // hide pagination controls
            },
            scrollY: '230px', // inside your 400px card; adjust for header/padding
            scrollCollapse: true,
        });

        $('#prodTable2').DataTable({
            search: true, // disable pagination
            paging: true, // disable pagination
            info: false,
            ordering:false,
            language: {
                lengthMenu: "_MENU_" // only show the dropdown
            },
            drawCallback: function(settings) {
                $('.dataTables_paginate').hide(); // hide pagination controls
            },
            scrollY: '230px', // inside your 400px card; adjust for header/padding
            scrollCollapse: true,
        });

        $('#prodTable3').DataTable({
            search: true, // disable pagination
            paging: true, // disable pagination
            info: false,
            language: {
                lengthMenu: "_MENU_" // only show the dropdown
            },
            drawCallback: function(settings) {
                $('.dataTables_paginate').hide(); // hide pagination controls
            },
            scrollY: '230px', // inside your 400px card; adjust for header/padding
            scrollCollapse: true,
        });

        $('#myTasks').DataTable({
            search: true, // disable pagination
            paging: true, // disable pagination
            info: false,
            ordering: false,
            language: {
                lengthMenu: "_MENU_" // only show the dropdown
            },
            drawCallback: function(settings) {
                $('.dataTables_paginate').hide(); // hide pagination controls
            },
            scrollY: '230px', // inside your 400px card; adjust for header/padding
            scrollCollapse: true,
            scrollX: true, // ✅ enables horizontal scroll syncing
            autoWidth: false // helps prevent misalignment issues
        });


        $(document).ready(function() {
            $('#customer').select2();
        });

        $(document).ready(function() {
            $('#project').select2();
        });

        $(document).ready(function() {
            $('#status').select2();
        });

        $(document).ready(function() {
            $('#period').select2();
        });

        $(document).ready(function() {
            $('#prod').select2();
        });

        $('#teamMember').select2({
            dropdownParent: $('#taskAssignment')
        });

        $('#client').select2({
            dropdownParent: $('#offcanvasRight')
        });

        $('#selProduct').select2({
            dropdownParent: $('#offcanvasRight')
        });

        $('#custSelProd').select2({
            dropdownParent: $('#offcanvasRight')
        });

        $('#custSelPlan').select2({
            dropdownParent: $('#offcanvasRight')
        });

        $('#custProduct').select2({
            dropdownParent: $('#changeCustomerPlan')
        });

        $('#custPlan').select2({
            dropdownParent: $('#changeCustomerPlan')
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

        $('#editProductFeature').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var feature = button.data('feature') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #feature').val(feature)
        })

        $('#editProductPlan').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var product = button.data('product') // Extract info from data-* attributes
            var plan = button.data('plan') // Extract info from data-* attributes
            var frequency = button.data('frequency') // Extract info from data-* attributes
            var pricing = button.data('pricing') // Extract info from data-* attributes
            var tasks = button.data('tasks') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #plan').val(plan)
            offcanvas.find('.offcanvas-body #pricing').val(pricing)
            offcanvas.find('.offcanvas-body #tasks').val(tasks)
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
            var representative = button.data('representative') // Extract info from data-* attributes
            var lastname = button.data('lastname') // Extract info from data-* attributes
            var othernames = button.data('othernames') // Extract info from data-* attributes
            var email = button.data('email') // Extract info from data-* attributes
            var phone = button.data('phone') // Extract info from data-* attributes
            var client = button.data('client') // Extract info from data-* attributes
            var address = button.data('address') // Extract info from data-* attributes
            var photo = button.data('photo') // Extract info from data-* attributes
            var product = button.data('product') // Extract info from data-* attributes
            var plan = button.data('plan') // Extract info from data-* attributes
            var subdate = button.data('effectivedate') // Extract info from data-* attributes
            var renewaldate = button.data('expirydate') // Extract info from data-* attributes
            var status = button.data('status') // Extract info from data-* attributes
            var myid = button.data('myid') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.


            var modal = $(this)
            document.getElementById("vrepresentative").innerHTML = representative;
            document.getElementById("vemail").innerHTML = email;
            document.getElementById("vphone").innerHTML = phone;
            document.getElementById("vclient").innerHTML = client;
            document.getElementById("vaddress").innerHTML = address;
            document.getElementById("vphoto").src = photo;
            document.getElementById("vproduct").innerHTML = product;
            document.getElementById("vplan").innerHTML = plan;
            document.getElementById("vsubdate").innerHTML = subdate;
            document.getElementById("vrenewaldate").innerHTML = renewaldate;
            document.getElementById("vstatus").innerHTML = status;


            if (document.getElementById('activateLink')) {
                document.getElementById("activateLink").href = "/portal/admin/activate-customer/" + myid;
            }
            if (document.getElementById('suspendLink')) {
                document.getElementById("suspendLink").href = "/portal/admin/suspend-customer/" + myid;
            }

            $("#editDetailsBtn").data({
                myid: myid,
                lastname: lastname,
                othernames: othernames,
                email: email,
                phone: phone,
                organization: client,
                address: address
            });

            $("#changePlan").data({
                myid: myid,
            });

            $('#editDetailsBtn').on('click', function() {
                // Close the modal before opening the offcanvas
                $('#viewCustomer').modal('hide');
            });

            $('#changePlan').on('click', function() {
                // Close the modal before opening the offcanvas
                $('#viewCustomer').modal('hide');
            });
        })



        $('#editTaskCategory').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var category = button.data('category') // Extract info from data-* attributes
            var icon = button.data('icon') // Extract info from data-* attributes
            var bgcolor = button.data('bgcolor') // Extract info from data-* attributes
            var bordercolor = button.data('bordercolor') // Extract info from data-* attributes
            var textcolor = button.data('textcolor') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #category').val(category)
            offcanvas.find('.offcanvas-body #icon').val(icon)
            offcanvas.find('.offcanvas-body #bgColor').val(bgcolor)
            offcanvas.find('.offcanvas-body #borderColor').val(bordercolor)
            offcanvas.find('.offcanvas-body #textColor').val(textcolor)
        })


        $('#viewProject').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var model = button.data('model') // Extract info from data-* attributes
            var client = button.data('client') // Extract info from data-* attributes
            var creator = button.data('creator') // Extract info from data-* attributes
            var title = button.data('title') // Extract info from data-* attributes
            var description = button.data('description') // Extract info from data-* attributes
            var date = button.data('date') // Extract info from data-* attributes
            var status = button.data('status') // Extract info from data-* attributes
            var myid = button.data('myid') // Extract info from data-* attributes
            var customerid = button.data('customerid') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var modal = $(this)
            document.getElementById("vclient").innerHTML = client;
            document.getElementById("vcreator").innerHTML = creator;
            document.getElementById("vtitle").innerHTML = title;
            document.getElementById("vdescription").innerHTML = description;
            document.getElementById("vdate").innerHTML = date;
            document.getElementById("vstatus").innerHTML = status;
            if (document.getElementById('closeProject')) {
                document.getElementById("closeProject").href = "/portal/admin/project/close/" + myid;
            }

            $("#editProjectBtn").data({
                myid: myid,
                customer: customerid,
                title: title,
                description: description,
            });

            $('#editProjectBtn').on('click', function() {
                // Close the modal before opening the offcanvas
                $('#viewProject').modal('hide');
            });


        })


        $('#updateProject').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var customer = button.data('customer') // Extract info from data-* attributes
            var title = button.data('title') // Extract info from data-* attributes
            var description = button.data('description') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #projTit').val(title)
            offcanvas.find('.offcanvas-body #projDes').val(description)
            $('#owner').select2({
                dropdownParent: $('#updateProject'),
            }).val(customer).trigger('change');
        })

        $('#updateTask').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var priority = button.data('priority') // Extract info from data-* attributes
            var status = button.data('status') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var modal = $(this)
            // modal.find('.modal-body #myid').val(myid)
            $('#taskPriority').select2({
                dropdownParent: $('#updateTask'),
            }).val(priority).trigger('change');
            $('#taskStat').select2({
                dropdownParent: $('#updateTask'),
            }).val(status).trigger('change');
        })

        $('#changeCustomerPlan').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
        })

        $('#editWebsiteInfo').on('show.bs.offcanvas', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var myid = button.data('myid') // Extract info from data-* attributes
            var websiteurl = button.data('websiteurl') // Extract info from data-* attributes
            var adminurl = button.data('adminurl') // Extract info from data-* attributes
            var username = button.data('username') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var offcanvas = $(this)
            // modal.find('.modal-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #myid').val(myid)
            offcanvas.find('.offcanvas-body #websiteurl').val(websiteurl)
            offcanvas.find('.offcanvas-body #adminurl').val(adminurl)
            offcanvas.find('.offcanvas-body #username').val(username)
        })

        $('#viewActivity').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var model = button.data('model') // Extract info from data-* attributes
            var activity = button.data('activity') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var modal = $(this)
            document.getElementById("activity").innerHTML = activity;
        })

        $('#uploadedFileModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var model = button.data('model') // Extract info from data-* attributes
            var myid = button.data('myid') // Extract info from data-* attributes
            var uploadedfile = button.data('uploadedfile') // Extract info from data-* attributes
            var extension = button.data('filetype') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var container = document.getElementById('uploadedFileContent');
            container.innerHTML = ''; // Clear previous content


            if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(extension)) {
                // Image
                var img = document.createElement('img');
                img.src = uploadedfile;
                img.className = 'img-fluid';
                container.appendChild(img);
            } else if (extension === 'pdf') {
                // PDF
                var iframe = document.createElement('iframe');
                iframe.src = uploadedfile;
                iframe.width = '100%';
                iframe.height = '500px';
                iframe.style.border = 'none';
                container.appendChild(iframe);
            } else if (['xls', 'xlsx', 'csv', 'ppt', 'pptx'].includes(extension)) {
                // Office files via Google Docs Viewer
                var iframe = document.createElement('iframe');
                iframe.src = 'https://docs.google.com/gview?url=' + encodeURIComponent(uploadedfile) +
                    '&embedded=true';
                iframe.width = '100%';
                iframe.height = '500px';
                iframe.style.border = 'none';
                container.appendChild(iframe);
            } else {
                // Fallback: download link
                var a = document.createElement('a');
                a.href = uploadedfile;
                a.textContent = 'Download File';
                a.target = '_blank';
                container.appendChild(a);
            }


            // document.getElementById("downloadDocBtn").href = uploadedfile;
            document.getElementById("deleteDocBtn").href = "/portal/admin/deleteFile/" + myid;
            document.getElementById("downloadDocBtn").href = "/portal/admin/downloadFile/" + myid;
        })

        $('#fileComment').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var model = button.data('model') // Extract info from data-* attributes
            var comment = button.data('comment') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var modal = $(this)
            document.getElementById("comment").innerHTML = comment;
        })

        $('#copyPlanURL').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var model = button.data('model') // Extract info from data-* attributes
            var url = button.data('url') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            var modal = $(this)
            modal.find('.modal-body #link').val(url)
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

        document.getElementById('recurringYes').addEventListener('change', function() {
            if (this.checked) {
                $("#autopt1").css("display", "block");
                $("#recurringDate").attr("required", true);
            }
        });

        document.getElementById('recurringNo').addEventListener('change', function() {
            if (this.checked) {
                $("#autopt1").css("display", "none");
                $("#recurringDate").removeAttr("required");
            }
        });


        document.getElementById('laterSchedule').addEventListener('change', function() {
            if (this.checked) {
                $("#autopt2").css("display", "block");
                $("#scheduledDate").attr("required", true);
            }
        });

        document.getElementById('regularTimeline').addEventListener('change', function() {
            if (this.checked) {
                $("#autopt2").css("display", "none");
                $("#scheduledDate").removeAttr("required");
            }
        });
    </script>
