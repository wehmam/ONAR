@extends("frontend.layouts")
@section('content')
@include('frontend.components.modal-login')

<!-- ======= Services Section ======= -->
<section id="services" class="services">
    <div class="container" data-aos="fade-up">

        <div class="section-header mt-5">
            <h2>Events</h2>
        </div>

        <div class="row gy-5">
            <form action="{{ url("/events") }}" method="GET">
                <div class="input-group mb-5">
                    <input type="text" class="form-control text-center" name="q" placeholder="Cari Seminar (Kota, Seminar Offline / Online, Judul, Kategori)">
                    <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" style="background-color:#0ea2bd; color:white"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            {{-- <div class="col-md-12">
                <div class="form-outline mb-4">
                    <input type="search" class="form-control text-center" id="datatable-search-input" >
                </div>
            </div> --}}
        </div>

        <div class="row gy-5" id="events-data">
            @foreach($events as $event)
                <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                    <div class="service-item">
                    <div class="img">
                        <img src="{{ Storage::url($event->eventDetail->banner) }}" class="img-fluid" style=" width:  100%;height: 350px;object-fit: cover;" alt="">
                    </div>
                    <div class="details position-relative">
                        <div class="icon">
                        <i class="bi bi-activity"></i>
                        </div>
                        <a href="{{ url('events/' . $event->id) }}" target="_blank" class="stretched-link">
                        <h3>{{ $event->eventDetail->title }}</h3>
                        <h4>{{ $event->eventDetail->price > 0 ?  "Rp . " . number_format($event->eventDetail->price) : "Free" }}</h5>
                        </a>
                        <p>{{ $event->eventDetail->limit_description }}</p>
                    </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-5">
            <a href="javascript:;" class="btn btn-md" onclick="seeMore()" id="btn-seemore" style="background-color:#0ea2bd; color:white">See More</a>
        </div>

    </div>
</section><!-- End Services Section -->

@endsection
@section('external-js')
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="{{ asset("assets/frontend/js/events.js?v=1.1") }}"></script>
@endsection
