<!--===========================
    TENTANG PLATFORM PEMBELAJARAN - START
============================-->
<section class="wsus__about_3 mt_120 xs_mt_100 "> <!-- Mungkin ganti kelas CSS jika 'about_3' terlalu generik -->
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-6 wow fadeInLeft">
                <div class="wsus__about_3_img"> <!-- Ganti nama kelas jika perlu -->

                        <img src={{ asset("frontend/assets/images/about_3_img_1.png") }} alt="About us" class="about_3_large img-fluid w-100">

                    <!-- Sesuaikan teks ini -->
                    <div class="text">
                        <h4> <span>Fokus</span> Pengembangan Kompetensi Anda</h4>
                        <!-- Ganti gambar avatar generik dengan ikon skill atau logo Taharica (jika diizinkan) -->
                        <img src={{ asset("frontend/assets/images/banner_2_photo_list.png") }} alt="Ikon Pengembangan Skill Karyawan" class="img-fluid">
                    </div>

                    <!-- Sesuaikan teks melingkar -->
                    <div class="circle_box">
                        <svg viewBox="0 0 100 100">
                            <defs>
                                <path id="circle2" d="
                        M 50, 50
                        m -37, 0
                        a 37,37 0 1,1 74,0
                        a 37,37 0 1,1 -74,0"></path>
                            </defs>
                            <text>
                                <textPath xlink:href="#circle2"> <!-- Pastikan href menunjuk ke ID path yang benar -->
                                    Tingkatkan skill & adaptasi bersama PT Taharica Jakarta
                                </textPath>
                            </text>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInRight">
                <div class="wsus__about_3_text"> <!-- Ganti nama kelas jika perlu -->
                    <div class="wsus__section_heading heading_left mb_15">
                        <!-- Sesuaikan Heading -->
                        <h5>Platform Pembelajaran Internal</h5>
                        <h2>Tingkatkan Kompetensi Anda Bersama PT Taharica Jakarta</h2>
                    </div>
                    <!-- Sesuaikan Paragraf -->
                    <p>Selamat datang di portal e-learning PT Taharica! Platform ini dirancang khusus untuk mendukung pengembangan kompetensi Anda agar lebih adaptif terhadap dinamika industri. Akses video pembelajaran dan modul interaktif kapan saja, di mana saja.</p>
                    <!-- Sesuaikan Poin Utama dengan Manfaat Konkret -->
                    <ul>
                        <li>Materi Relevan dengan Kebutuhan Industri & Perusahaan</li>
                        <li>Belajar Fleksibel Sesuai Jadwal Anda</li>
                        <li>Konten Interaktif (Video, Kuis - Dalam Pengembangan)</li>
                    </ul>
                    <!-- Sesuaikan Tombol Aksi -->
                    <a class="common_btn" href={{ route('register') }}'>Mulai Belajar</a> <!-- Arahkan ke login atau katalog kursus -->

                </div>
            </div>
        </div>
    </div>
</section>
<!--===========================
    TENTANG PLATFORM PEMBELAJARAN - END
============================-->
