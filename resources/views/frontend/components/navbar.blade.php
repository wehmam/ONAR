<!-- ======= Header ======= -->
<header id="header" class="header fixed-top" data-scrollto-offset="0">
    <div class="container-fluid d-flex align-items-center justify-content-between">

      <a href="{{ url("/") }}" class="logo d-flex align-items-center scrollto me-auto me-lg-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1>ONAR<span>.</span></h1>
      </a>

      <nav id="navbar" class="navbar">
        <ul>
            <li><a class="nav-link scrollto" href="{{ url("/") }}">Home</a></li>
            <li><a class="nav-link scrollto" href="{{ url("/#services") }}">Events</a></li>
            <li><a class="nav-link scrollto" href="{{ url("/#testimonials") }}">Testimonials</a></li>
            <li><a class="nav-link scrollto" href="{{ url("/#creator") }}">Creator</a></li>
            @if(\Auth::check())
              <li><a href="{{ url('/profile') }}" class="nav-link scrollto {{ Request::segment(1) == "profile" ? "active" : "" }}">Profile</a></li>
              <li><a href="javascript:;" onclick="logout()">Logout </a></li>
            @endif
        </ul>
        <i class="bi bi-list mobile-nav-toggle d-none"></i>
      </nav><!-- .navbar -->

      @if(Auth::check())
        <a class="btn-getstarted scrollto" href="#" disabled>Hi! {{ Auth::user()->name }}</a>
      @else
        <a class="btn-getstarted scrollto" href="{{ Request::segment(1) == "register" ? url("login") : url("register") }}">{{ Request::segment(1) == "register" ? "Login" : "Register" }}</a>
      @endif

    </div>
  </header><!-- End Header -->
