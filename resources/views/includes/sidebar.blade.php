  <!-- Main Sidebar Container -->
  <aside class="main-sidebar elevation-4" style="background-color:#0476b4">
      <!-- Brand Logo -->
      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
              <div class="image">
                  <img src="{{ asset('assets/images/adminLogo.png') }}" alt="User Image" style="    width: 188px;">
              </div>
          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                  <li class="nav-item">
                      <a href="{{route('dashboard')}}" class="nav-link {{request()->is('dashboard*') ? 'active' : ''}}">
                          <i class="nav-icon fas fa-tachometer-alt" style="color:white"></i>
                          <p style="color:white">
                              Dashboard
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{route('header')}}" class="nav-link {{request()->is('header*') ? 'active' : ''}}">
                          <i class="nav-icon far fa-plus-square" style="color:white"></i>
                          <p style="color:white">
                              Header
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{route('homes.index')}}" class="nav-link {{request()->is('homes*') ? 'active' : ''}}">
                          <i class="nav-icon fa fa-home" style="color:white"></i>
                          <p style="color:white">
                              Home
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{route('abouts.index')}}" class="nav-link {{request()->is('abouts*') ? 'active' : ''}}">
                          <i class="nav-icon far fa-user" style="color:white"></i>
                          <p style="color:white">
                              About Us
                          </p>
                      </a>
                  </li>
                    <li class="nav-item">
                      <a href="{{ route('services.index') }}" class="nav-link {{request()->is('services*') ? 'active' : ''}}">
                          <i class="nav-icon far fa-user" style="color:white"></i>
                          <p style="color:white">
                              Services
                          </p>
                      </a>
                  </li>
               
                  <li class="nav-item">
                      <a href="{{route('news.index')}}" class="nav-link {{request()->is('news*') ? 'active' : ''}}">
                      <i class="nav-icon fa fa-newspaper" aria-hidden="true" style="color:white"></i>
                          <p style="color:white">
                              Latest News
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{route('usefulllinks.index')}}" class="nav-link {{request()->is('usefulllinks*') ? 'active' : ''}}">
                          <i class="nav-icon fa fa-link" style="color:white"></i>
                          <p style="color:white">
                              Useful Links
                          </p>
                      </a>
                  </li>
                 
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>

