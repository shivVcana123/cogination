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
        <strong>&copy; <span id="currentYear"></span>-<span id="nextYear"></span> <a href="https://guardianread.com">https://guardianread.com</a>.</strong>
    </footer>
</div>
<!-- ./wrapper -->
<!-- jQuery -->
@include('includes.footer')
</body>
</html>

<script>
  const currentYear = new Date().getFullYear();
  document.getElementById('currentYear').textContent = currentYear;
  document.getElementById('nextYear').textContent = currentYear + 1;
</script>