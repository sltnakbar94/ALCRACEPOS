<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
  
    <!-- Meta -->
    <meta name="description" content="ALC Race POINT OF SALE">
    <meta name="author" content="ALC Race">

    <title>ALC Race - @yield('title')</title>

    <!-- vendor css -->
    {{-- <link rel="stylesheet" href="{{ mix('css/app.css') }}"> --}}
    <link href="{{ asset('assets/lib/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/Ionicons/css/ionicons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/rickshaw/css/rickshaw.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/datatables/css/jquery.dataTables.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/select2/css/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <!-- Slim CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/slim.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/tcr.css') }}">
    <style>
      .dataTables_length select{
        width: 60px !important;
      }
    </style>
    @yield('style')
  </head>
  <body class="dashboard-5">
    {{-- Navbar --}}
    
    @role('superadministrator')
      @include('core::navbar/super')
    @endrole
    
    @role('administrator')
    @include('core::navbar/admin')
    @endrole

    @role('storemanager')
    @include('core::navbar/admin')
    @endrole

    @role('staff')
    @include('core::navbar/staff')
    @endrole
    {{-- Navbar --}}
    
    @yield('content')

    <div class="slim-footer">
      <div class="container">
        <p>ALC Race {{ date('Y') }} &copy;</p>
      </div><!-- container -->
    </div><!-- slim-footer -->
    
    {{-- <script src="{{ asset('assets/lib/jquery/js/jquery.js') }}"></script> --}}
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ asset('assets/lib/jquery-ui/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/lib/popper.js/js/popper.js') }}"></script>
    {{-- <script src="{{ asset('assets/lib/bootstrap/js/bootstrap.js') }}"></script> --}}
    <script src="{{ asset('assets/lib/jquery.cookie/js/jquery.cookie.js') }}"></script>
    <script src="{{ asset('assets/lib/d3/js/d3.js') }}"></script>
    <script src="{{ asset('assets/lib/rickshaw/js/rickshaw.min.js') }}"></script>
    <script src="{{ asset('assets/lib/chart.js/js/Chart.js') }}"></script>
    <script src="{{ asset('assets/js/slim.js') }}"></script>
    <script src="{{ asset('assets/js/ResizeSensor.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables-responsive/js/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('assets/lib/select2/js/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.8.1/dist/sweetalert2.all.min.js"></script>
    
    @yield('js')
    
    <script>
      $(function(){        
        $('[data-toggle="tooltip"]').tooltip();
        $('select').selectpicker();
        $('.fc-datepicker').datepicker({
          dateFormat: 'dd-mm-yy',
        });
      });
      function confirmDelete(action){
        Swal.fire({
          title: 'Yakin akan di hapus ?',
          text: "Data tersebut tidak bisa di kembalikan setelah dihapus.",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, Hapus!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.value) {
             action()
          }
        })
      }
    </script>
  </body>
</html>
