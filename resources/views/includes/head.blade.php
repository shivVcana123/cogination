<nav class="main-header navbar navbar-expand navbar-light" style="background-color:white">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i style="color:black" class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('dashboard') }}" class="nav-link" style="color:black">Dashboard</a>
      </li>

    </ul>


    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
     

    
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-cog"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Settings</span>
          <div class="dropdown-divider"></div>
          <a href="{{ route('logout') }}" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i>Logout
          </a>
           <div class="dropdown-divider"></div>
          <a href="{{ route('profile') }}" class="dropdown-item">
            <i class="fas fa-user mr-2"></i>Profile
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{ route('changePassword') }}" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i>Change Password
          </a>
        </div>
      </li>
    
    </ul>
</nav>