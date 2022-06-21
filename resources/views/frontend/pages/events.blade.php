@extends("frontend.layouts")
@section('content')
@include('frontend.components.modal-login')

<!-- ======= Services Section ======= -->
<section id="services" class="services">
    <div class="container" data-aos="fade-up">

        <div class="section-header mt-5">
        <h2>Events</h2>
        </div>

        <div class="row gy-5" id="events-data">
            @foreach($events as $event)
                <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                    <div class="service-item">
                    <div class="img">
                        <img src="{{ url(Storage::url($event->image)) }}" class="img-fluid" style=" width:  100%;height: 350px;object-fit: cover;" alt="">
                    </div>
                    <div class="details position-relative">
                        <div class="icon">
                        <i class="bi bi-activity"></i>
                        </div>
                        <a href="{{ url('events/' . $event->id) }}" target="_blank" class="stretched-link">
                        <h3>{{ $event->title }}</h3>
                        <h4>{{ $event->price > 0 ?  "Rp . " . number_format($event->price) : "Free" }}</h5>
                        </a>
                        <p>{{ Str::limit($event->description), 20 , '...' }}</p>
                    </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
        <a href="javascript:;" class="btn btn-md" onclick="seeMore()" style="background-color:#0ea2bd; color:white">See More</a>
        </div>

    </div>
</section><!-- End Services Section -->

@endsection
@section('external-js')
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="{{ asset("assets/frontend/js/events.js?v=1.1") }}"></script>
@endsection
