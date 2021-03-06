@extends("frontend.layouts")
@section('content')
@include('frontend.components.modal-login')

<!-- ======= Services Section ======= -->
<section id="services" class="services">
    <div class="container" data-aos="fade-up">

        <div class="section-header mt-5">
        <h2></h2>
        </div>

        <div class="row gy-5" id="events-data">
            <div class="col-xl-5 col-md-6">
                    <div class="img">
                        <img src="{{ url(Storage::url($event->image)) }}" class="img-fluid" alt="">
                    </div>
                </div>
                <div class="col-xl-5 col-md-6">
                    <div class="row">
                        <div class="col-md-12 offset-md-3 mb-3">
                            <h2>{{ Str::limit($event->title, 25, '...') }}</h2>
                        </div>
                        <div class="col-md-12 offset-md-3 mt-3">
                            <h3>Rp . {{ number_format($event->price) }}</h1>
                        </div>

                        <div class="col-md-12 offset-md-3 mt-5">
                            <p><em>{{ $event->description }}</em></p>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-6 offset-md-6">
                            <button class="btn btn-md btn-primary" style="background-color:#0ea2bd; color:white">Daftar</button>
                        </div>
                    </div>
            </div>
        </div>


    </div>
</section><!-- End Services Section -->

@endsection
@section('external-js')
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
@endsection
