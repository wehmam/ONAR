@extends("backend.layouts")
@section("title", "Dashboard")
@section("content-title", "Dashboard")
@section("content")
<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Category</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-list-alt fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        All Participants</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">100</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-shopping-bag  fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Event Total</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">10</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-shopping-basket fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Income (Total)</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">Rp . {{ number_format(65000000, 0) }}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection