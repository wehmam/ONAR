@extends('home.layouts')
@section('title')
    SIMINAR
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('home/main.css') }}">
@endsection
{{-- @section('js')
    <script>
        // validasi nomor telepon hanya angka yg bisa di isi
        function nomor(e) {
            if (!/^[0-9]+$/.test(e.value)) {
                e.value = e.value.substring(0, e.value.length - 1);
            }
        }

        function scrollToJadwal() {
            const x = document.getElementById('jadwal');
            var headerOffset = 250;
            var elementPosition = x.getBoundingClientRect().top;
            var offsetPosition = elementPosition - headerOffset;


            window.scrollTo({
                top: offsetPosition,
                behavior: "smooth"
            });
        }

        $(document).ready(function() {
            // $("#schedule_id").select2({
            //     width: '100%'
            // });
            // $(".select2-container--default .select2-selection--single").css("height", "50px");
            // $(".select2-container--default .select2-selection--single .select2-selection__rendered").css("margin-top", "10px");

            // fungsi select option dinamis untuk harga seminar

            $("#schedule_id").change(function(e) {
                var val = $(this).val();
                var hasSchedule = $('option:selected', this).attr('data-has-schedule');
                var hasDescription = $('option:selected', this).attr('data-desc');

                if (hasDescription != undefined) {
                    $('#description_seminar').show();
                    $('#description_seminar').html(hasDescription);
                } else {
                    $('#description_seminar').hide();
                }

                ajaxPersonFee();
            });

            ajaxPersonFee();

            if (performance.navigation.type == 2) {
                location.reload(true);
            }

            function ajaxPersonFee() {
                var schedule = $("#schedule_id");
                var scheduleVal = schedule.val();
                var hasSchedule = $('option:selected', schedule).attr('data-has-schedule');
                var onePerson = $('option:selected', schedule).attr('data-one-person-fee');
                var twoPerson = $('option:selected', schedule).attr('data-two-person-fee');
                var option1 = '<option value="1">1 Orang Rp. ' + Intl.NumberFormat('de-DE').format(onePerson) +
                    '</option>';
                var option2 = '<option value="2">2 Orang Rp. ' + Intl.NumberFormat('de-DE').format(twoPerson) +
                    '</option>';

                var rp = 'Rp. '

                if (onePerson > 0 && twoPerson > 0) {

                    $('#total-peserta').show();
                    $("#total option").each(function() {
                        $(this).remove();
                    });
                    $('#total').append(option1 + option2);
                    $('#spanHargaNormal').empty();
                    $('#spanHargaNormal').append(rp + Intl.NumberFormat('de-DE').format(onePerson * 2))
                    $('#spanHarga').empty();
                    $('#spanHarga').append(rp + Intl.NumberFormat('de-DE').format(onePerson));
                    $('p.harga_normal').removeClass('d-none');
                    $('p.hari_ini').removeClass('d-none');
                    $('p.khusus50pendaftar').removeClass('d-none');
                } else {
                    $('#div-seminar').hide();
                    $('#total-peserta').hide();
                    $('#spanHargaNormal').empty();
                    $('#spanHarga').empty();
                }

                // untuk select option total peserta
                $('#total').change(function() {
                    var vl = $(this).val();
                    if (vl == 2) {
                        $('#spanHarga').empty();
                        $('#spanHargaNormal').empty();
                        $('#spanHarga').append(rp + Intl.NumberFormat('de-DE').format(twoPerson));
                        $('#spanHargaNormal').append(rp + Intl.NumberFormat('de-DE').format(twoPerson * 2))
                    } else {
                        $('#spanHarga').empty();
                        $('#spanHarga').append(rp + Intl.NumberFormat('de-DE').format(onePerson));
                        $('#spanHargaNormal').empty();
                        $('#spanHargaNormal').append(rp + Intl.NumberFormat('de-DE').format(onePerson * 2))
                    }
                });
            }

            // validasi di front end
            setTimeout(() => {
                $("button#smt-btn").prop('disabled', true);
                // $('span#span-tooltip').attr("title","Isi data dengan lengkap, jika sudah klik DAFTAR !")
                // $('span[data-toggle="tooltip"]').tooltip();

                var toValidate = $('#name-form1-p, #email-form1-p, #phone-form1-p'),
                    valid = false;
                toValidate.keyup(function() {
                    if ($(this).val().length > 0) {
                        $(this).data('valid', true);
                    } else {
                        $(this).data('valid', false);
                    }
                    toValidate.each(function() {
                        if ($(this).data('valid') == true) {
                            valid = true;
                        } else {
                            valid = false;
                        }
                    });
                    if (valid === true) {
                        $("button#smt-btn").prop('disabled', false);
                    } else {
                        $("button#smt-btn").prop('disabled', true);
                    }
                });
            }, 2000)

            // kondisi default to seminar
            let search = window.location.search;
            if (search === '') {
                $('#total-peserta').hide();
                $('#spanHargaNormal').empty();
                $('#spanHarga').empty();
                $('#schedule_id option').removeAttr('selected')
                $('#schedule_id option').first().attr('selected', true);
                $('#div-seminar').show();
                $('#schedule_id').show();
                $('option#seminar').show();
                $('option#webinar').hide();
                $('p.harga_normal').addClass('d-none');
                $('p.hari_ini').addClass('d-none');
                $('p.khusus50pendaftar').addClass('d-none');
            }
        });

        function changeFunc() {
            var selectBox = document.getElementById("selectBox");
            var selectedValue = selectBox.options[selectBox.selectedIndex].value;
            if (selectedValue == 'seminar') {
                $('#total-peserta').hide();
                $('#spanHargaNormal').empty();
                $('#spanHarga').empty();
                $('#schedule_id option').removeAttr('selected')
                $('#schedule_id option').first().attr('selected', true);
                $('#div-seminar').show();
                $('#schedule_id').show();
                $('option#seminar').show();
                $('option#webinar').hide();
                $('p.harga_normal').addClass('d-none');
                $('p.hari_ini').addClass('d-none');
                $('p.khusus50pendaftar').addClass('d-none');
            } else if (selectedValue == 'webinar') {
                $('#total-peserta').hide();
                $('#spanHargaNormal').empty();
                $('#spanHarga').empty();
                $('#schedule_id option').removeAttr('selected')
                $('#schedule_id option').first().attr('selected', true);
                $('#div-seminar').show();
                $('#schedule_id').show();
                $('option#webinar').show();
                $('option#seminar').hide();
                $('p.harga_normal').addClass('d-none');
                $('p.hari_ini').addClass('d-none');
                $('p.khusus50pendaftar').addClass('d-none');
                $('#description_seminar').hide();
            } else {
                $('#div-seminar #schedule_id option#webinar').hide();
            }
        }

        var onSuccess = function(response) {
            $(function() {
                $('#modalFormulirPendaftaran').modal('toggle');
            });
            showLoading()
            document.getElementById("recaptcha-demo-form").submit();
        };
        woopra.track("register_view", {
            product_id: '{{ isset($city) ? $city . date('Y-m') : '' }}',
            city: '{{ isset($city) ? $city : '' }}',
            category: 'Seminar',
            price: 100000,
            quantity: 1,
            url: `{{ url('pendaftaran?city=' . (isset($city) ? $city : '')) }}`
        });
        $("#recaptcha-demo-form").change(function() {
            pushWoopraFormRegister();
        });

        function pushWoopraFormRegister() {
            let name = $('#name-form1-p').val();
            let email = $('#email-form1-p').val();
            let phone = $('#phone-form1-p').val();
            let city = $("#schedule_id option:selected").text().trim().replace(/\s\s+/g, ' ');
            let total = ($('#total').val() === '1') ? 100000 : 150000;
            let reference = $('#reference-form1-p').val();
            woopra.track("register_form_input_before_submit", {
                product_id: city + '{{ date('Y-m') }}',
                name: name,
                email: email,
                phone: phone,
                city: city,
                reference: reference,
                category: 'Seminar',
                price: total,
                quantity: (total > 110000) ? 2 : 1,
                url: `{{ url('pendaftaran?city=' . (isset($city) ? $city : '')) }}`
            });
        }

        function daftarDefault(){
            var data        = $('#total').find('.options');
            var dataDefault = data[0].selected = true;
            var option = $('.listSeminar');
            var length = option.length;
            for (i = 0; i < length; i++) {
                var dataOption = $(option[i]).attr("selected", false);
            }

            $('.time-and-place').attr("readonly",false);
            $('.total-peserta').attr("readonly",false);
            $('.seminar-type').attr("readonly",false);
        }

        //Submit Filter
        function searchFilter() {
            showLoading()
            $("#formFilter").submit();
        }

        let totalEventFirst   = parseInt($('#totalEvent').html().replace(/\D/g, ''));
        if(totalEventFirst < 10){
            $('.button-load ').hide();
        }

        if(totalEventFirst < 1){
            $( "<p class='text-center no-ticket' style='font-size:20px;'>No more seminar tickets found</p>" ).insertBefore( ".button-load" );
            $( ".no-ticket" ).css("margin-top",  "-100px");
        }

        $('.button-load ').css('margin-top', '-100px');
        function eloadMoreData(page, url, load){

            if(load == 'default'){
                $.ajax({
                    url:'?page=' + page,
                    type:'get',
                    beforeSend: function()
                    {
                        $('.ajax-load').css('margin-top', '-160px');
                        $('.button-load ').hide();
                        $('.ajax-load').show();
                    }
                })
                .done(function(data){
                    if(data.box.data.length == 0){
                        $('.ajax-load').html("No more seminar tickets found");
                        return;
                    }
                    
                    let totalEventFirst   = parseInt($('#totalEvent').html().replace(/\D/g, ''));
                    let totalEventRequest = data.box.data.length;
                    let totalEventFix     = totalEventFirst + totalEventRequest;
                    $('#totalEvent').html(totalEventFix +" "+ "Event");
                
                    $('.ajax-load').hide();
                    $('.button-load ').show();
                    $.each(data.box.data, function(item, i) {
                        let dateParse = Date.parse(data.box.data[item].event_date);
                        let dateObj   = new Date(dateParse);
                    
                        let mo = new Intl.DateTimeFormat('en', { month: 'short' }).format(dateObj);
                        let da = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(dateObj);
                        let date = `${da} ${mo}`
                        let hourParse =  typeof data.box.data[item].start_hour == 'string' ? data.box.data[item].start_hour.slice(0,5) : " ";
                    
                        $('#post-data').append(`
                        <div class="box">
                        <div class="row">
                            <div class="col-12">
                                <div class="card-ticket" data-aos="zoom-in-down">
                                    <div class="circle1"></div>
                                    <div class="row mt-1">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-12 col-md-3 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-12 col-md-12 col-sm-12 locations">
                                                            <div class="row">
                                                                <div class="col-2">
                                                                    <img class="location"
                                                                        src="{{ asset('images/seminar-org/map.png') }}"
                                                                        alt="Location">
                                                                </div>
                                                                <div class="col-10">
                                                                    <span class="city text-left">`+ data.box.data[item].city +`</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4 col-sm-4">
                                                    <div class="row text-center">
                                                        <div class="col-6 col-lg-6 col-md-6 col-sm-6">
                                                            <div class="row border-right">
                                                                <div class="col-12 col-md-12  col-sm-12">
                                                                    <span class="label">Date</span>
                                                                </div>
                                                                <div class="col-12 col-md-12  col-sm-12">
                                                                    <span
                                                                        class="date-hours">`+ date +`</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-6 col-sm-6">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <span class="label">Hour</span>
                                                                </div>
                                                                <div class="col-12">
                                                                    <span
                                                                        class="date-hours">`+ hourParse +`
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="circle-responsive1"></div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="circle-responsive2"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4" data-quantity-all="">
                                        <div class="col-12 col-md-3 col-sm-3">
                                            <div class="row">
                                                <div class="col-6 col-md-12 col-sm-12 ">
                                                    <div class="col-12 col-md-12 col-sm-12">
                                                        <div class="quantity-control" data-quantity="">
                                                            <button class="quantity-btn" data-quantity-minus="" onclick="dataQuantityMinus(`+data.box.data[item].id +`,`+ data.box.data[item].one_person_fee+`)"><svg
                                                                    viewBox="0 0 409.6 409.6">
                                                                    <g>
                                                                        <g>
                                                                            <path
                                                                                d="M392.533,187.733H17.067C7.641,187.733,0,195.374,0,204.8s7.641,17.067,17.067,17.067h375.467 c9.426,0,17.067-7.641,17.067-17.067S401.959,187.733,392.533,187.733z" />
                                                                        </g>
                                                                    </g>
                                                                </svg></button>
                                                            <input type="number" onkeyup="dataQuantityKeyup(`+data.box.data[item].id+`,`+data.box.data[item].one_person_fee+`,`+data.box.data[item].two_person_fee+`)" class="quantity-input `+data.box.data[item].id +`"
                                                                data-quantity-target="" value="1" step="0.1" min="1" max=""
                                                                name="quantity"
                                                                {{ (isset($filters) && $filters['city'] != null) || $filters['date'] != null || $filters['seminar_type'] != null ? 'autofocus' : '' }}>
                                                            <button class="quantity-btn" data-quantity-plus="" onclick="dataQuantityPlus(`+data.box.data[item].id+`,`+data.box.data[item].two_person_fee+`)"><svg
                                                                    viewBox="0 0 426.66667 426.66667">
                                                                    <path
                                                                        d="m405.332031 192h-170.664062v-170.667969c0-11.773437-9.558594-21.332031-21.335938-21.332031-11.773437 0-21.332031 9.558594-21.332031 21.332031v170.667969h-170.667969c-11.773437 0-21.332031 9.558594-21.332031 21.332031 0 11.777344 9.558594 21.335938 21.332031 21.335938h170.667969v170.664062c0 11.777344 9.558594 21.335938 21.332031 21.335938 11.777344 0 21.335938-9.558594 21.335938-21.335938v-170.664062h170.664062c11.777344 0 21.335938-9.558594 21.335938-21.335938 0-11.773437-9.558594-21.332031-21.335938-21.332031zm0 0" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-12 col-sm-12">
                                                    <span class="total-price total-price-js`+data.box.data[item].id+`" data-price="">
                                                        Rp.`+new Intl.NumberFormat().format(data.box.data[item].one_person_fee)+`
                                                    </span>
                                                    <span style="display:none" data-one-price="">
                                                        `+ new Intl.NumberFormat().format(data.box.data[item].one_person_fee)+`
                                                    </span>
                                                    <span style="display:none" data-two-price="">
                                                        `+ new Intl.NumberFormat().format(data.box.data[item].two_person_fee) +`
                                                    </span>
                                                </div>
                                                <div class="col-12 col-md-12 col-sm-12">
                                                    <button data-toggle="modal" data-target="#modalFormulirPendaftaran"
                                                        class="daftar" onclick="daftar(`+data.box.data[item].id+`,`+data.box.data[item].is_online+`,`+data.box.data[item].one_person_fee+`,`+ data.box.data[item].two_person_fee +`)" data-seminar="`+ data.box.data[item].is_online +`"
                                                        data-id="`+ data.box.data[item].id +`"
                                                        data-harga="`+ data.box.data[item].one_person_fee +`"
                                                        data-two-harga ="`+ data.box.data[item].two_person_fee +`"
                                                        data-quantity-target="">Daftar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 col-sm-4">
                                            <span class="invest-detail">`+ data.box.data[item].investasi +`</span>
                                        </div>
                                        <div class="col-12 col-md-4 sol-sm-4 text-left desc">
                                            <span class="address"></span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-md-12 col-sm-12">
                                            <span class="note-seminar">Pastikan data yang kamu isi sudah BENAR Tiket ini tidak
                                                dapat di REFUND dan tidak dapat di Reschedule</span>
                                        </div>
                                    </div>
                                    <div class="circle2"></div>
                                </div>
                            </div>
                        </div>
                    </div>`)
                    
                    });  
                })
                .fail(function(jqXHR,ajaxOptions,thrownError){
                    alert('Server not responding...');
                })

            }else{
                $.ajax({
                    url:'?page=' + page + url,
                    type:'get',
                    beforeSend: function()
                    {
                        $('.ajax-load').css('margin-top', '-160px');
                        $('.button-load ').hide();
                        $('.ajax-load').show();
                    }
                })
                .done(function(data){
                    if(data.box.data.length == 0){
                        $('.ajax-load').html("No more seminar tickets found");
                        return;
                    }
                    
                    let totalEventFirst   = parseInt($('#totalEvent').html().replace(/\D/g, ''));
                    let totalEventRequest = data.box.data.length;
                    let totalEventFix     = totalEventFirst + totalEventRequest;
                    $('#totalEvent').html(totalEventFix +" "+ "Event");
                
                    $('.ajax-load').hide();
                    $('.button-load ').show();
                    $.each(data.box.data, function(item, i) {
                        let dateParse = Date.parse(data.box.data[item].event_date);
                        let dateObj   = new Date(dateParse);
                    
                        let mo = new Intl.DateTimeFormat('en', { month: 'short' }).format(dateObj);
                        let da = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(dateObj);
                        let date = `${da} ${mo}`
                        let hourParse =  typeof data.box.data[item].start_hour == 'string' ? data.box.data[item].start_hour.slice(0,5) : " ";
                    
                        $('#post-data').append(`
                        <div class="box">
                        <div class="row">
                            <div class="col-12">
                                <div class="card-ticket" data-aos="zoom-in-down">
                                    <div class="circle1"></div>
                                    <div class="row mt-1">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-12 col-md-3 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-12 col-md-12 col-sm-12 locations">
                                                            <div class="row">
                                                                <div class="col-2">
                                                                    <img class="location"
                                                                        src="{{ asset('images/seminar-org/map.png') }}"
                                                                        alt="Location">
                                                                </div>
                                                                <div class="col-10">
                                                                    <span class="city text-left">`+ data.box.data[item].city +`</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4 col-sm-4">
                                                    <div class="row text-center">
                                                        <div class="col-6 col-lg-6 col-md-6 col-sm-6">
                                                            <div class="row border-right">
                                                                <div class="col-12 col-md-12  col-sm-12">
                                                                    <span class="label">Date</span>
                                                                </div>
                                                                <div class="col-12 col-md-12  col-sm-12">
                                                                    <span
                                                                        class="date-hours">`+ date +`</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-6 col-sm-6">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <span class="label">Hour</span>
                                                                </div>
                                                                <div class="col-12">
                                                                    <span
                                                                        class="date-hours">`+ hourParse +`
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="circle-responsive1"></div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="circle-responsive2"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4" data-quantity-all="">
                                        <div class="col-12 col-md-3 col-sm-3">
                                            <div class="row">
                                                <div class="col-6 col-md-12 col-sm-12 ">
                                                    <div class="col-12 col-md-12 col-sm-12">
                                                        <div class="quantity-control" data-quantity="">
                                                            <button class="quantity-btn" data-quantity-minus="" onclick="dataQuantityMinus(`+data.box.data[item].id +`,`+ data.box.data[item].one_person_fee+`)"><svg
                                                                    viewBox="0 0 409.6 409.6">
                                                                    <g>
                                                                        <g>
                                                                            <path
                                                                                d="M392.533,187.733H17.067C7.641,187.733,0,195.374,0,204.8s7.641,17.067,17.067,17.067h375.467 c9.426,0,17.067-7.641,17.067-17.067S401.959,187.733,392.533,187.733z" />
                                                                        </g>
                                                                    </g>
                                                                </svg></button>
                                                            <input type="number" onkeyup="dataQuantityKeyup(`+data.box.data[item].id+`,`+data.box.data[item].one_person_fee+`,`+data.box.data[item].two_person_fee+`)" class="quantity-input `+data.box.data[item].id +`"
                                                                data-quantity-target="" value="1" step="0.1" min="1" max=""
                                                                name="quantity"
                                                                {{ (isset($filters) && $filters['city'] != null) || $filters['date'] != null || $filters['seminar_type'] != null ? 'autofocus' : '' }}>
                                                            <button class="quantity-btn" data-quantity-plus="" onclick="dataQuantityPlus(`+data.box.data[item].id+`,`+data.box.data[item].two_person_fee+`)"><svg
                                                                    viewBox="0 0 426.66667 426.66667">
                                                                    <path
                                                                        d="m405.332031 192h-170.664062v-170.667969c0-11.773437-9.558594-21.332031-21.335938-21.332031-11.773437 0-21.332031 9.558594-21.332031 21.332031v170.667969h-170.667969c-11.773437 0-21.332031 9.558594-21.332031 21.332031 0 11.777344 9.558594 21.335938 21.332031 21.335938h170.667969v170.664062c0 11.777344 9.558594 21.335938 21.332031 21.335938 11.777344 0 21.335938-9.558594 21.335938-21.335938v-170.664062h170.664062c11.777344 0 21.335938-9.558594 21.335938-21.335938 0-11.773437-9.558594-21.332031-21.335938-21.332031zm0 0" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-12 col-sm-12">
                                                    <span class="total-price total-price-js`+data.box.data[item].id+`" data-price="">
                                                        Rp.`+new Intl.NumberFormat().format(data.box.data[item].one_person_fee)+`
                                                    </span>
                                                    <span style="display:none" data-one-price="">
                                                        `+ new Intl.NumberFormat().format(data.box.data[item].one_person_fee)+`
                                                    </span>
                                                    <span style="display:none" data-two-price="">
                                                        `+ new Intl.NumberFormat().format(data.box.data[item].two_person_fee) +`
                                                    </span>
                                                </div>
                                                <div class="col-12 col-md-12 col-sm-12">
                                                    <button data-toggle="modal" data-target="#modalFormulirPendaftaran"
                                                        class="daftar" onclick="daftar(`+data.box.data[item].id+`,`+data.box.data[item].is_online+`,`+data.box.data[item].one_person_fee+`,`+ data.box.data[item].two_person_fee +`)" data-seminar="`+ data.box.data[item].is_online +`"
                                                        data-id="`+ data.box.data[item].id +`"
                                                        data-harga="`+ data.box.data[item].one_person_fee +`"
                                                        data-two-harga ="`+ data.box.data[item].two_person_fee +`"
                                                        data-quantity-target="">Daftar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 col-sm-4">
                                            <span class="invest-detail">`+ data.box.data[item].investasi +`</span>
                                        </div>
                                        <div class="col-12 col-md-4 sol-sm-4 text-left desc">
                                            <span class="address"></span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-md-12 col-sm-12">
                                            <span class="note-seminar">Pastikan data yang kamu isi sudah BENAR Tiket ini tidak
                                                dapat di REFUND dan tidak dapat di Reschedule</span>
                                        </div>
                                    </div>
                                    <div class="circle2"></div>
                                </div>
                            </div>
                        </div>
                    </div>`)
                    
                    });  
                })
                .fail(function(jqXHR,ajaxOptions,thrownError){
                    alert('Server not responding...');
                })
            }
        }

        var page = 1;
        function loadMoreButton(LoadMore){
            const queryString = "";
            let loadFor = 'default'
            page++;
            loadMoreData(page, queryString, loadFor);
        }

        function loadMoreButtonFilter(loadMoreFilter){
            const queryString = window.location.search.replace('?', '&');
            let loadFor = 'filter'
            page++
            loadMoreData(page, queryString, loadFor);
        }

        function dataQuantityPlus(id,twoPrice){
            var quantities = parseInt($(`.`+id ).val()) + 1;
            if (quantities > 2) {
                return false
            }
            var totals = twoPrice;
            var total = new Intl.NumberFormat().format(totals);
            $('.total-price-js'+id).html('Rp.' + total);
            $(`.`+id ).val(quantities);
        }

        function dataQuantityMinus(e,d){
            var quantities = parseInt($(`.`+e ).val());
            if (quantities <= 1) {
                return false
            }
            var totals = d;
            var total = new Intl.NumberFormat().format(totals);
            $('.total-price-js'+e).html('Rp.' + total);
            $(`.`+e ).val(--quantities);
        }
        function dataQuantityKeyup(id,onePrice,twoPrice){
            var quantityValue = $('.'+id).val();
            if(quantityValue == 1){
                totals = onePrice;
            }else if(quantityValue == 2){
                totals = twoPrice;
            }
            if (quantityValue == '') {
                return false;
            }
            if (quantityValue > 2) {
                $('.'+id).val(2);
                return false;
            }
            var total = new Intl.NumberFormat().format(totals);
            $('.total-price-js'+id).html('Rp.' + total);
        }

        function daftar(id,dataSeminar,onePrice,twoPrice){
            if (typeof dataSeminar !== 'undefined') {
                if (dataSeminar == 0) {
                    document.getElementsByClassName("selected1")[0].selected = true;
                    var tes = document.getElementsByClassName("selected1")[0];
                } else {
                    document.getElementsByClassName("selected2")[0].selected = true;
                    var tes = document.getElementsByClassName("selected2")[0];
                }
            } else {
                document.getElementsByClassName('selected0')[0].selected = "true";
            } 
            var schedule = $("#schedule_id");
            var scheduleVal = schedule.val();
            var hasSchedule = $('option:selected', schedule).attr('data-has-schedule');
            var onePerson = onePrice;
            var twoPerson = twoPrice;
            var option1 = '<option class="options" value="1">1 Orang Rp. ' + Intl.NumberFormat('de-DE')
                .format(onePerson) +
                '</option>';
            var option2 = '<option class="options" value="2">2 Orang Rp. ' + Intl.NumberFormat('de-DE')
                .format(twoPerson) +
                '</option>';
            var rp = 'Rp. '
            if (onePerson > 0 && twoPerson > 0) {
                $('#total-peserta').show();
                $("#total option").each(function() {
                    $(this).remove();
                });
                $('#total').append(option1 + option2);
                $('#spanHargaNormal').empty();
                $('#spanHargaNormal').append(rp + Intl.NumberFormat('de-DE').format(onePerson * 2))
                $('#spanHarga').empty();
                $('#spanHarga').append(rp + Intl.NumberFormat('de-DE').format(onePerson));
                $('p.harga_normal').removeClass('d-none');
                $('p.hari_ini').removeClass('d-none');
                $('p.khusus50pendaftar').removeClass('d-none');
            } else {
                $('#div-seminar').hide();
                $('#total-peserta').hide();
                $('#spanHargaNormal').empty();
                $('#spanHarga').empty();
            }

            const quantityTarget = $('.' + id).val();
            var data = $('#total').find('.options');
            var lengths = data.length;
            for (i = 0; i < lengths; i++) {
                var dataFix = data[i];
                if (quantityTarget == 1) {
                    data[0].selected = true;
                } else {
                    data[1].selected = true;
                }
            }

            var option = $('.listSeminar');
            var length = option.length; 
            for (i = 0; i < length; i++) {
                var data = $(option[i]).val();
                if (data == id) {
                    var dataOption = $(option[i]).attr("selected", "selected");
                }
            }

            $('.time-and-place').attr("readonly",true);
            $('.total-peserta').attr("readonly",true);
            $('.seminar-type').attr("readonly",true);
        }
    </script>
@endsection --}}
@section('content')
    <section class="engine"></section>
    <section class="mbr-section form1 cid-r0cvZz9cCa" id="form1-p">
        <div class="container">
            <div class="row my-5">
                <div class="col-12 text-center mb-5">
                    <h2 class="font-weight-bold" id="title">Pendaftaran Seminar</h2>
                </div>
                <div class="col-12 text-center mt-3">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6 col-sm-12">
                            <div class="image-vektor">
                                <img src="https://importir.org/images/seminar-org/vektor.png" class="img-fluid"
                                    alt="Responsive image" id="image-vektor-pendaftaran" data-aos="zoom-out">
                            </div>
                        </div>
                        <div class="col-6 col-md-6 col-lg-6 col-sm-12 button-register">
                            <div class="row mt-5">
                                <div class="col-12 col-md-12 col-lg-12 col-sm-12 mt-5 ">
                                    <a href="#" data-toggle="modal" data-target="#modalFormulirPendaftaran"
                                        class="btn display-3 button-trigger daftar-default"
                                        style="background-color: #289FDC; color: black; border-radius: 12px" onclick="daftarDefault()">Daftar Sekarang
                                    </a>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12 col-sm-12 text-center">
                                    <a href="javascript:scrollToJadwal()"
                                        style="background-color: white; color: #5d5d5d; border:2px solid #5d5d5d; border-radius: 12px"
                                        class="btn btn-default btn-form display-3 button-trigger">Lihat jadwal
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-center mt-5">
                    <div class="filters">
                        <form method="GET" id="formFilter">
                            <div id="box-ticket" style="background-color: #F6F7F8; padding:20px; border-radius:10px">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-1 mb-1 mt-2">
                                        <span style="font-size: 14px; margin-top:10px;" id="totalEvent">0 EVENT</span>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-4 mb-1">
                                        <div class="input-group mb-3">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2" style="font-size: 12px;" >Seminar Type</span>
                                            </div>
                                            <select name="seminar_type" class="form-control" onchange="searchFilter()" style="font-size: 12px;">
                                                <option value="seminar">Seminar (Offline)</option>
                                                <option value="webinar">Webinar (Online)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12  col-sm-12 col-md-12 col-lg-4 mb-1">
                                        <div class="input-group mb-3">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2" style="font-size: 12px;">Event Date</span>
                                            </div>
                                            <input type="date" class="form-control" name="date" value=""
                                            onchange="searchFilter()" style="font-size: 12px;">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-3">
                                        <div class="input-group mb-3">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2" style="font-size: 12px;">Filter By</span>
                                            </div>
                                            <select name="city" onchange="searchFilter()" class="form-control" style="font-size: 12px;">
                                                <option value="">City</option>
                                                {{-- @foreach ($selectCity as $city)
                                                    <option value="{{ $city->city }}"
                                                        {{ isset($filters) && $filters['city'] == $city->city ? 'selected' : '' }}>
                                                        {{ $city->city }}
                                                    </option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>
    <section class="timeline1 cid-r0cvPVgZ0c" id="timeline1-o" style="background-color: #FFFF">
        <div class="container" id="jadwal">
            <div class="col-md-12" id="post-data">
                {{-- @foreach ($seminar as $key => $item) --}}
                <div class="box">
                    <div class="row">
                        <div class="col-12">
                            <div class="card-ticket" data-aos="zoom-in-down">
                                <div class="circle1"></div>
                                <div class="row mt-1">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12 col-md-3 col-sm-12">
                                                <div class="row">
                                                    <div class="col-12 col-md-12 col-sm-12 locations">
                                                        <div class="row">
                                                            <div class="col-2">
                                                                <img class="location"
                                                                    src="{{ asset('images/seminar-org/map.png') }}"
                                                                    src="#"
                                                                    alt="Location">
                                                            </div>
                                                            <div class="col-10">
                                                                <span class="city text-left">jakarta</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-sm-4">
                                                <div class="row text-center">
                                                    <div class="col-6 col-lg-6 col-md-6 col-sm-6">
                                                        <div class="row border-right">
                                                            <div class="col-12 col-md-12  col-sm-12">
                                                                <span class="label">Date</span>
                                                            </div>
                                                            <div class="col-12 col-md-12  col-sm-12">
                                                                <span
                                                                    class="date-hours">{{ date('d M', strtotime(now())) }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-md-6 col-sm-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <span class="label">Hour</span>
                                                            </div>
                                                            <div class="col-12">
                                                                <span
                                                                    class="date-hours">{{ date('H:i', strtotime(now())) }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="circle-responsive1"></div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="circle-responsive2"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4" data-quantity-all="">
                                    <div class="col-12 col-md-3 col-sm-3">
                                        <div class="row">
                                            <div class="col-6 col-md-12 col-sm-12 ">
                                                <div class="col-12 col-md-12 col-sm-12">
                                                    <div class="quantity-control" data-quantity="">
                                                        <button class="quantity-btn" data-quantity-minus=""  onclick="dataQuantityMinus({{1}}, {{2}})"><svg
                                                                viewBox="0 0 409.6 409.6">
                                                                <g>
                                                                    <g>
                                                                        <path
                                                                            d="M392.533,187.733H17.067C7.641,187.733,0,195.374,0,204.8s7.641,17.067,17.067,17.067h375.467 c9.426,0,17.067-7.641,17.067-17.067S401.959,187.733,392.533,187.733z" />
                                                                    </g>
                                                                </g>
                                                            </svg></button>
                                                        <input type="number" class="quantity-input {{ 1 }}" onkeyup="dataQuantityKeyup({{1}}, {{100000}}, {{150000}})"
                                                            data-quantity-target="" value="1" step="0.1" min="1" max=""
                                                            name="quantity">
                                                            {{-- {{ (isset($filters) && $filters['city'] != null) || $filters['date'] != null || $filters['seminar_type'] != null ? 'autofocus' : '' }}> --}}
                                                        <button class="quantity-btn" data-quantity-plus="" onclick="dataQuantityPlus({{1}}, {{100000}})"><svg
                                                                viewBox="0 0 426.66667 426.66667">
                                                                <path
                                                                    d="m405.332031 192h-170.664062v-170.667969c0-11.773437-9.558594-21.332031-21.335938-21.332031-11.773437 0-21.332031 9.558594-21.332031 21.332031v170.667969h-170.667969c-11.773437 0-21.332031 9.558594-21.332031 21.332031 0 11.777344 9.558594 21.335938 21.332031 21.335938h170.667969v170.664062c0 11.777344 9.558594 21.335938 21.332031 21.335938 11.777344 0 21.335938-9.558594 21.335938-21.335938v-170.664062h170.664062c11.777344 0 21.335938-9.558594 21.335938-21.335938 0-11.773437-9.558594-21.332031-21.335938-21.332031zm0 0" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-sm-12">
                                                <span class="total-price  total-price-js{{1}}" data-price="">
                                                    Rp.{{ number_format(100000) }}
                                                </span>
                                                <span style="display:none" data-one-price="">
                                                    {{ number_format(100000) }}
                                                </span>
                                                <span style="display:none" data-two-price="">
                                                    {{ number_format(150000) }}
                                                </span>
                                            </div>
                                            <div class="col-12 col-md-12 col-sm-12">
                                                <button data-toggle="modal" data-target="#modalFormulirPendaftaran"
                                                    class="daftar" 
                                                    onclick="daftar({{1}},{{1}},{{100000}},{{150000}})">Daftar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 col-sm-4">
                                        <span class="invest-detail">
                                            <p>2 Orang Rp 200.000,-</p>

                                            <p>On the spot ( Bayar di tempat ): Rp 300.000,-</p>
                                        </span>
                                    </div>
                                    <div class="col-12 col-md-4 sol-sm-4 text-left desc">
                                        <span class="address">
                                            <p>Sabtu, 28&nbsp;Mei 2022<br>
                                                Seminar&nbsp;: Pukul 14.00 WIB - Selesai&nbsp;</p>
                                                
                                            <p>Jl. Teuku Moh. Daud Beureueh No.5, Laksana, Kec. Kuta Alam, Kota Banda Aceh, Aceh 24415</p>
                                        </span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-12 col-sm-12">
                                        <span class="note-seminar">Pastikan data yang kamu isi sudah BENAR Tiket ini tidak
                                            dapat di REFUND dan tidak dapat di Reschedule</span>
                                    </div>
                                </div>
                                <div class="circle2"></div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- @endforeach --}}
            </div>
            <div class="ajax-load text-center" style="display: none">
                {{-- <p><img src="{{ asset('images/seminar-org/preloader.gif') }}" alt="loading" width="80px" ></p> --}}
                <p><img src="#" alt="loading" width="80px" ></p>
            </div>
            {{-- @if (isset($filters) && $filters['city'] !== null ||  $filters['date'] != null || $filters['seminar_type'] != null ) --}}
            {{-- <div class="button-load text-center">
                <button onclick="loadMoreButtonFilter()" style="background-color: #FFD600; width:250px; padding:10px 10px; border:none; border-radius:10px;">Load More</button>
            </div> --}}
            {{-- @else --}}
            <div class="button-load text-center">
                <button onclick="loadMoreButton()" style="background-color: #289FDC; width:250px; padding:10px 10px; border:none; border-radius:10px;">Load More</button>
            </div>
            {{-- @endif --}}
          
        </div>
    </section>

    {{-- Modal --}}
    $
@endsection
