@extends("frontend.layouts")
@section('content')

<!-- ======= Services Section ======= -->
<section id="services" class="services">
    <div class="container" data-aos="fade-up">

        <div class="section-header mt-5">
        <h2>Payments</h2>
        </div>

        <div class="row gy-5" id="events-data">
                <div class="col-xl-5 col-md-6">
                    <div class="img">
                        <img src="http://127.0.0.1:8000/storage/images/schedules/6EzdSUbe2qCp2hbIqvjyrS9caBz8eBgEjpWeBFwJ.jpg" class="img-fluid" alt="">
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
                                            <td>ONR12345</td>
                                        </tr>
                                        <tr>
                                            <td width="150">Seminar City</td>
                                            <td width="20">:</td>
                                            <td>DKI Jakarta</td>
                                        </tr>
                                        <tr>
                                            <td width="150">Name</td>
                                            <td width="20">:</td>
                                            <td>Imam Maulana Ashari</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>:</td>
                                            <td>imam@fintegra.co.id</td>
                                        </tr>
        
                                        <tr>
                                            <td>Date</td>
                                            <td>:</td>
                                            <td>2022-07-20</td>
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td>:</td>
                                            <td class="red">Rp. 100.000,00</td>
                                        </tr>
                                        <tr>
                                            <td>Payment Status</td>
                                            <td>:</td>
                                            <td>Un Paid</td>
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
