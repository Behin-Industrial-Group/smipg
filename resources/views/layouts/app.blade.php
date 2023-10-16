<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="{{ url('public/dashboard/plugins/font-awesome/css/font-awesome.min.css') . '?' . config('app.version') }}">
    <link rel="stylesheet"
        href="{{ url('public/dashboard/dist/css/adminlte.min.css') . '?' . config('app.version') }}">
    <link rel="stylesheet"
        href="{{ url('public/dashboard/dist/css/bootstrap-rtl.min.css') . '?' . config('app.version') }}">
    <link rel="stylesheet"
        href="{{ url('public/dashboard/dist/css/custom-style.css') . '?' . config('app.version') }}">
    <link rel="stylesheet" href="{{ url('public/dashboard/dist/css/custom.css') . '?' . config('app.version') }}">
    <link rel="stylesheet"
        href="{{ url('public/dashboard/plugins/select2/select2.min.css') . '?' . config('app.version') }}">
    <link rel="stylesheet"
        href="{{ url('public/dashboard/plugins/persian-date/persian-datepicker.css') . '?' . config('app.version') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    @yield('style')

    <script src="{{ url('public/dashboard/plugins/jquery/jquery.min.js') . '?' . config('app.version') }}"></script>
    <script src="{{ url('public/dashboard/plugins/datatables/jquery.dataTables.js') . '?' . config('app.version') }}">
    </script>
    <script src="{{ url('public/dashboard/plugins/datatables/dataTables.bootstrap4.js') . '?' . config('app.version') }}">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="{{ url('public/js/ajax.js') . '?' . config('app.version') }}"></script>
    <script src="{{ url('public/js/dataTable.js') . '?' . config('app.version') }}"></script>
    <script src="{{ url('public/js/dropzone.js') . '?' . config('app.version') }}"></script>

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        @include('layouts.header')

        @include('layouts.main-sidebar')
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>



        <footer class="main-footer">
            {{-- <strong> &copy; 2018 <a href="http://github.com/hesammousavi/">حسام موسوی</a>.</strong> --}}
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
    </div>

    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script
        src="{{ url('public/dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js') . '?' . config('app.version') }}">
    </script>
    <script src="{{ url('public/dashboard/dist/js/adminlte.js') . '?' . config('app.version') }}"></script>
    <script src="{{ url('public/dashboard/plugins/select2/select2.full.min.js') . '?' . config('app.version') }}">
    </script>
    <script src="{{ url('public/dashboard/plugins/persian-date/persian-date.js') . '?' . config('app.version') }}">
    </script>
    <script src="{{ url('public/dashboard/plugins/persian-date/persian-datepicker.js') . '?' . config('app.version') }}">
    </script>

    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
    <script>
        // $(document).ready(function() {
        //     $('#table').DataTable({
        //         dom: 'Bfltip',
        //         buttons: [{
        //             'extend': 'excel',
        //             'text': 'Excel',
        //             className: 'btn btn-info'
        //         }],
        //         'ajax': ''
        //     });
        //     $('table').attr('style', 'font-weight:bold; font-size: 12px')

        //     initial_view();
        //     hide_loading();
        // });

        function initial_view() {
            $('.select2').select2();
            $(".persian-date").persianDatepicker({
                viewMode: 'year',
                format: 'YYYY-MM-DD',
                initialValueType: 'gregorian',
                calendar: {
                    persian: {
                        locale: 'en'
                    }
                }
            });
        }
    </script>

    <script>
        $('form').keypress(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
            }
        });
    </script>
    <script src="{{ url('public/js/loader.js') . '?' . config('app.version') }}"></script>
    <script src="{{ url('public/js/clearcach.js') . '?' . config('app.version') }}"></script>
    <script src="{{ url('public/js/scripts.js') . '?' . config('app.version') }}"></script>

    @yield('script')
    </div>



</body>

</html>
