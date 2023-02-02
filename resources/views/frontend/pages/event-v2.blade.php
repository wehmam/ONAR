@extends("frontend.layouts")
@section('external-css')
<style>
    #sidebar .checklist {
        padding: 0;
    }

    .checklist ul li {
        font-size: 14px;
        font-weight: 400;
        list-style: none;
        padding: 7px 0 7px 23px;
    }

    .checklist li span {
        float: left;
        width: 11px;
        height: 11px;
        margin-left: -23px;
        margin-top: 4px;
        border: 1px solid #d1d3d7;
        position: relative;
    }

    .sizes li span,
    .categories .sizes li {
        -webkit-transition: all 300ms ease-out;
        -moz-transition: all 300ms ease-out;
        -ms-transition: all 300ms ease-out;
        -o-transition: all 300ms ease-out;
        transition: all 300ms ease-out;
    }

    .checklist li a {
        color: #676a74;
        text-decoration: none;
        -webkit-transition: all 300ms ease-out;
        -moz-transition: all 300ms ease-out;
        -ms-transition: all 300ms ease-out;
        -o-transition: all 300ms ease-out;
        transition: all 300ms ease-out;
    }

    .checklist li a:hover {
        color: #222;
        -webkit-transition: all 300ms ease-out;
        -moz-transition: all 300ms ease-out;
        -ms-transition: all 300ms ease-out;
        -o-transition: all 300ms ease-out;
        transition: all 300ms ease-out;
    }

    .checklist a:hover span {
        border-color: #a6aab3;
    }

    .sizes a:hover span,
    .categories a:hover span {
        border-color: #a6aab3;
        -webkit-transition: all 300ms ease-out;
        -moz-transition: all 300ms ease-out;
        -ms-transition: all 300ms ease-out;
        -o-transition: all 300ms ease-out;
        transition: all 300ms ease-out;
    }

    .checklist a span span {
        border: none;
        margin: 0;
        float: none;
        position: absolute;
        top: 0;
        left: 0;
    }

    .checklist a .x {
        display: block;
        width: 0;
        height: 2px;
        background: #5ff7d2;
        top: 6px;
        left: 2px;
        -ms-transform: rotate(45deg);
        -webkit-transform: rotate(45deg);
        transform: rotate(45deg);
        -webkit-transition: all 50ms ease-out;
    }

    .checklist a .x.animate {
        width: 4px;
        -webkit-transition: all 100ms ease-in;
        -moz-transition: all 100ms ease-in;
        -ms-transition: all 100ms ease-in;
        -o-transition: all 100ms ease-in;
        transition: all 100ms ease-in;
    }

    .checklist a .y {
        display: block;
        width: 0px;
        height: 2px;
        background: #5ff7d2;
        top: 4px;
        left: 3px;
        -ms-transform: rotate(13deg);
        -webkit-transform: rotate(135deg);
        transform: rotate(135deg);
        -webkit-transition: all 50ms ease-out;
    }

    .checklist a .y.animate {
        width: 8px;
        -webkit-transition: all 100ms ease-out;
        -moz-transition: all 100ms ease-out;
        -ms-transition: all 100ms ease-out;
        -o-transition: all 100ms ease-out;
        transition: all 100ms ease-out;
    }

    .checklist .checked span {
        border-color: #8d939f;
    }


    .form span {

        position: absolute;
        right: 17px;
        top: 13px;
        padding: 2px;
        border-left: 1px solid #d1d5db;

    }

    .form-input {

        height: 55px;
        text-indent: 33px;
        border-radius: 10px;
    }

    .form-input:focus {

        box-shadow: none;
        border: none;
    }

</style>
@endsection
@section('content')
@include('frontend.components.modal-login')

