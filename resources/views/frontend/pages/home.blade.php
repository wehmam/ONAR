@extends("frontend.layouts")
@section('content')
@include('frontend.components.modal-login')

    <section id="hero-animated" class="hero-animated d-flex align-items-center">
        <div class="container d-flex flex-column justify-content-center align-items-center text-center position-relative" data-aos="zoom-out">
            <img src="{{ asset("assets/frontend/img/hero-carousel/hero-carousel-3.svg") }}" class="img-fluid animated">
            <h2>Welcome to <span>ONAR</span></h2>
            <p>We Care About Everything You Need to Know.</p>
            @if(!Auth::check())
                <div class="d-flex">
                    <a href="{{ url('/login') }}" class="btn-get-started scrollto">Login</a>
                </div>
            @endif
        </div>
    </section>

    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
        <div class="container" data-aos="fade-up">

          <div class="section-header">
            <h2>Events</h2>
          </div>

          <div class="row gy-5">

            @forelse ($events as $event)
                <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                    <div class="service-item">
                    <div class="img">
                        <img src="{{ url(Storage::url($event->eventDetail->banner)) }}" class="img-fluid" style=" width:  100%;height: 350px;object-fit: cover;" alt="">
                    </div>
                    <div class="details position-relative">
                        <div class="icon">
                        <i class="bi bi-activity"></i>
                        </div>
                        <a href="{{ url('/events/' . $event->event_slug) }}" target="_blank" class="stretched-link">
                        <h3>{{ $event->eventDetail->title }}</h3>
                        </a>
                        <p>{{ Str::limit($event->eventDetail->description), 20 , '...' }}</p>
                    </div>
                    </div>
                </div><!-- End Service Item -->
            @empty

            @endforelse
            {{-- @for($i = 0; $i < 6; $i++)
                <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                    <div class="service-item">
                    <div class="img">
                        <img src="{{ asset("assets/frontend/img/services-1.jpg") }}" class="img-fluid" alt="">
                    </div>
                    <div class="details position-relative">
                        <div class="icon">
                        <i class="bi bi-activity"></i>
                        </div>
                        <a href="#" class="stretched-link">
                        <h3>Nesciunt Mete</h3>
                        </a>
                        <p>Provident nihil minus qui consequatur non omnis maiores. Eos accusantium minus dolores iure perferendis.</p>
                    </div>
                    </div>
                </div><!-- End Service Item -->
            @endfor --}}

          </div>

          <div class="text-center mt-5">
            <a href="{{ url('/events') }}" class="btn btn-md" style="background-color:#0ea2bd; color:white">See More</a>
          </div>

        </div>
    </section><!-- End Services Section -->

      <!-- ======= Testimonials Section ======= -->
      <section id="testimonials" class="testimonials">
        <div class="container" data-aos="fade-up">

          <div class="testimonials-slider swiper">
            <div class="swiper-wrapper">

              <div class="swiper-slide">
                <div class="testimonial-item">
                  {{-- <img src="{{ asset("assets/frontend/img/testimonials/testimonials-1.jpg") }}" class="testimonial-img" alt=""> --}}
                  <h3>Andre</h3>
                  <h4>Mahasiswa</h4>
                  <div class="stars">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                  </div>
                  <p>
                    <i class="bi bi-quote quote-icon-left"></i>
                      Proses Registrasi Makin gampang dan gak ribet , bayar pun bisa online
                    <i class="bi bi-quote quote-icon-right"></i>
                  </p>
                </div>
              </div><!-- End testimonial item -->

              <div class="swiper-slide">
                <div class="testimonial-item">
                  {{-- <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt=""> --}}
                  <h3>Dita</h3>
                  <h4>Karyawan Swasta</h4>
                  <div class="stars">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                  </div>
                  <p>
                    <i class="bi bi-quote quote-icon-left"></i>
                      proses daftar gampang , uinya keren dan pembayaran auto update
                    <i class="bi bi-quote quote-icon-right"></i>
                  </p>
                </div>
              </div><!-- End testimonial item -->

              <div class="swiper-slide">
                <div class="testimonial-item">
                  {{-- <img src="assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt=""> --}}
                  <h3>George</h3>
                  <h4>Store Owner</h4>
                  <div class="stars">
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                  </div>
                  <p>
                    <i class="bi bi-quote quote-icon-left"></i>
                      Jadi Nambah Wawasan buat seminarnya keren banget di era pandemi gak perlu khawatir karna mudah banget daftarnya
                    <i class="bi bi-quote quote-icon-right"></i>
                  </p>
                </div>
              </div><!-- End testimonial item -->

            </div>
            <div class="swiper-pagination"></div>
          </div>

        </div>
      </section><!-- End Testimonials Section -->

      <!-- ======= Team Section ======= -->
      <section id="team" class="team">
        <div class="container" data-aos="fade-up">

          <div class="section-header">
            <h2>Our Team</h2>
            <p>Architecto nobis eos vel nam quidem vitae temporibus voluptates qui hic deserunt iusto omnis nam voluptas asperiores sequi tenetur dolores incidunt enim voluptatem magnam cumque fuga.</p>
          </div>

          <div class="row gy-5">

            <div class="col-xl-4 col-md-6 d-flex" data-aos="zoom-in" data-aos-delay="200">
              <div class="team-member">
                <div class="member-img">
                  <img src="{{ asset("assets/frontend/img/team/team-1.jpg") }}" class="img-fluid" alt="">
                </div>
                <div class="member-info">
                  <div class="social">
                    <a href=""><i class="bi bi-twitter"></i></a>
                    <a href=""><i class="bi bi-facebook"></i></a>
                    <a href=""><i class="bi bi-instagram"></i></a>
                    <a href=""><i class="bi bi-linkedin"></i></a>
                  </div>
                  <h4>Imam Maulana Ashari</h4>
                  <span>Developer</span>
                </div>
              </div>
            </div><!-- End Team Member -->

            <div class="col-xl-4 col-md-6 d-flex" data-aos="zoom-in" data-aos-delay="400">
              <div class="team-member">
                <div class="member-img">
                  <img src="{{ asset("assets/frontend/img/team/team-2.jpg") }}" class="img-fluid" alt="">
                </div>
                <div class="member-info">
                  <div class="social">
                    <a href=""><i class="bi bi-twitter"></i></a>
                    <a href=""><i class="bi bi-facebook"></i></a>
                    <a href=""><i class="bi bi-instagram"></i></a>
                    <a href=""><i class="bi bi-linkedin"></i></a>
                  </div>
                  <h4>Ahmad Maulana</h4>
                  <span>Product Manager</span>
                </div>
              </div>
            </div><!-- End Team Member -->

            <div class="col-xl-4 col-md-6 d-flex" data-aos="zoom-in" data-aos-delay="600">
              <div class="team-member">
                <div class="member-img">
                  <img src="{{ asset("assets/frontend/img/team/team-3.jpg") }}" class="img-fluid" alt="">
                </div>
                <div class="member-info">
                  <div class="social">
                    <a href=""><i class="bi bi-twitter"></i></a>
                    <a href=""><i class="bi bi-facebook"></i></a>
                    <a href=""><i class="bi bi-instagram"></i></a>
                    <a href=""><i class="bi bi-linkedin"></i></a>
                  </div>
                  <h4>Gilang Ramadhan</h4>
                  <span>System Analyst</span>
                </div>
              </div>
            </div><!-- End Team Member -->

          </div>

        </div>
      </section><!-- End Team Section -->


      {{-- <!-- ======= Contact Section ======= -->
      <section id="contact" class="contact">
        <div class="container">

          <div class="section-header">
            <h2>Contact Us</h2>
            <p>Ea vitae aspernatur deserunt voluptatem impedit deserunt magnam occaecati dssumenda quas ut ad dolores adipisci aliquam.</p>
          </div>

        </div>

        <div class="map">
          <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" allowfullscreen></iframe>
        </div><!-- End Google Maps -->

        <div class="container">

          <div class="row gy-5 gx-lg-5">

            <div class="col-lg-4">

              <div class="info">
                <h3>Get in touch</h3>
                <p>Et id eius voluptates atque nihil voluptatem enim in tempore minima sit ad mollitia commodi minus.</p>

                <div class="info-item d-flex">
                  <i class="bi bi-geo-alt flex-shrink-0"></i>
                  <div>
                    <h4>Location:</h4>
                    <p>A108 Adam Street, New York, NY 535022</p>
                  </div>
                </div><!-- End Info Item -->

                <div class="info-item d-flex">
                  <i class="bi bi-envelope flex-shrink-0"></i>
                  <div>
                    <h4>Email:</h4>
                    <p>info@example.com</p>
                  </div>
                </div><!-- End Info Item -->

                <div class="info-item d-flex">
                  <i class="bi bi-phone flex-shrink-0"></i>
                  <div>
                    <h4>Call:</h4>
                    <p>+1 5589 55488 55</p>
                  </div>
                </div><!-- End Info Item -->

              </div>

            </div>

            <div class="col-lg-8">
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
            </div><!-- End Contact Form -->

          </div>

        </div>
      </section><!-- End Contact Section --> --}}
@endsection
