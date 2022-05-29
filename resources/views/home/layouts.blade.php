<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <title>@yield('title','SIMINAR')</title>
    <link rel="stylesheet" href="{{ url('v2/assets/web/assets/mobirise-icons/mobirise-icons.css') }}">
    <link rel="stylesheet" href="{{ url('v2/assets/tether/tether.min.css') }}">
    <link rel="stylesheet" href="{{ url('v2/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('v2/assets/bootstrap/css/bootstrap-grid.min.css') }}">
    <link rel="stylesheet" href="{{ url('v2/assets/bootstrap/css/bootstrap-reboot.min.css') }}">
    <link rel="stylesheet" href="{{ url('v2/assets/dropdown/css/style.css') }}">
    <link rel="stylesheet" href="{{ url('v2/assets/socicon/css/styles.css') }}">
    <link rel="stylesheet" href="{{ url('v2/assets/theme/css/style.css') }}">
    <link rel="stylesheet" href="{{ url('v2/assets/gallery/style.css') }}">
    <link rel="stylesheet" href="{{ url('v2/assets/mobirise/css/mbr-additional.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('assets/css/lookup-invoice.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('adminlte/bower_components/select2/dist/css/select2.css?v=1.1') }}">
    @yield('css')
    @yield('js-head')
    <style>
        .help-block{
            color: red;
        }

        #cLoadingMsg {
        color: black;
        padding: 10px;
        position: fixed;
        top: 50%;
        left: 50%;
        z-index: 100;
        margin-right: -25%;
        margin-bottom: -25%;
        }

        #cLoadingOver {
        background: black;
        z-index: 99;
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        left: 0;
        -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=80)";
        filter: alpha(opacity=80);
        -moz-opacity: 0.8;
        -khtml-opacity: 0.8;
        opacity: 0.8;
        }
        
        .cloader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid blue;
            border-bottom: 16px solid blue;
            width: 3.5rem;
            height: 3.5rem;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>


<!--End of Tawk.to Script-->
<section class="menu cid-r08Nf6kuzj" once="menu" id="menu2-0">
    <nav class="navbar navbar-expand beta-menu navbar-dropdown align-items-center navbar-fixed-top navbar-toggleable-sm">
        <div class="menu-logo">
            <div class="navbar-brand">
                <span class="navbar-logo">
                    <h1 style="color:white">SIMINAR</h1>
                    {{-- <img src="{{ url('v2/assets/images/logo-org-529x108.png') }}" alt="Importir.org" title="" style="height: 3.8rem;"> --}}
                </span>
            </div>
        </div>
    </nav>
</section>

@yield('content')
<div id="cLoadingMsg" style="display: none">
    <div class="cloader"></div>
</div>
<div id="cLoadingOver" style="display: none;"></div>



<section class="cid-r0d09SJ9tT" id="footer2-1n">
    <div class="container">
        <div class="media-container-row content mbr-white">
            <div class="col-12 col-md-3 mbr-fonts-style display-7">
                <p class="mbr-text">
                    <br><strong>Contacts</strong>
                    <br>
                    <br>02155715045&nbsp;
                    <br>02122052769&nbsp;<br></p>
            </div>
            <div class="col-12 col-md-3 mbr-fonts-style display-7">
                <p class="mbr-text">
                    <br>Address China
                    <br>Guangzhou Baiyun District, Longhu Village, Longhu East One Road, Number 19</p>
                <br>Gudang Jakarta
                <br>
                <br>Pergudangan 3 Multi Gudang Jalan Manis Raya Bitung, Tangerang, Cikupa Blok B1</p>
            </div>
            <div class="col-12 col-md-6">
                <div class="google-map"><iframe frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key={{ env('GOOGLE_MAP_KEY') }}&amp;q=place_id:ChIJB3gJDcf5aS4RNVlVjAC_ihw" allowfullscreen=""></iframe></div>
            </div>
        </div>
        <div class="footer-lower">
            <div class="media-container-row">
                <div class="col-sm-12">
                    <hr>
                </div>
            </div>
            <div class="media-container-row mbr-white">
                <div class="col-sm-6 copyright">
                    <p class="mbr-text mbr-fonts-style display-7">
                        <a href="{{ url('') }}">Home </a>- <a href="{{ url('pendaftaran') }}">Pendaftaran</a> - <a href="{{ url('testimonial') }}">Testimonial </a>- <a href="{{ url('goes-to-china') }}">Goes2China </a>- <a href="{{ url('about-us') }}">Warehouse China</a>- <a href="{{ url('hub-kami') }}">Contact</a>- <a href="{{ url('content/term-and-condition') }}">Terms & Condition</a></p>
                </div>
                <div class="col-md-6">
                    <div class="social-list align-right">
                        <div class="soc-item">
                            <a href="https://id-id.facebook.com/importir.org/" target="_blank">
                                <span class="socicon-facebook socicon mbr-iconfont mbr-iconfont-social"></span>
                            </a>
                        </div>
                        <div class="soc-item">
                            <a href="https://www.youtube.com/channel/UCm82ZIloMS7lzlqqy2VUgVA" target="_blank">
                                <span class="socicon-youtube socicon mbr-iconfont mbr-iconfont-social"></span>
                            </a>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- Modal -->
<div id="annual-off" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Hari Libur untuk Customer Service</h4>
            </div>
            <div class="modal-body">
                Hallo, kami mohon maaf untuk hari ini ({{ date("Y-m-d") }} Customer Service kami libur hingga hari senin 24 September 2018.
                <p>
                    Untuk melakukan transakaksi/pendaftaran seminar dapat berjalan sesuai biasa. Terimakasih
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="{{ url('v2/assets/web/assets/jquery/jquery.min.js') }}"></script>
<script src="{{ url('v2/assets/popper/popper.min.js') }}"></script>
<script src="{{ url('v2/assets/tether/tether.min.js') }}"></script>
<script src="{{ url('v2/assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ url('v2/assets/smoothscroll/smooth-scroll.js') }}"></script>
<script src="{{ url('v2/assets/dropdown/js/script.min.js') }}"></script>
<script src="{{ url('v2/assets/touchswipe/jquery.touch-swipe.min.js') }}"></script>
<script src="{{ url('v2/assets/playervimeo/vimeo_player.js') }}"></script>
<script src="{{ url('v2/assets/vimeoplayer/jquery.mb.vimeo_player.js') }}"></script>
<script src="{{ url('v2/assets/masonry/masonry.pkgd.min.js') }}"></script>
<script src="{{ url('v2/assets/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ url('v2/assets/bootstrapcarouselswipe/bootstrap-carousel-swipe.js') }}"></script>
<script src="{{ url('v2/assets/viewportchecker/jquery.viewportchecker.js') }}"></script>
<script src="{{ url('v2/assets/parallax/jarallax.min.js') }}"></script>
<script src="{{ url('v2/assets/ytplayer/jquery.mb.ytplayer.min.js') }}"></script>
<script src="{{ url('v2/assets/theme/js/script.js') }}"></script>
<script src="{{ url('v2/assets/slidervideo/script.js') }}"></script>
<script src="{{ url('v2/assets/gallery/player.min.js') }}"></script>
<script src="{{ url('v2/assets/gallery/script.js?v=1.0.0') }}"></script>
<script src="{{ url('adminlte/bower_components/select2/dist/js/select2.js?v=0.1') }}"></script>
@yield('js')

</body>
</html>
