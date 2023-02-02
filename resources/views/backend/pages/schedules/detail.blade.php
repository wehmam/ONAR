@extends("backend.layouts")
@section('title', 'Dashboard')
@section('content-title', 'Detail Events')
@section('css')
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            height: 38px !important;
            /* padding: 10px 16px; */
            padding: 5px;
            /* font-size: 18px;  */
            line-height: 1.33;
            border-radius: 6px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            top: 75% !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 26px !important;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #CCC !important;
            box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.075) inset;
            transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
        }

        .delete-price-type-range-field {
            color: red;
        }
        .delete-price-type-range-field:hover {
            color: red;
            cursor: pointer;
        }

    </style>
@endsection
@section('content')

    <!-- DataTales Example -->
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Detail Events</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <img src="{{ (env("APP_ENV") != "production" ? "https://event.onar.asia" : "" ) . Storage::url($event->eventDetail->banner) }}" class="img-fluid mb-3" alt="">
                        </div>
                        <table class="table">
                            <tr>
                                <th>Title</th>
                                <td>{{ $event->eventDetail->title }}</td>
                            </tr>
                            <tr>
                                <th>Event Link</th>
                                <td>{{ url("events/" . $event->event_slug ) }}</td>
                            </tr>
                            <tr>
                                <th>Max Pendaftar</th>
                                <td>{{ $event->eventDetail->max_capacity }}</td>
                            </tr>
                            <tr>
                                <th>Event Type</th>
                                @if ($event->event_type == "online")
                                    <td><span class="badge badge-pill badge-info">Online</span></td>
                                @else
                                    <td><span class="badge badge-pill badge-warning">Offline</span></td>
                                @endif
                            </tr>
                            @if ($event->event_type == "online")
                                <tr>
                                    <th>Link Event</th>
                                    <td>{{ $event->eventDetail->link_event }}</td>
                                </tr>
                            @endif

                            <tr>
                                <th>Event Date & Time</th>
                                @php
                                    $eventDate = \Carbon\Carbon::parse($event->eventDetail->event_date)->locale('id');
                                    $eventDate->settings(['formatFunction' => 'translatedFormat']);
                                    $startHour =\Carbon\Carbon::parse($event->eventDetail->start_hour)
                                        ->locale('id')
                                        ->settings(['formatFunction'    => 'translatedFormat']);

                                    $endHour =\Carbon\Carbon::parse($event->eventDetail->end_hour)
                                        ->locale('id')
                                        ->settings(['formatFunction'    => 'translatedFormat']);
                                @endphp
                                <td>{{ $eventDate->format('l, j F Y') ." (". $startHour->format('H:i') ." - ". $endHour->format('H:i') .")" }}</td>
                            </tr>
                            <tr>
                                <th>Company</th>
                                <td>{{ $event->company->name }}</td>
                            </tr>
                            <tr>
                                <th>Publish At</th>
                                <td>{{ $event->publish_at }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table">
                                    <tr>
                                        <th>Jumlah Pendaftar</th>
                                        <td>{{ $event->participants->count() }}</td>
                                    </tr>
                                    <tr>
                                        <th>Sisa Kuota</th>
                                        <td>{{ $event->eventDetail->max_capacity - $event->participants->whereNotNull("paid_at")->count() }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kategori Events</th>
                                        <td>{{ $event->eventLabelLists->pluck("name")->implode(", ") }}</td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-12">
                                <button class="btn btn-md btn-success"><i class="fa fa-file" aria-hidden="true"></i> Export Participants</button>
                            </div>
                            <div class="col-md-12 mt-5">
                                <table class="table table-bordered table-registration">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Invoice</th>
                                            <th>Nama</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($event->participants as $registration)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $registration->invoice }}</td>
                                                <td>{{ $registration->user->name }}</td>
                                                <td>
                                                    <span class="badge badge-pill badge-{{ $registration->paid_at ? "info" : "danger" }}">{{ $registration->paid_at ? "Paid"  : "Not Paid" }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
       $(document).ready( function () {
            $('.table-registration').DataTable();
        });
    </script>
@endsection