<!-- ======= Services Section ======= -->
<section id="services" class="services">
    <div class="container" data-aos="fade-up">

        <div class="section-header mt-5">
            <h2>Events</h2>
        </div>

    @php
        $queryParams = request()->query();
    @endphp
    <form action="{{ url("/events") }}" method="GET">
        <input type="hidden" name="type" value="{{ request()->get("type") }}" id="">
        <div class="row gy-5">
            <div class="col-md-3">
                <div class="col-md-12">
                    <div class="checklist categories">
                        <h4 class="mb-4">Biaya</h4>
                        <ul>
                            <li><a type="submit"
                                    href="{{ request()->url() . (empty($queryParams) ? "?p=all" : "?" . http_build_query(array_merge($queryParams, ['p' => 'all'])) ) }}">
                                    <h5><i
                                            class="{{ in_array(request()->get("p"), ["all", ""]) ? "fa fa-check" : "" }} fa-xs"></i>
                                        All</h5>
                                </a></li>
                            <li><a type="submit"
                                    href="{{ request()->url() . (empty($queryParams) ? "?p=free" :  "?" . http_build_query(array_merge($queryParams, ['p' => 'free'])) ) }}">
                                    <h5><i
                                            class="{{ request()->get("p") == "free" ? "fa fa-check" : "" }} fa-xs"></i>
                                        Gratis</h5>
                                </a></li>
                            <li><a type="submit"
                                    href="{{ request()->url() . (empty($queryParams) ? "?p=non" :  "?" . http_build_query(array_merge($queryParams, ['p' => 'non'])) ) }}">
                                    <h5><i
                                            class="{{ request()->get("p") == "non" ? "fa fa-check" : "" }} fa-xs"></i>
                                        Berbayar</h5>
                                </a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="checklist categories">
                        <h4 class="mb-4">Tipe</h4>
                        <ul>
                            <li><a type="submit"
                                    href="{{ request()->url() . (empty($queryParams) ? "?type=all" : "?" . http_build_query(array_merge($queryParams, ['type' => 'all'])) ) }}">
                                    <h5><i
                                            class="{{ in_array(request()->get("type"), ["all", ""]) ? "fa fa-check" : "" }} fa-xs"></i>
                                        All</h5>
                                </a></li>
                            <li><a type="submit"
                                    href="{{ request()->url() . (empty($queryParams) ? "?type=online" :  "?" . http_build_query(array_merge($queryParams, ['type' => 'online'])) ) }}">
                                    <h5><i
                                            class="{{ request()->get("type") == "online" ? "fa fa-check" : "" }} fa-xs"></i>
                                        Online</h5>
                                </a></li>
                            <li><a type="submit"
                                    href="{{ request()->url() . (empty($queryParams) ? "?type=offline" :  "?" . http_build_query(array_merge($queryParams, ['type' => 'offline'])) ) }}">
                                    <h5><i
                                            class="{{ request()->get("type") == "offline" ? "fa fa-check" : "" }} fa-xs"></i>
                                        Offline</h5>
                                </a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="checklist categories">
                        <h4 class="mb-4">Category</h4>
                        <ul>
                            @foreach($categories as $category)
                                <li>
                                    <input class="form-check-input" type="checkbox" name="category[]"
                                        value="{{ $category->name }}" id="flexCheckDefault"
                                        {{ request()->get("category") ? (in_array($category->name, request()->get("category")) ? "checked" : "") : "" }}>
                                    <label class="form-check-label"
                                        for="category-{{ $category->name }}">{{ $category->name }}</label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-12 mt-5 p-5">
                    <button class="btn btn-outline-secondary" type="submit"
                        style="background-color:#0ea2bd; color:white">Apply Filters</button>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row gy-5">
                    <div class="col-md-12">
                        <div class="row height d-flex justify-content-center align-items-center">
                            <div class="col-md-12">
                                <div class="form">
                                    <input type="text" name="q" value="{{ request()->get("q") }}"
                                        class="form-control form-input" placeholder="Search Events...">
                                </div>

                            </div>
                        </div>
    </form>
    </div>
        <div class="row mt-5" id="events-data">
            @foreach($events as $event)
                <div class="col-xl-6 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                    <div class="service-item">
                        <div class="img">
                            <img src="{{ Storage::url($event->eventDetail->banner) }}" class="img-fluid"
                                style=" width:  100%;height: 350px;object-fit: cover;" alt="">
                        </div>
                        <div class="details position-relative">
                            <div class="icon">
                                <i class="bi bi-activity"></i>
                            </div>
                            <a href="{{ url('events/' . $event->event_slug) }}" target="_blank"
                                class="stretched-link">
                                <h3>{{ $event->eventDetail->title }}</h3>
                                <h4>{{ $event->eventDetail->price > 0 ?  "Rp . " . number_format($event->eventDetail->price) : "Free" }}
                                    </h5>
                            </a>
                            <p>{{ $event->eventDetail->limit_description }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </div>
    </div>
    <div class="text-center mt-5">
        <a href="javascript:;" class="btn btn-md" onclick="seeMore()" id="btn-seemore"
            style="background-color:#0ea2bd; color:white">See More</a>
    </div>

    </div>
</section><!-- End Services Section -->

@endsection
@section('external-js')
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="{{ asset("assets/frontend/js/events.js?v=1.2") }}"></script>
@endsection
