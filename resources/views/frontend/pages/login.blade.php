@extends("frontend.layouts")
@section('content')
@include('frontend.components.modal-login')

    <section class="vh-100 mt-5">
        <div class="container-fluid h-custom mt-5">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
              <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
                class="img-fluid" alt="Sample image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
              <form action="{{ url('/login') }}" method="POST">
                @csrf
                {{-- <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                  <p class="lead fw-normal mb-0 me-3">Sign in with</p>
                  <button type="button" class="btn btn-floating mx-1" style="background-color:#0ea2bd; color:white">
                    <i class="fab fa-google"></i>
                  </button>
                </div> --}}

                <!-- Email input -->
                <div class="form-outline mb-4 mt-5">
                  <input type="email" id="email" name="email" class="form-control form-control-lg"
                    placeholder="Enter a valid email address" />
                <label class="form-label" for="email">Email address @error('email') <span class="text-danger">* {{ $message }}</span> @enderror</label>
                </div>

                <!-- Password input -->
                <div class="form-outline mb-3">
                  <input type="password" id="password" name="password" class="form-control form-control-lg"
                    placeholder="Enter password" />
                  <label class="form-label" for="password">Password @error('password') <span class="text-danger">* {{ $message }}</span> @enderror</label>
                </div>

                {{-- <div class="d-flex justify-content-between align-items-center">
                  <!-- Checkbox -->
                  <div class="form-check mb-0">
                    <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                    <label class="form-check-label" for="form2Example3">
                      Remember me
                    </label>
                  </div>
                  <a href="#!" class="text-body">Forgot password?</a>
                </div> --}}


                <div class="text-center text-lg-start mt-4 pt-2">
                  <button type="submit" class="btn btn-lg"
                    style="padding-left: 2.5rem; padding-right: 2.5rem;background-color:#0ea2bd; color:white">Login</button>
                  <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="{{ url('/register') }}"
                      class="link-danger">Register</a></p>
                </div>

              </form>
            </div>
          </div>
        </div>
      </section>
@endsection
