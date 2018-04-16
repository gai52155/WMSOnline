<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>WMSOnline System</title>
  <!-- Bootstrap Core CSS -->
  @include('admin.layouts.inc-stylesheet') @yield('stylesheet')
  @include('admin.layouts.inc-scripts') @yield('scripts')
</body>
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <div id="wrapper">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
      @include('admin.layouts.inc-header')
    </nav>
    <!-- Page Content -->
    <div class="content-wrapper">
      <div class="container-fluid">
        @yield('content')
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
  </div>
  <!-- /#wrapper -->
  <!-- jQuery -->
  <footer class="sticky-footer">
    <div class="container">
    </div>
  </footer>
  @include('admin.layouts.logoutModal')
</body>

</html>
