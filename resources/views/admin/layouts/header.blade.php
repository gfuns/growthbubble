<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="ATC LMS">
    <meta name="keywords" content="">
    <meta name="author" content="Gabriel Nwankwo">

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">


    <!-- Libs CSS -->
    <link href="{{ asset('assets/fonts/feather/feather.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/bootstrap-icons/font/bootstrap-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/libs/mdi/font/css/materialdesignicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/libs/simplebar/dist/simplebar.min.css') }}" rel="stylesheet">


    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/theme.min.css') }}?version={{ date('his') }}">
    <link href="{{ asset('assets/libs/dropzone/dist/dropzone.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/libs/yaireo/tagify/dist/tagify.css') }}" rel="stylesheet">


    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
    <script src="{{ asset('assets/js/countries.js') }}"></script>

    <title>@yield('title')</title>
    @yield('style')

    <style type="text/css">
        /* Hide sorting icons */
        table.dataTable>thead .sorting::before,
        table.dataTable>thead .sorting_asc::before,
        table.dataTable>thead .sorting_desc::before,
        table.dataTable>thead .sorting_asc_disabled::before,
        table.dataTable>thead .sorting_desc_disabled::before {
            right: 0 !important;
            content: "" !important;
            cursor: default !important;
        }

        table.dataTable>thead .sorting::after,
        table.dataTable>thead .sorting_asc::after,
        table.dataTable>thead .sorting_desc::after,
        table.dataTable>thead .sorting_asc_disabled::after,
        table.dataTable>thead .sorting_desc_disabled::after {
            right: 0 !important;
            content: "" !important;
            cursor: default !important;
        }

        .filterButton {
            padding-top: 23px;
        }

        .back-to-home-label {
            display: inline-flex;
            align-items: center;
            padding: 8px 15px;
            font-size: 12px;
            font-weight: 600;
            color: black;
            background-color: #f0f0f0;
            border: 1px solid #dcdcdc;
            border-radius: 20px;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
        }

        .back-to-home-label i {
            margin-right: 8px;
            /* Space between icon and text */
            font-size: 16px;
            color: #007bff;
        }

        .back-to-home-label:hover {
            background-color: #007bff;
            color: #ffffff;
        }

        .back-to-home-label:hover i {
            color: #ffffff;
        }

        /* Select2 dark mode customization */
        [data-theme="dark"] .select2-container--default .select2-selection--single {
            background-color: var(--geeks-input-bg);
            color: #fff;
            border-color: var(--geeks-input-border);
        }

        [data-theme="dark"] .select2-container--default .select2-dropdown {
            background-color: var(--geeks-input-bg);
            color: #fff;
        }

        [data-theme="dark"] .select2-container--default .select2-results__option {
            background-color: var(--geeks-input-bg);
            color: #fff;
        }

        [data-theme="dark"] .select2-container--default .select2-results__option--highlighted {
            background-color: var(--geeks-input-bg);
            color: #fff;
        }

        [data-theme="dark"] .select2-container--default .select2-search--dropdown .select2-search__field {
            background-color: #121212;
            color: #fff;
        }

        [data-theme="dark"] .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #fff;
            background-color: transparent;
        }

        [data-theme="dark"] .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: var(--geeks-input-bg);
        }

        [data-theme="dark"] .btn-default {
            color: #fff;
        }

        [data-theme="dark"] ::placeholder {
            color: white;
        }


        legend {
            background-color: #0d6efd;
            /* Bootstrap primary color */
            color: #fff;
            /* Text color */
            /* padding: 5px 15px; */
            /* Padding around the text */
            border-radius: 5px;
            font-size: 15px;
            font-weight: bold;
            /* Slightly rounded corners */
            display: inline-block;
            /* Fit content width */
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            /* Optional shadow */
        }

        .smallText {
            color: #0d6efd;
            display: block;
            font-size: .875em;
            /* margin-top: .25rem; */
            width: 100%;
        }

        .wrap-text {
            white-space: normal;
            /* Allows text to wrap to the next line */
            word-wrap: break-word;
            /* Breaks long words if needed */
            overflow-wrap: break-word;
            /* Modern standard for word breaking */
        }

        .dataTables_scrollBody::-webkit-scrollbar {
            width: 3.5px;
            /* thickness */
        }

        .dataTables_scrollBody::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.3);
            border-radius: 4px;
        }

        .dataTables_scrollBody::-webkit-scrollbar-track {
            background: transparent;
        }

        .scrollable-card-body {
            height: calc(100% - 60px);
            /* adjust header height */
            overflow-y: scroll;
            /* ensures scrollbar always shows */
        }

        /* For WebKit browsers (Chrome, Safari, Edge) */
        .scrollable-card-body::-webkit-scrollbar {
            -webkit-appearance: none;
            width: 3.5px;
            /* scrollbar width */
        }

        .scrollable-card-body::-webkit-scrollbar-thumb {
            background-color: #c1c1c1;
            /* scrollbar color */
            border-radius: 6px;
        }
    </style>
</head>
