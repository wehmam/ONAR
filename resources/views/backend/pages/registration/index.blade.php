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
            <form action="{{ url("/backend/participants") }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Status Payment</label>
                            <select name="status_payment" id="" class="form-control">
                                <option value="" {{ !request()->get("status_payment") ? "selected" : "" }}>All</option>
                                <option value="paid" {{ request()->get("status_payment") == "paid" ? "selected" : "" }}>PAID</option>
                                <option value="unpaid" {{ request()->get("status_payment") == "unpaid" ? "selected" : "" }}>UNPAID</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Invoice</label>
                            <input type="text" class="form-control" name="invoice" value="{{ request()->get("invoice") }}">
                        </div>
                    </div>

                    @if(is_null(\Sentinel::check()->company_id))
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Company</label>
                                <select name="company" id="" class="form-control">
                                    <option value="">All</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}" {{ request()->get("company") == $company->name ? "selected" : ""  }}>{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

                    <div class="col-md-3 mt-4">
                        <button type="submit" class="btn btn-md btn-info"><span class="fa fa-search"></span> Search</button>
                        {{-- <a href="#" class="btn btn-md btn-success"><span class="fa fa-file"></span> Export</a> --}}
                    </div>

                </div>
            </form>
        {{-- <h6 class="m-0 font-weight-bold text-primary">List Participant <span class="float-right"> <a href="{{ url("backend/events/create") }}" class="btn btn-success btn-sm" ><i class="fa fa-plus"> Events</i></a></span></h6> --}}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table-schedules">
                    <thead class="text-center">
                        <tr>
                            <th>Invoice</th>
                            <th>Name</th>
                            <th>Email</th>
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
                                <td>{{ $data->user->email ?? "" }}</td>
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
