@extends("backend.layouts")
@section("title", "Company")
@section("content-title", "Company")
@section('css')
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
@endsection
@section("content")

<!-- DataTales Example -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
        @if(is_null(\Sentinel::check()->company_id))
            <h6 class="m-0 font-weight-bold text-primary">List Company <span class="float-right"> <a href="{{ url("backend/companies/create") }}" class="btn btn-success btn-sm" ><i class="fa fa-plus"> Company</i></a></span></h6>
        @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table-companies">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Total Event</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection
@section('js')
    <script src="{{ asset("assets/backend/js/companies.js?v=1.0") }}"></script>
@endsection
