<!-- Main Sidebar Container -->
<?php

use App\Models\Logo;

$logo = Logo::first();
?>
<style>
    .logos img {
        width: 90%;
    }

    .logos {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .bg-clss {
        background-color: #fff;
    }

    .sidenab .fa-circle:before {
        font-size: 11px;
        margin-right: 0;
    }

    .sidenab .nav-icon {
        margin-right: 0 !important;
    }
</style>
<aside class="main-sidebar elevation-4 bg-clss">
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Brand Logo -->
        <div class="image logos">
            @if (!empty($logo->logo))
            <img src="{{ asset($logo->logo) }}" alt="User Image">
            @else
            <img src="{{ asset('assets/images/New-logo.png') }}" alt="User Image">
            @endif
        </div>
        <!-- <img src="{{ asset('assets/images/smallLogo.png') }}" alt="User Image" style="width: 188px;"> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2 sidenab">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{route('dashboard')}}" class="nav-link {{request()->is('/*') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-tachometer-alt" style="color:black"></i>
                        <p style="color:black">Dashboard</p>
                    </a>
                </li>

                <!-- Header -->
                <li class="nav-item">
                    <a href="{{route('header.index')}}" class="nav-link {{request()->is('header*') ? 'active' : ''}}">
                        <i class="nav-icon far fa-plus-square" style="color:black"></i>
                        <p style="color:black">Header</p>
                    </a>
                </li>

                <!-- Banner -->
                <li class="nav-item">
                    <a href="{{ route('banner.index') }}" class="nav-link {{ request()->is('banner*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-image" style="color:black"></i> <!-- Banner icon -->
                        <p style="color:black">Banner</p>
                    </a>
                </li>

                <!-- Home Section -->
                <li class="nav-item {{ request()->is('home*') || request()->is('whychooseus*') || request()->is('bringinghealthcare*') || request()->is('faqs*') || request()->is('appointment*') || request()->is('about-us*') || request()->is('our-services*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-home" style="color:black"></i>
                        <p style="color:black">
                            Home Page
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!-- <li class="nav-item">
                            <a href="{{route('home.index')}}" class="nav-link {{request()->is('home*') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Hero Section</p>
                            </a>
                        </li> -->
                        <li class="nav-item">
                            <a href="{{route('homeAbout')}}" class="nav-link {{ request()->is('about-us*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">About Us</p>
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
                <li class="nav-item {{ request()->is('adhd-benefits*') || request()->is('adhd-section*') || request()->is('adhd-second-section*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-brain" style="color:black"></i>
                        <p style="color:black">
                            ADHD Page
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('adhd-section')}}" class="nav-link {{ request()->is('adhd-section*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">ADHD 1st Section</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('adhd-second-section')}}" class="nav-link {{ request()->is('adhd-second-section*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">ADHD 2nd Section</p>
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
                <li class="nav-item {{ request()->is('autism-process*') || request()->is('autism-screening*') || request()->is('autism-book*') || request()->is('autism-index*') || request()->is('autism-section*') || request()->is('autism-second-section*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-puzzle-piece" style="color:black"></i>
                        <p style="color:black">
                            Autism Page
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('autism-section')}}" class="nav-link {{ request()->is('autism-section*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Autism 1st Section</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('autism-second-section')}}" class="nav-link {{ request()->is('autism-second-section*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Autism 2nd Section</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('autism-process-section')}}" class="nav-link {{ request()->is('autism-process*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Autism Process</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('autism-screening-section')}}" class="nav-link {{ request()->is('autism-screening*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Autism Screening</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('autism-book-section')}}" class="nav-link {{ request()->is('autism-book*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Autism Book</p>
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a href="{{route('autism-index')}}" class="nav-link {{ request()->is('autism-index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Autism</p>
                            </a>
                        </li> -->
                        <!-- <li class="nav-item">
                            <a href="{{route('autism-index')}}" class="nav-link {{ request()->is('autism-index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Autism</p>
                            </a>
                        </li> -->
                    </ul>
                </li>

                <!-- About Us -->
                <li class="nav-item {{ request()->is('our-story-section*') || request()->is('our-mission-section*') || request()->is('join-community-section*') || request()->is('understanding-conditions*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-info-circle" style="color:black"></i>
                        <p style="color:black">
                            About Us Page
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('our-story-section') }}" class="nav-link {{ request()->is('our-story-section*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Our Story</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('our-mission-section') }}" class="nav-link {{ request()->is('our-mission-section*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Our Mission</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('join-community-section') }}" class="nav-link {{ request()->is('join-community-section*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Join Community</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Our Approach -->
                <li class="nav-item {{ request()->is('our-approach*') || request()->is('how-it-works*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-hand-holding-heart" style="color:black"></i>
                        <p style="color:black">
                            Our Approach Page
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('our-approach-section') }}" class="nav-link {{ request()->is('our-approach*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Our Approach</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('how-it-works-section') }}" class="nav-link {{ request()->is('how-it-works*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">How It Works</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Accreditation -->
                <li class="nav-item {{ request()->is('our-commitment*') || request()->is('certifications-section*') || request()->is('accreditations-section*') || request()->is('specialized-certifications-section*') || request()->is('our-team-continuous-section*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-certificate" style="color:black"></i>
                        <p style="color:black">
                            Accreditation Page
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('our-commitment-section') }}" class="nav-link {{ request()->is('our-commitment*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Our Commitment</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('certifications-section') }}" class="nav-link {{ request()->is('certifications-section*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Certifications</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('accreditations-section') }}" class="nav-link {{ request()->is('accreditations-section*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Accreditations</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('specialized-certifications-section') }}" class="nav-link {{ request()->is('specialized-certifications-section*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Specialized Certifications
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('our-team-continuous-section') }}" class="nav-link {{ request()->is('our-team-continuous-section*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Our Team Continuous
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Assessments -->
                <li class="nav-item {{ request()->is('assessment-section*') || request()->is('assessment-whychoose*') || request()->is('our-diagnostic-services*') || request()->is('understanding-conditions*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-clipboard-list" style="color:black"></i>
                        <p style="color:black">
                            Assessments Page
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('assessment-section') }}" class="nav-link {{ request()->is('assessment-section*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Comprehensive Diagnosis</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('assessment-our-diagnostic-services-section') }}" class="nav-link {{ request()->is('our-diagnostic-services*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Our Diagnostic Services</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('assessment-whychoose-section') }}" class="nav-link {{ request()->is('assessment-whychoose*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Why Choose Cognitive Care</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('understanding-conditions-section') }}" class="nav-link {{ request()->is('understanding-conditions*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Understanding the Conditions</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Fees -->
                <li class="nav-item {{ request()->is('our-pricing-section*') || request()->is('financial-responsibilities*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-dollar-sign" style="color:black"></i>
                        <p style="color:black">
                            Fees Page
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('our-pricing-section') }}" class="nav-link {{ request()->is('our-pricing-section*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Our Pricing</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('financialResponsibilities') }}" class="nav-link {{ request()->is('financial-responsibilities*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Responsibility</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Subscribe To Our Newsletter -->
                <li class="nav-item {{ request()->is('news-letter-form*') || request()->is('news-letter-list*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-envelope" style="color:black"></i>
                        <p style="color:black">
                        Newsletter Section
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                        <a href="{{ route('news-letter-form') }}" class="nav-link {{ request()->is('news-letter-form*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon" style="color:black"></i>
                        <p style="color:black">Form</p>
                        </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('news-letter-list') }}" class="nav-link {{ request()->is('news-letter-list*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon" style="color:black"></i>
                                <p style="color:black">Index</p>
                            </a>
                        </li>
                    </ul>
                </li>
            
                <!-- CTA -->
                <li class="nav-item">
                    <a href="{{ route('cta.index') }}" class="nav-link {{ request()->is('cta*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bullhorn" style="color:black"></i> <!-- CTA icon -->
                        <p style="color:black">CTA</p>
                    </a>
                </li>




                <!-- Footer -->
                <li class="nav-item">
                    <a href="{{ route('footer') }}" class="nav-link {{ request()->is('footer*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs" style="color:black"></i> <!-- Footer icon -->
                        <p style="color:black">Footer</p>
                    </a>
                </li>

                <!-- Design Styles -->
                <!-- <li class="nav-item">
                    <a href="{{ route('page.index') }}" class="nav-link {{ request()->is('page*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-paint-brush" style="color:black"></i> 
                        <p style="color:black">Design Styles</p>
                    </a>
                </li> -->


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>