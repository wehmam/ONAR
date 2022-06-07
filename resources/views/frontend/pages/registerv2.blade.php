@extends("frontend.layouts")
@section('content')
    <!-- ======= Services Section ======= -->
    <section id="services mt-5" class="services">
        <div class="container">

            <div class="row d-flex justify-content-center align-items-center">
              <div class="col-lg-12 col-xl-11">
                {{-- <div class="card text-black" style="border-radius: 25px;"> --}}
                  <div class="card-body p-md-5">
                    <div class="row justify-content-center">
                      <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                        
                        <div class="section-header mt-5">
                            <h2>Register</h2>
                        </div>
            
                        {{-- <p class="text-center h1 mb-5 mx-1 mx-md-4 mt-4">Register</p> --}}
          
                        <form class="mx-1 mx-md-4" action="{{ url("register") }}" method="POST">
                            @csrf
                            
                            <div class="d-flex flex-row align-items-center mb-4">
                                <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                <input type="text" id="name" name="name" class="form-control" />
                                <label class="form-label" for="name">Your Name @error('name')<span class="text-danger">* {{ $message }}</span>@enderror</label>
                                </div>
                            </div>
          
                            <div class="d-flex flex-row align-items-center mb-4">
                                <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                <input type="email" name="email" id="email" class="form-control" />
                                <label class="form-label" for="email">Your Email @error('email')<span class="text-danger">* {{ $message }}</span>@enderror</label>
                                </div>
                            </div>
          
                            <div class="d-flex flex-row align-items-center mb-4">
                                <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                <input type="password" id="password" name="password" class="form-control" />
                                <label class="form-label" for="password">Password @error('password')<span class="text-danger">* {{ $message }}</span>@enderror</label>
                                </div>
                            </div>
          
                            <div class="d-flex flex-row align-items-center mb-4">
                                <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" />
                                <label class="form-label" for="password_confirmation">Repeat your password @error('password_confirmation')<span class="text-danger">* {{ $message }}</span>@enderror</label>
                                </div>
                            </div>
                        
                            <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                <button type="submit" class="btn btn-primary btn-lg">Register</button>
                            </div>
          
                        </form>
          
                      </div>
                      <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
          
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
                          class="img-fluid" alt="Sample image">
          
                      </div>
                    </div>
                  </div>
                {{-- </div> --}}
              </div>
            </div>
          </div>
        {{-- <div class="container" data-aos="fade-up">
  
          <div class="section-header mt-5">
            <h2>Register</h2>
          </div>
          
          <div class="row gy-5">
            <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                <div class="row">
                  <div class="col-md-6 form-group">
                    <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                  </div>
                  <div class="col-md-6 form-group mt-3 mt-md-0">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                  </div>
                </div>
                <div class="form-group mt-3">
                  <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
                </div>
                <div class="form-group mt-3">
                  <textarea class="form-control" name="message" placeholder="Message" required></textarea>
                </div>
                <div class="my-3">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent. Thank you!</div>
                </div>
                <div class="text-center"><button type="submit">Send Message</button></div>
              </form>
           
            
          </div>  

          <div class="text-center mt-5">
            <a href="{{ url('/events') }}" class="btn btn-md" style="background-color:#0ea2bd; color:white">See More</a>
          </div>

        </div> --}}
    </section><!-- End Services Section -->
  
@endsection