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
    <strong>&copy; <span id="currentYear"></span> Cognition Care, All Rights Reserved. Designed by – Vcana Global, Inc. 
    <a href="https://cognition-demo.vercel.app">https://cognition-demo.vercel.app</a></strong>
</footer>

<script>
    document.getElementById("currentYear").textContent = new Date().getFullYear();
</script>

</div>
<!-- ./wrapper -->
<!-- jQuery -->
@include('includes.footer')
@yield('java_script')
</body>
</html>
