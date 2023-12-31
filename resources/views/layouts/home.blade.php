<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

  <meta charset="utf-8">
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <meta name="description" content="">
  <meta name="author" content="">

  <title>@yield('title', config('app.name'))</title>

  <!-- Custom fonts for this template-->
  <link href="{{ secure_asset('assets/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{ secure_asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
  @stack('styles')

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
    
    <!-- Sidebar -->

    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        
      <!-- Main Content -->
      <div id="content">
        
        <!-- Topbar -->
        <nav></nav>
        <!-- End of Topbar -->
        

        <!-- Begin Page Content -->
        <div class="container-fluid">
          @yield('content')
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; 2022</span>
          </div>
        </div>
      </footer>
       End of Footer

    </div>
    <!-- End of Content Wrapper -->
    
  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->

  <!-- Bootstrap core JavaScript-->
  <script src="{{ secure_asset('assets/js/jquery/jquery.min.js') }}"></script>
  <script src="{{ secure_asset('assets/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ secure_asset('assets/js/jquery.easing.min.js') }}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ secure_asset('assets/js/sb-admin-2.min.js') }}"></script>

  <!-- Scripts personalizados clases -->
@stack('scripts')


</body>

</html>