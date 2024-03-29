@extends("frontend.layouts")
@section('content')
@include('frontend.components.modal-login')

@section('external-css')
    <style>
        .rounded-circle{
            border:1px solid;
            border-radius:50%;
            width:50px;
            height:50px;
        }

        .custom-tag-lists {
            padding: 6px 12px;
            display: inline-block;
            border-radius: 20px;
            font-size: 1rem;
            color: #ebfcfc;
            background-color: #2cc8d3
        }
    </style>
@endsection

<!-- ======= Services Section ======= -->
<section id="services" class="services">
    <div class="container" data-aos="fade-up">
        <div class="section-header mt-5">
            <div class="row">
                <div class="col">
                  <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                      <li class="breadcrumb-item"><a href="{{ url("events") }}">Events</a></li>
                      <li class="breadcrumb-item active" aria-current="page">{{ $event->event_slug }}</li>
                    </ol>
                  </nav>
                </div>
            </div>
        </div>

        <div class="row gy-5" id="events-data">
            <div class="col-xl-5 col-md-6 mb-5">

                <div class="col-md-12">
                    <div class="img">
                        <img src="{{ Storage::url($event->eventDetail->banner) }}" class="img-fluid" alt="">
                    </div>
                </div>

                <div class="col-md-12 mt-5">
                    <h5 class="text-muted">Diselenggarakan Oleh : </h5>

                    <div class="mt-2">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="{{ Storage::url($event->company->image) }}" class="img-fluid rounded-circle" alt="">
                            </div>
                            <div class="col-md-4 mt-3">
                                <h6>{{ $event->company->name }}</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-5">
                    <h5 class="text-muted">Event Category : </h5>

                    <div class="mt-2">
                        <div class="row">
                            @foreach ($event->eventLabelLists as $key => $label)
                                <div class="col-md-3 mt-2">
                                    <span class="custom-tag-lists text-center">{{ $label->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-md-6 mb-5">
                <div class="row">
                    <div class="col-md-12 offset-md-3 mb-3">
                        <h2>
                            {{ Str::limit($event->eventDetail->title, 25, '...') }}
                            <span class="custom-tag-lists text-center">{{ ucwords($event->event_type) }}</span>
                        </h2>
                    </div>
                    <div class="col-md-12 offset-md-3 mt-3">
                        <h3>Rp . {{ number_format($event->eventDetail->price) }}</h1>
                    </div>

                    <div class="col-md-12 offset-md-3 mt-5">
                        <p><em>{{ $event->eventDetail->description }}</em></p>
                    </div>
                </div>
                <form action="{{ url("events/register") }}" method="POST">
                    @csrf
                    <input type="hidden" name="event_slug" value="{{ $event->event_slug }}">
                    <div class="row mt-5">
                        <div class="col-md-6 offset-md-6">
                            <button class="btn btn-md btn-primary" style="background-color:#0ea2bd; color:white">Daftar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row gy-5 mt-5" id="events-data">
            <div class="row">
                <div class="col-md-6 mt-5">
                    <h3>Recomendations events : </h3>
                </div>
                <div class="col-md-6 mt-5 d-flex flex-row-reverse">
                    <a href="#" class="badge badge-primary m-2" style="background-color:#0ea2bd; color:white">See More</a>
                </div>
            </div>
            @foreach($recomendations as $event)
                <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                    <div class="service-item">
                    <div class="img">
                        <img src="{{ Storage::url($event->eventDetail->banner) }}" class="img-fluid" style=" width:  100%;height: 350px;object-fit: cover;" alt="">
                    </div>
                    <div class="details position-relative">
                        <div class="icon">
                        <i class="bi bi-activity"></i>
                        </div>
                        <a href="{{ url('events/' . $event->event_slug) }}" target="_blank" class="stretched-link">
                        <h3>{{ $event->eventDetail->title }}</h3>
                        <h4>{{ $event->eventDetail->price > 0 ?  "Rp . " . number_format($event->eventDetail->price) : "Free" }}</h5>
                        </a>
                        <p>{{ $event->eventDetail->limit_description }}</p>
                    </div>
                    </div>
                </div>
            @endforeach
        </div>


    </div>
</section><!-- End Services Section -->

@endsection
@section('external-js')
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
@endsection
