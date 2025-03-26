    <!--===========================
        FOOTER 3 START
    ============================-->
    <footer class="footer_3" style="background: url({{ asset('frontend/assets/images/footer_3_bg.jpg') }});">
        <div class="footer_3_overlay pt_120 xs_pt_100">
            <div class="wsus__footer_bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="wsus__footer_3_logo_area">
                                <a class="logo" href="{{ url('/') }}">
                                    <img src="{{ asset('frontend/assets/images/logo.png') }}" alt="logo">
                                </a>
                                <p>Temukan berbagai kursus menarik untuk mengembangkan potensi Anda bersama Taharica.</p>
                                <h2>Ikuti Kami</h2>
                                <ul class="d-flex flex-wrap">
                                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                    <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3 wow fadeInUp" data-wow-delay="0.2s">
                            <div class="wsus__footer_link">
                                <h2>Kursus Populer</h2>
                                <ul>
                                    @foreach($categories as $category)
                                        <li><a href="{{ route('frontend.pages.category', $category->slug) }}">{{ $category->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-md-3 wow fadeInUp" data-wow-delay="0.3s">
                            <div class="wsus__footer_link">
                                <h2>Program Unggulan</h2>
                                <ul>
                                    @foreach($categories->take(5) as $category) {{-- Menampilkan 5 kategori pertama sebagai contoh program unggulan --}}
                                        <li><a href="{{ route('frontend.pages.category', $category->slug) }}">{{ $category->name }}</a></li>
                                    @endforeach
                                    <li><a href="{{ route('frontend.pages.category') }}">Lihat Semua Program</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                            <div class="wsus__footer_3_subscribe">
                                <h3>Langganan Newsletter Kami</h3>
                                <p>Dapatkan informasi terbaru mengenai kursus dan promo menarik dari Taharica langsung ke email Anda.</p>
                                <form id="subscribe-form">
                                    <input type="email" id="subscriber_email" placeholder="Masukkan Email Anda" required>
                                    <button type="submit" class="common_btn">Berlangganan</button>
                                </form>
                                <div id="subscribe-message" class="mt-2" style="display: none;"></div>
                                <ul>
                                    <li>
                                        <div class="icon">
                                            <img src="{{ asset('frontend/assets/images/call_icon_white.png') }}" alt="Call" class="img-fluid">
                                        </div>
                                        <div class="text">
                                            <h4>Hubungi Kami:</h4>
                                            <a href="tel:+6281234567890">+62 812 3456 7890</a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="icon">
                                            <img src="{{ asset('frontend/assets/images/location_icon_white.png') }}" alt="Location" class="img-fluid">
                                        </div>
                                        <div class="text">
                                            <h4>Kantor Pusat:</h4>
                                            <p>
                                                <a href="https://www.google.com/maps/place/Jl.+Radin+Inten+II+No.62,+RT.6%2FRW.14,+Duren+Sawit,+Kec.+Duren+Sawit,+Kota+Jakarta+Timur,+Daerah+Khusus+Ibukota+Jakarta+13440" target="_blank">
                                                    Jl. Radin Inten II No.62,<br>
                                                    RT.6/RW.14, Duren Sawit,<br>
                                                    Kota Jakarta Timur, DKI Jakarta 13440
                                                </a>
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wsus__footer_copyright_area mt_140 xs_mt_100">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="wsus__footer_copyright_text">
                                <p>Copyright © {{ date('Y') }} All Rights Reserved by Taharica Education</p>
                                <ul>
                                    <li><a>Kebijakan Privasi</a></li>
                                    <li><a>Syarat & Ketentuan</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--===========================
        FOOTER 3 END
    ============================-->
