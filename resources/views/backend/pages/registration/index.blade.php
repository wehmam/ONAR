@extends("backend.layouts")
@section("title", "Dashboard")
@section("content-title", "Participants")
@section('css')
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
@endsection
@section("content")

<!-- DataTales Example -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
        {{-- <h6 class="m-0 font-weight-bold text-primary">List Participant <span class="float-right"> <a href="{{ url("backend/events/create") }}" class="btn btn-success btn-sm" ><i class="fa fa-plus"> Events</i></a></span></h6> --}}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table-schedules">
                    <thead class="text-center">
                        <tr>
                            <th>Invoice</th>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Events</th>
                            <th>Price</th>
                            <th>Status Payment</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($participants as $data)
                            <tr>
                                <td>{{ $data->invoice }}</td>
                                <td>{{ $data->user->name ?? "" }}</td>
                                <td>{{ $data->event->company->name ?? "" }}</td>
                                <td>{{ $data->event->eventDetail->title ?? "" }}</td>
                                <td>Rp . {{ number_format($data->total_price , 2) ?? 0 }}</td>
                                <td>
                                    @if(!is_null($data->paid_at))
                                        <span class="badge alert-success">PAID</span>
                                    @else
                                        <span class="badge alert-danger">UNPAID</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-center">
                    {!! $participants->appends($_GET)->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
{{-- <script src="{{ asset("assets/backend/js/schedules.js") }}"></script> --}}
@endsection
