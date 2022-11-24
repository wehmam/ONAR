@extends("frontend.layouts")
@section('external-css')
    <style>
        .badge {
            background-color: rgb(0, 225, 255);
            color: white;
            padding: 4px 8px;
            text-align: center;
            border-radius: 5px;
        }
    </style>
@endsection
@section('content')

<!-- ======= Services Section ======= -->
<section id="services" class="services">
    <div class="container" data-aos="fade-up">

        <div class="section-header mt-5">
        <h2>Payments {{ $registration->invoice }}</h2>
        </div>

        <div class="row gy-5" id="events-data">
                <div class="col-xl-5 col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="img">
                                <img src="{{ Storage::url($registration->event->eventDetail->banner) }}" class="img-fluid" alt="">
                            </div>
                        </div>
                        @if(!is_null($registration->dump_payment) && is_null($registration->paid_at))
                            @php
                                $dump = generateArrMidtrans($registration->dump_payment);
                            @endphp
                            <div class="col-md-12">
                                <p class="card-desc mt-5" style="text-align:center">Silahkan transfer ke nomor rekening dibawah ini :</p>
                                <div class="card col-md-12 mb-3">
                                    <div class="table-responsive mt-5 p-5">
                                        <table class="table table-hover">
                                            <tbody>
                                                <tr>
                                                    <th>Bank</th>
                                                    <td style="text-transform: capitalize;">{{ mb_strtoupper($dump['flag']) }}</td>
                                                </tr>
                                                @if (isset($dump['kode_perusahaan']) && $dump['kode_perusahaan'] !== '')
                                                    <tr>
                                                        <th>Kode Perusahaan</th>
                                                        <td>{{ $dump['kode_perusahaan'] }}</td>
                                                    <tr>
                                                    <tr>
                                                        <th>Kode Pembayaran</th>
                                                        <td>{{ $dump['account_number'] }}</td>
                                                    <tr>
                                                @else
                                                    <tr>
                                                        <th>Rekening</th>
                                                        <td>{{ $dump['account_number'] }}</td>
                                                    </tr>
                                                @endif
                                                @if ($registration->dump_payment != '')
                                                    <tr>
                                                        <th>Tagihan</th>
                                                        <th>Rp {{ number_format($registration->total_price, 2) }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Biaya Transfer</th>
                                                        <th>Rp {{ number_format(($dump['gross_amount'] - $registration->total_price), 2) }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Total Pembayaran</th>
                                                        <th>Rp {{ number_format(($dump["gross_amount"]) ,2) }}</th>
                                                    </tr>
                                                @endif
                                                </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
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
                                            <td>{{ strtoupper($registration->event->eventDetail->event_location) }}</td>
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
                                            <td>Price</td>
                                            <td>:</td>
                                            @if($registration->total_price <= 0) 
                                                <td>Rp. 0</td>
                                            @else 
                                                <td class="red">Rp. {{ number_format($registration->event->eventDetail->price + 4400) }}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>Payment Status</td>
                                            <td>:</td>
                                            <td>
                                                @if($registration->total_price <= 0) 
                                                    <h3 class="badge">Free</h3>
                                                @else 
                                                    <h3 class="badge">{{ !is_null($registration->dump_payment) && is_null($registration->paid_at) ? "PENDING" : (!is_null($registration->paid_at) ? "Paid" : "Unpaid" ) }}</h3>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="col-md-12 text-center mt-5">
                                    @if(is_null($registration->paid_at))
                                        @if($registration->dump_payment)
                                            <button class="btn btn-md btn-warning btn-pay">Change Payment</button>
                                        @else 
                                            <button class="btn btn-md btn-warning btn-pay">Bank Online</button>
                                        @endif
                                    @endif
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
{{-- <script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="Mid-client-vX1uJJLZxlUy_3mn"></script> --}}
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-iR3m11J8EDBriIte"></script>
<script src="{{ asset("assets/frontend/js/do.js?v=1.2") }}"></script>
@endsection
