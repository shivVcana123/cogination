<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Brand Logo -->
        <div class="image">
            <img src="{{ asset('assets/images/New-logo.png') }}" alt="User Image" style="width: 188px;">
        </div>

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
                      <a href="{{route('banner.index')}}" class="nav-link {{request()->is('header*') ? 'active' : ''}}">
                          <i class="nav-icon far fa-plus-square" style="color:black"></i>
                          <p style="color:black">
                              All pages Banner
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
                  <li class="nav-item {{ request()->is('whychooseus*') || request()->is('bringinghealthcare*') || request()->is('faqs*') || request()->is('appointment*') || request()->is('our-services*') ? 'menu-open' : '' }}">
                        <a href=" #" class="nav-link">
                            <i class="nav-icon fa fa-home" style="color:black"></i>
                            <p style="color:black">
                                Home Section
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{route('appointment')}}"
                                  class="nav-link {{ request()->is('appointment*') ? 'active' : '' }}">
                                  <i class="far fa-circle nav-icon" style="color:black"></i>
                                  <p style="color:black">Appointment</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('whychooseus')}}"
                                  class="nav-link {{ request()->is('whychooseus*') ? 'active' : '' }}">
                                  <i class="far fa-circle nav-icon" style="color:black"></i>
                                  <p style="color:black">Why Choose Us</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('our-services')}}"
                                  class="nav-link {{ request()->is('our-services*') ? 'active' : '' }}">
                                  <i class="far fa-circle nav-icon" style="color:black"></i>
                                  <p style="color:black">Our Services</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('bringinghealthcare')}}"
                                  class="nav-link {{ request()->is('bringinghealthcare*') ? 'active' : '' }}">
                                  <i class="far fa-circle nav-icon" style="color:black"></i>
                                  <p style="color:black">Bringing healthcare</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('faqs')}}"
                                  class="nav-link {{ request()->is('faqs*') ? 'active' : '' }}">
                                  <i class="far fa-circle nav-icon" style="color:black"></i>
                                  <p style="color:black">FAQs</p>
                              </a>
                          </li>
                      </ul>
                  </li>

                <!-- Header -->
                <li class="nav-item">
                    <a href="{{route('header.index')}}" class="nav-link {{request()->is('header*') ? 'active' : ''}}">
                        <i class="nav-icon far fa-plus-square" style="color:black"></i>
                        <p style="color:black">Header</p>
                    </a>
                </li>

                <!-- Home Section -->
                <li class="nav-item {{ request()->is('home*') || request()->is('whychooseus*') || request()->is('bringinghealthcare*') || request()->is('faqs*') || request()->is('appointment*') || request()->is('our-services*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-home" style="color:black"></i>
                        <p style="color:black">
                            Home Section
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('home.index')}}" class="nav-link {{request()->is('home*') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Hero Section</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('appointment')}}" class="nav-link {{ request()->is('appointment*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Appointment</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('whychooseus')}}" class="nav-link {{ request()->is('whychooseus*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Why Choose Us</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('our-services')}}" class="nav-link {{ request()->is('our-services*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Our Services</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('bringinghealthcare')}}" class="nav-link {{ request()->is('bringinghealthcare*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Bringing Healthcare</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('faqs')}}" class="nav-link {{ request()->is('faqs*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">FAQs</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- ADHD Section -->
                <li class="nav-item {{ request()->is('adhd-benefits*') || request()->is('adhd-section*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-home" style="color:black"></i>
                        <p style="color:black">
                            ADHD Section
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('adhd-section')}}" class="nav-link {{ request()->is('adhd-section*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">ADHD Section</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('adhd-benefits')}}" class="nav-link {{ request()->is('adhd-benefits*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">ADHD Benefits</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Autism  Section -->
                <li class="nav-item {{ request()->is('adhd-benefits*') || request()->is('adhd-section*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-home" style="color:black"></i>
                        <p style="color:black">
                            Autism  Section
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('autism-section')}}" class="nav-link {{ request()->is('autism-section*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Autism Section</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('adhd-benefits')}}" class="nav-link {{ request()->is('adhd-benefits*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">ADHD Benefits</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- About Us -->
                <li class="nav-item">
                    <a href="{{route('about.index')}}" class="nav-link {{request()->is('about*') ? 'active' : ''}}">
                        <i class="nav-icon far fa-address-card" style="color:black"></i>
                        <p style="color:black">About Us</p>
                    </a>
                </li>

                <!-- Assessments -->
                <li class="nav-item">
                    <a href="{{ route('service.index') }}" class="nav-link {{request()->is('service*') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-concierge-bell" style="color:black"></i>
                        <p style="color:black">Assessments</p>
                    </a>
                </li>

                <!-- Latest News -->
                <li class="nav-item">
                    <a href="{{route('news.index')}}" class="nav-link {{request()->is('news*') ? 'active' : ''}}">
                        <i class="nav-icon fa fa-newspaper" style="color:black"></i>
                        <p style="color:black">Latest News</p>
                    </a>
                </li>

                <!-- Fees -->
                <li class="nav-item">
                    <a href="{{route('link.index')}}" class="nav-link {{request()->is('link*') ? 'active' : ''}}">
                        <i class="nav-icon fa fa-link" style="color:black"></i>
                        <p style="color:black">Fees</p>
                    </a>
                </li>

                <!-- Footer -->
                <li class="nav-item">
                    <a href="{{route('footer.index')}}" class="nav-link {{request()->is('footer*') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-info-circle" style="color:black"></i>
                        <p style="color:black">Footer</p>
                    </a>
                </li>

                <!-- Design Styles -->
                <li class="nav-item">
                    <a href="{{route('page.index')}}" class="nav-link {{request()->is('page*') ? 'active' : ''}}">
                        <i class="nav-icon fa fa-cog" style="color:black"></i>
                        <p style="color:black">Design Styles</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>