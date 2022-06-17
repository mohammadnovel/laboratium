<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('main/images/logo.png') }}">
    <title>SILARE</title>
    <!-- Custom CSS -->
    {{-- <link href="{{ asset('assets/libs/chartist/dist/chartist.min.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('assets/extra-libs/c3/c3.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/libs/morris.js/morris.css') }}" rel="stylesheet" type="text/css">
    <!-- Custom CSS -->
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet"
        type="text/css">
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link
        href="{{ asset('assets/libs/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}"
        rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('dist/css/main.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('/') }}/assets/extra-libs/dropify/css/dropify.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.min.css"
        integrity="sha512-PMjWzHVtwxdq7m7GIxBot5vdxUY+5aKP9wpKtvnNBZrVv1srI8tU6xvFMzG8crLNcMj/8Xl/WWmo/oAP/40p1g=="
        crossorigin="anonymous" />
    <script src="https://cdn.tiny.cloud/1/w3rm55ebkvcowtwvp2qzvqa4lup3cadedbe0f1m3zskkq7k4/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        @include('layouts.header')
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        @include('layouts.sidebar')
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            @include('flash::message')
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            @include('layouts.breadcrumb')
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            @yield('content')
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                All Rights Reserved by Monvear
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>

    <script src="{{ asset('assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dist/js/app.min.js') }}"></script>
    <script src="{{ asset('dist/js/app.init.js') }}"></script>
    <script src="{{ asset('dist/js/app-style-switcher.js') }}"></script>
    <script src="{{ asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/sparkline/sparkline.js') }}"></script>
    <script src="{{ asset('dist/js/waves.js') }}"></script>
    <script src="{{ asset('dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('dist/js/custom.min.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/c3/d3.min.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/c3/c3.min.js') }}"></script>
    <script src="{{ asset('assets/libs/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('assets/libs/morris.js/morris.min.js') }}"></script>

    <script src="{{ asset('assets/extra-libs/DataTables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/jsvalidation/js/jsvalidation.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.all.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/libs/moment/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/extra-libs/dropify/js/dropify.min.js') }}"></script>

    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/js/tempusdominus-bootstrap-4.min.js"
        integrity="sha512-2JBCbWoMJPH+Uj7Wq5OLub8E5edWHlTM4ar/YJkZh3plwB2INhhOC3eDoqHm1Za/ZOSksrLlURLoyXVdfQXqwg=="
        crossorigin="anonymous"></script>


    <script>
        var dataTable = '',
            drEvent = '';
    </script>

    {!! @$validator !!}
    <script>
        $(function() {
            // $('.data-table').DataTable();
            drEvent = $('.dropify').dropify();
            $('#flash-overlay-modal').modal();
            $(".select2").select2({
                width: 'resolve'
            });
            $(".select2-tags").select2({
                tags: true
            });
            $.fn.datetimepicker.Constructor.Default = $.extend({}, $.fn.datetimepicker.Constructor.Default, {
                icons: {
                    time: 'fa fa-clock',
                    date: 'fa fa-calendar',
                    up: 'fa fa-arrow-up',
                    down: 'fa fa-arrow-down',
                    previous: 'fa fa-chevron-left',
                    next: 'fa fa-chevron-right',
                    today: 'fa fa-calendar-check-o',
                    clear: 'fa fa-trash',
                    close: 'fa fa-times'
                },
                format: 'YYYY-MM-DD hh:mm:ss'
            });
            $('form').on('keyup change paste',
                'input:not(".skip-change"), select:not(".skip-change"), textarea:not(".skip-change")',
                function() {
                    $(this).data("changed", true);
                });
            // $("input.v-nospace").limitkeypress({
            //     rexp: /^\S*$/
            // });
            $(".datetimepicker-input").datetimepicker();
            $(".datepicker-input").datetimepicker({
                format: 'YYYY-MM-DD'
            });

            // $(".datetimepicker-input").datetimepicker({
            //     uiLibrary: 'bootstrap4',
            //     format: 'yyyy-mm-dd hh:mm:ss'
            // });
            $("form").submit(function() {
                if ($(this).valid()) {
                    $.each($(this).find("input.number"), function(indexInArray, valueOfElement) {
                        if ($(this).val() != '') {
                            $(this).removeClass('number');
                            $(this).val($(this).val().replace(/,/g, ""));
                        }
                    });
                }

            });

            tinymce.init({
            selector: '.textarea-edit',
            // plugins: 'lists advlist'
            plugins: 'code table lists link',
            menubar: false,
            toolbar: 'link | undo redo | formatselect| bold italic | alignleft aligncenter alignright alignjustify | indent outdent | bullist numlist | code | table'
            });
        });
        
    </script>
    @stack('js')
    <script src="{{ asset('dist/js/main.js') }}"></script>
    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script>
    var options = {
        filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
        filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
        filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
    };
    </script>
    <script>
        CKEDITOR.replace('text-editor', options);
    </script>
</body>

</html>
