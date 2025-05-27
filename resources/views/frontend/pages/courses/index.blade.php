@extends('frontend.layouts.master')

@section('content')
    <!--===========================
                BREADCRUMB START
            ============================-->
    <section class="wsus__breadcrumb" style="background: url({{ asset('frontend/assets/images/breadcrumb_bg.jpg') }});">
        {{-- Path asset untuk gambar background --}}
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
                                    <img src="{{ asset('frontend/assets/images/search_icon.png') }}" alt="Search"
                                        class="img-fluid"> {{-- Path asset untuk gambar search icon --}}
                                </button>
                            </div>

                            <div class="wsus__sidebar_category">
                                <h3>Categories</h3>
                                <ul class="categoty_list">
                                    @foreach ($categories as $category)
                                        <li class="category-list">
                                            {{-- Parent Category Checkbox --}}
                                            <div class="form-check category-parent">
                                                <input class="form-check-input category-filter" type="checkbox"
                                                    value="{{ $category->id }}" id="category_{{ $category->id }}"
                                                    {{ in_array($category->id, $selectedCategories ?? []) ? 'checked' : '' }}>
                                                <label class="form-check-label parent-label"
                                                    for="category_{{ $category->id }}">
                                                    <strong>{{ $category->name }}</strong>
                                                    @if ($category->courses_count > 0)
                                                        <span class="course-count">({{ $category->courses_count }})</span>
                                                    @endif
                                                </label>
                                            </div>

                                            {{-- Subcategories --}}
                                            @if ($category->children->count() > 0)
                                                <div class="wsus__sidebar_sub_category">
                                                    @foreach ($category->children as $subcategory)
                                                        <div class="form-check subcategory-item">
                                                            <input class="form-check-input subcategory-filter"
                                                                type="checkbox" value="{{ $subcategory->id }}"
                                                                data-parent="{{ $category->id }}"
                                                                id="subcategory_{{ $subcategory->id }}"
                                                                {{ in_array($subcategory->id, $selectedCategories ?? []) ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="subcategory_{{ $subcategory->id }}">
                                                                {{ $subcategory->name }}
                                                                @if ($subcategory->courses_count > 0)
                                                                    <span
                                                                        class="course-count">({{ $subcategory->courses_count }})</span>
                                                                @endif
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>

                                {{-- Clear Filters Button --}}
                                <div class="filter-actions mt-3">
                                    <button type="button" class="btn btn-sm btn-outline-secondary"
                                        onclick="clearAllFilters()">
                                        Clear All Filters
                                    </button>
                                </div>
                            </div>


                            <div class="wsus__sidebar_course_lavel duration">
                                <h3>Duration</h3>
                                <div class="form-check">
                                    <input class="form-check-input duration-filter" type="checkbox" value="0-60"
                                        id="duration-0-60" {{ request('duration') == '0-60' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="duration-0-60">
                                        Up to 1 Hour
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input duration-filter" type="checkbox" value="60-180"
                                        id="duration-60-180" {{ request('duration') == '60-180' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="duration-60-180">
                                        1 - 3 Hours
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input duration-filter" type="checkbox" value="180-300"
                                        id="duration-180-300" {{ request('duration') == '180-300' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="duration-180-300">
                                        3 - 5 Hours
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input duration-filter" type="checkbox" value="300-999999"
                                        id="duration-300-above" {{ request('duration') == '300-999999' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="duration-300-above">
                                        5+ Hours
                                    </label>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8 order-lg-1">
                
                    <div class="row">
                        @foreach ($courses as $course)
                            {{-- Loop courses --}}
                            <div class="col-xl-4 col-md-6 wow fadeInUp">
                                <div class="wsus__single_courses_3">
                                    <div class="wsus__single_courses_3_img">
                                        <img src="{{ Storage::url($course->thumbnail) }}" alt="Courses" class="img-fluid">
                                        {{-- Gambar thumbnail kursus --}}

                                        @php
                                            $totalDuration = 0;
                                            foreach ($course->videos as $video) {
                                                $totalDuration += $video->duration; // Asumsi duration dalam menit
                                            }
                                        @endphp
                                        <span class="time"><i class="far fa-clock"></i>
                                            {{ floor($totalDuration / 60) }}:{{ str_pad($totalDuration % 60, 2, '0', STR_PAD_LEFT) }}
                                            Hours</span> {{-- Total durasi kursus --}}
                                    </div>
                                    <div class="wsus__single_courses_text_3">

                                        <a class="title"
                                            href="{{ route('frontend.pages.course-detail', $course->slug) }}">{{ $course->name }}</a>
                                        {{-- Judul kursus dan link ke detail kursus --}}
                                        <ul>
                                            <li>{{ $course->videos_count }} Lessons</li> {{-- Jumlah lessons --}}
                                            <li>{{ $course->employees_count }} Student</li> {{-- Jumlah students --}}
                                        </ul>
                                        <a class="author" href="#">
                                            <div class="img">
                                                <img src="{{ Storage::url($course->teacher->user->avatar) }}"
                                                    alt="Author" class="img-fluid"> {{-- Avatar guru --}}
                                            </div>
                                            <h4>{{ $course->teacher->user->name ?? 'Teacher Name' }}</h4>
                                            {{-- Nama guru --}}
                                        </a>
                                    </div>
                                    <div class="wsus__single_courses_3_footer">
                                        <a class="common_btn"
                                            href="{{ route('frontend.pages.course-detail', $course->slug) }}">Enroll <i
                                                class="far fa-arrow-right"></i></a> {{-- Link enroll ke detail kursus --}}

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
