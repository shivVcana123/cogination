  <!-- Main Sidebar Container -->
   {{-- style="background-color:#0377ce" --}}
  <aside class="main-sidebar elevation-4">
      <!-- Brand Logo -->
      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
              <div class="image">
                  <img src="{{ asset('assets/images/New-logo.png') }}" alt="User Image" style="    width: 188px;">
              </div>
          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                  <li class="nav-item">
                      <a href="{{route('dashboard')}}" class="nav-link {{request()->is('dashboard*') ? 'active' : ''}}">
                          <i class="nav-icon fas fa-tachometer-alt" style="color:black"></i>
                          <p style="color:black">
                              Dashboard
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{route('header.index')}}" class="nav-link {{request()->is('header*') ? 'active' : ''}}">
                          <i class="nav-icon far fa-plus-square" style="color:black"></i>
                          <p style="color:black">
                             Header
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{route('home.index')}}" class="nav-link {{request()->is('home*') ? 'active' : ''}}">
                          <i class="nav-icon fa fa-home" style="color:black"></i>
                          <p style="color:black">
                              Hero Section
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{route('about.index')}}" class="nav-link {{request()->is('about*') ? 'active' : ''}}">
                          <i class="nav-icon far fa-address-card" style="color:black"></i>
                          <p style="color:black">
                              About Us
                          </p>
                      </a>
                  </li>
                    <li class="nav-item">
                      <a href="{{ route('service.index') }}" class="nav-link {{request()->is('service*') ? 'active' : ''}}">
                          <i class="nav-icon fas fa-concierge-bell" style="color:black"></i>
                          <p style="color:black">
                              Assessments
                          </p>
                      </a>
                  </li>
               
                  <li class="nav-item">
                      <a href="{{route('news.index')}}" class="nav-link {{request()->is('news*') ? 'active' : ''}}">
                      <i class="nav-icon fa fa-newspaper" aria-hidden="true" style="color:black"></i>
                          <p style="color:black">
                            Autism
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{route('link.index')}}" class="nav-link {{request()->is('link*') ? 'active' : ''}}">
                          <i class="nav-icon fa fa-link" style="color:black"></i>
                          <p style="color:black">
                             Fees
                          </p>
                      </a>
                  </li>

                    <li class="nav-item">
                      <a href="{{route('footer.index')}}" class="nav-link {{request()->is('footer*') ? 'active' : ''}}">
                          <i class="nav-icon fas fa-info-circle" style="color:black"></i>
                          <p style="color:black">
                              Footer
                          </p>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a href="{{route('page.index')}}" class="nav-link {{request()->is('page*') ? 'active' : ''}}">
                          <i class="nav-icon fa fa-cog" style="color:black"></i>
                          <p style="color:black">
                          Design Styles 
                          </p>
                      </a>
                  </li>
                 
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>

