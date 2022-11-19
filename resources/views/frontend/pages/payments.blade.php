@extends("frontend.layouts")
@section('content')

<!-- ======= Services Section ======= -->
<section id="services" class="services">
    <div class="container" data-aos="fade-up">

        <div class="section-header mt-5">
        <h2>Payments {{ $registration->invoice }}</h2>
        </div>

        <div class="row gy-5" id="events-data">
                <div class="col-xl-5 col-md-6">
                    <div class="img">
                        <img src="/storage/images/schedules/0dsUzr06euADkbFsOn7hxX7bKbBHkiFUsIKGESaF.jpg" class="img-fluid" alt="">
                    </div>
                </div>
                <div class="col-xl-5 col-md-6">
                   <div class="row">
                       <div class="card col-md-12 offset-md-3 mb-3">
                            <div class="table-responsive mt-5 p-5">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <td width="150">Invoice</td>
                                            <td width="20">:</td>
                                            <td>{{ $registration->invoice }}</td>
                                        </tr>
                                        <tr>
                                            <td width="150">Seminar City</td>
                                            <td width="20">:</td>
                                            <td>{{ $registration->event->eventDetail->event_location }}</td>
                                        </tr>
                                        <tr>
                                            <td width="150">Name</td>
                                            <td width="20">:</td>
                                            <td>{{ ucwords($registration->user->name) ?? "" }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>:</td>
                                            <td>{{ $registration->user->email ?? "" }}</td>
                                        </tr>
                                        
                                        @php
                                            $date = \Carbon\Carbon::parse($registration->event->eventDetail->event_date)->locale('id');
                                            $date->settings(['formatFunction' => 'translatedFormat']);
                                            $startHour =\Carbon\Carbon::parse($registration->event->eventDetail->start_hour)
                                                ->locale('id')
                                                ->settings(['formatFunction'    => 'translatedFormat']);

                                            $endHour =\Carbon\Carbon::parse($registration->event->eventDetail->end_hour)
                                                ->locale('id')
                                                ->settings(['formatFunction'    => 'translatedFormat']);

                                        @endphp
                                        <tr>
                                            <td>Date</td>
                                            <td>:</td>
                                            <td>{{ $date->format('l, j F Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Time</td>
                                            <td>:</td>
                                            <td>{{ $startHour->format('H:i') }} - {{ $endHour->format('H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td>:</td>
                                            <td class="red">Rp. 100.000,00</td>
                                        </tr>
                                        <tr>
                                            <td>Payment Status</td>
                                            <td>:</td>
                                            <td>Unpaid</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="col-md-12 text-center mt-5">
                                    <button class="btn btn-md btn-primary">Gopay</button>
                                    <button class="btn btn-md btn-warning">Bank Online</button>
                                </div>
                            </div>
                       </div>
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
