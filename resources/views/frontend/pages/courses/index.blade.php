@extends('frontend.layouts.master')

@section('content')
    <!--===========================
        BREADCRUMB START
    ============================-->
    <section class="wsus__breadcrumb" style="background: url({{ asset('frontend/assets/images/breadcrumb_bg.jpg') }});"> {{-- Path asset untuk gambar background --}}
        <div class="wsus__breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12 wow fadeInUp">
                        <div class="wsus__breadcrumb_text">
                            <h1>Our Courses</h1>
                            <ul>
                                <li><a href="{{ route('frontend.index') }}">Home</a></li> {{-- Route ke homepage --}}
                                <li>Our Courses</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--===========================
        BREADCRUMB END
    ============================-->


    <!--===========================
        COURSES PAGE START
    ============================-->
    <section class="wsus__courses mt_120 xs_mt_100 pb_120 xs_pb_100">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-8 order-2 order-lg-1 wow fadeInLeft">
                    <div class="wsus__sidebar">
                        <form action="#"> {{-- Form filter, action bisa di sesuaikan --}}
                            <div class="wsus__sidebar_search">
                                <input type="text" placeholder="Search Course"> {{-- Input search, perlu di handle di controller --}}
                                <button type="submit">
                                    <img src="{{ asset('frontend/assets/images/search_icon.png') }}" alt="Search" class="img-fluid"> {{-- Path asset untuk gambar search icon --}}
                                </button>
                            </div>

                            <div class="wsus__sidebar_category">
                                <h3>Categories</h3>
                                <ul class="categoty_list">
                                    @foreach($categories as $category) {{-- Loop kategori --}}
                                        <li class="">{{ $category->name }} {{-- Nama Kategori --}}
                                            @if($category->children->count() > 0) {{-- Cek jika ada subkategori --}}
                                            <div class="wsus__sidebar_sub_category">
                                                @foreach($category->children as $subcategory) {{-- Loop subkategori --}}
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="flexCheckDefaultc{{ $subcategory->id }}"> {{-- ID checkbox unik --}}
                                                    <label class="form-check-label" for="flexCheckDefaultc{{ $subcategory->id }}">
                                                        {{ $subcategory->name }} {{-- Nama Subkategori --}}
                                                    </label>
                                                </div>
                                                @endforeach
                                            </div>
                                            @endif
                                        </li>
                                    @endforeach
                                    {{-- ... (List kategori statis di hapus dan diganti loop blade) ... --}}
                                </ul>
                            </div>
                            <div class="wsus__sidebar_course_lavel duration">
                                <h3>Duration</h3>
                                <div class="form-check">
                                    <input class="form-check-input duration-filter" type="checkbox" value="0-60" id="duration-0-60" {{ request('duration') == '0-60' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="duration-0-60">
                                        Up to 1 Hour
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input duration-filter" type="checkbox" value="60-180" id="duration-60-180" {{ request('duration') == '60-180' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="duration-60-180">
                                        1 - 3 Hours
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input duration-filter" type="checkbox" value="180-300" id="duration-180-300" {{ request('duration') == '180-300' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="duration-180-300">
                                        3 - 5 Hours
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input duration-filter" type="checkbox" value="300-999999" id="duration-300-above" {{ request('duration') == '300-999999' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="duration-300-above">
                                        5+ Hours
                                    </label>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8 order-lg-1">
                    <div class="wsus__page_courses_header wow fadeInUp">
                        <p>Showing <span>{{ $courses->firstItem() }}-{{ $courses->lastItem() }}</span> Of <span>{{ $courses->total() }}</span> Results</p> {{-- Pagination info --}}
                        <form action="#"> {{-- Form sort by, action bisa di sesuaikan --}}
                            <p>Sort-by:</p>
                            <select class="select_js"> {{-- Select box sort by, perlu implementasi js dan backend --}}
                                <option value="">Regular</option>
                                <option value="">Top Rated</option>
                                <option value="">Popular Courses</option>
                                <option value="">Recent Courses</option>
                            </select>
                        </form>
                    </div>
                    <div class="row">
                        @foreach($courses as $course) {{-- Loop courses --}}
                        <div class="col-xl-4 col-md-6 wow fadeInUp">
                            <div class="wsus__single_courses_3">
                                <div class="wsus__single_courses_3_img">
                                    <img src="{{ Storage::url($course->thumbnail) }}" alt="Courses" class="img-fluid"> {{-- Gambar thumbnail kursus --}}

                                    @php
                                        $totalDuration = 0;
                                        foreach($course->videos as $video){
                                            $totalDuration += $video->duration; // Asumsi duration dalam menit
                                        }
                                    @endphp
                                    <span class="time"><i class="far fa-clock"></i> {{ floor($totalDuration / 60) }}:{{ str_pad($totalDuration % 60, 2, '0', STR_PAD_LEFT) }} Hours</span> {{-- Total durasi kursus --}}
                                </div>
                                <div class="wsus__single_courses_text_3">
                                    <div class="rating_area">
                                        <p class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <span>(4.8 Rating)</span> {{-- Rating statis, perlu data rating dinamis --}}
                                        </p>
                                    </div>

                                    <a class="title" href="{{ route('frontend.pages.course-detail', $course->slug) }}">{{ $course->name }}</a> {{-- Judul kursus dan link ke detail kursus --}}
                                    <ul>
                                        <li>{{ $course->videos_count }} Lessons</li> {{-- Jumlah lessons --}}
                                        <li>{{ $course->employees_count }} Student</li> {{-- Jumlah students --}}
                                    </ul>
                                    <a class="author" href="#">
                                        <div class="img">
                                            <img src="{{ Storage::url($course->teacher->user->avatar) }}" alt="Author" class="img-fluid"> {{-- Avatar guru --}}
                                        </div>
                                        <h4>{{ $course->teacher->user->name ?? 'Teacher Name' }}</h4> {{-- Nama guru --}}
                                    </a>
                                </div>
                                <div class="wsus__single_courses_3_footer">
                                    <a class="common_btn" href="{{ route('frontend.pages.course-detail', $course->slug) }}">Enroll <i class="far fa-arrow-right"></i></a> {{-- Link enroll ke detail kursus --}}
                                    {{-- Harga di hapus --}}
                                </div>
                            </div>
                        </div>
                        @endforeach
                        {{-- ... (Course card statis di hapus dan diganti loop blade) ... --}}
                    </div>
                    <div class="wsus__pagination mt_50 wow fadeInUp">
                        {{ $courses->links() }} {{-- Tampilkan link pagination --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--===========================
        COURSES PAGE END
    ============================-->
@endsection
