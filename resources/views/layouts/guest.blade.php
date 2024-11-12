<!DOCTYPE html>
<html lang="en">
<!-- header -->
@include('includes.header')
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- head -->
    @include('includes.head')

    <!-- Content Section -->
    @yield('content')

    
    <!-- Control Sidebar -->
    
        <!-- Control sidebar content goes here -->
        @include('includes.sidebar')
   
    <!-- /.control-sidebar -->

    <!-- Footer -->
    <footer class="main-footer">
        <strong>&copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.1.0
        </div>
    </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
@include('includes.footer')
</body>
</html>
