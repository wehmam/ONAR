<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

<title>@yield("title", "ONAR.")</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <meta name="_token" content="{{ csrf_token() }}">

  <!-- Favicons -->
  <link href="{{ asset("assets/frontend/img/favicon.png") }}" rel="icon">
  <link href="{{ asset("assets/frontend/img/apple-touch-icon.png") }}" rel="apple-touch-icon">
  <link href="{{ asset("assets/backend/vendor/fontawesome-free/css/all.min.css") }}" rel="stylesheet" type="text/css">


  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Source+Sans+Pro:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset("assets/frontend/vendor/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet">
  <link href="{{ asset("assets/frontend/vendor/bootstrap-icons/bootstrap-icons.css") }}" rel="stylesheet">
  <link href="{{ asset("assets/frontend/vendor/aos/aos.css") }}" rel="stylesheet">
  <link href="{{ asset("assets/frontend/vendor/glightbox/css/glightbox.min.css") }}" rel="stylesheet">
  <link href="{{ asset("assets/frontend/vendor/swiper/swiper-bundle.min.css") }}" rel="stylesheet">

  <!-- Variables CSS Files. Uncomment your preferred color scheme -->
  <link href="{{ asset("assets/frontend/css/variables.css") }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset("assets/frontend/css/main.css") }}" rel="stylesheet">
  @yield('external-css')

  
</head>

<body>

    {{-- FOOTER --}}
    @include('frontend.components.navbar')
    {{-- ENDS FOOTER --}}
    

    <main id="main">
        @yield('content')
    </main><!-- End #main -->

    {{-- FOOTER --}}
        @include('frontend.components.footer')
    {{-- ENDS FOOTER --}}

    {{-- Button To TOP --}}
    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    {{-- Button To TOP ends --}}


    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset("assets/frontend/vendor/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
    <script src="{{ asset("assets/frontend/vendor/aos/aos.js") }}"></script>
    <script src="{{ asset("assets/frontend/vendor/glightbox/js/glightbox.min.js") }}"></script>
    <script src="{{ asset("assets/frontend/vendor/isotope-layout/isotope.pkgd.min.js") }}"></script>
    <script src="{{ asset("assets/frontend/vendor/swiper/swiper-bundle.min.js") }}"></script>
    <script src="{{ asset("assets/frontend/vendor/php-email-form/validate.js") }}"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    {{-- Sweetalert --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Template Main JS File -->
    <script src="{{ asset("assets/frontend/js/main.js") }}"></script>
    @yield('external-js')
    <script>
        const sessionStatus  = "{{ Session::has('status') }}"
        const sessionMessage = "{{ Session::get('status') }}"
        const sessionClass   = "{{ Session::get('alert-class') }}"

        if(sessionStatus) {
            Swal.fire(
                sessionClass == "error" ? "Opps!" : "Success!" ,
                sessionMessage,
                sessionClass
            )
            "{{ Session::forget('status') }}"
        }
        function logout() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't Logout!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Logout!'
                }).then((result) => {
                if (result.isConfirmed) {
                    fetch('{{ url("/logout") }}', {
                        headers: {
                            'content-type'      : 'application/json',
                            'Accept'            : 'application/json',
                            'X-Requested-With'  : 'XMLHttpRequest',
                            'X-CSRF-Token'      : '{{ csrf_token() }}'
                        },
                        method: 'POST',
                    })
                    .then(res => {
                        window.location.reload()
                    })
                }
            })
        }
    </script>
</body>

</html>