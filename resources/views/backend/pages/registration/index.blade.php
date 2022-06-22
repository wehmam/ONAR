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
        <h6 class="m-0 font-weight-bold text-primary">List Participant <span class="float-right"> <a href="{{ url("backend/schedules/create") }}" class="btn btn-success btn-sm" ><i class="fa fa-plus"> Schedules</i></a></span></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table-schedules">
                    <thead class="text-center">
                        <tr>
                            <th>Invoice</th>
                            <th>Name</th>
                            <th>Events</th>
                            <th>Price</th>
                            <th>Status Payment</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr>
                            <td>ONR1234</td>
                            <td>Imam Maulana Ashari</td>
                            <td>Event Hackathon 2022</td>
                            <td>Rp . 200,000</td>
                            <td><span class="badge badge-success">Paid</span></td>
                        </tr>
                        <tr>
                            <td>ONR12355</td>
                            <td>Ayu Nandita Ashari</td>
                            <td>Event Hacklab 2022</td>
                            <td>Rp . 100,000</td>
                            <td><span class="badge badge-danger">Not Paid</span></td>
                        </tr>
                        <tr>
                            <td>ONR12322</td>
                            <td>Fathan Mahavira Prasetyo</td>
                            <td>Event Cloud Services</td>
                            <td>Rp . 300,000</td>
                            <td><span class="badge badge-success">Paid</span></td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center">
                    {{-- {!! $category->appends($_GET)->links() !!} --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
{{-- <script src="{{ asset("assets/backend/js/schedules.js") }}"></script> --}}
@endsection
