  <!--===========================
        COUESES 3 START
    ============================-->
    <section class="wsus__courses_3 pt_120 xs_pt_100 mt_120 xs_mt_90 pb_120 xs_pb_100">
        <div class="container">

            <div class="row">
                <div class="col-xl-6 m-auto wow fadeInUp">
                    <div class="wsus__section_heading mb_45">
                        <h5>Featured Courses</h5>
                        <h2>Latest Bundle Courses.</h2>
                    </div>
                </div>
            </div>

            <div class="row wow fadeInUp">
                <div class="col-xxl-6 col-xl-8 m-auto">
                    <div class="wsus__filter_area mb_15">
                        <ul class="nav nav-pills justify-content-center" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                    aria-selected="true">All Courses</button>
                            </li>
                            @foreach($categories as $category)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-{{ Str::slug($category->name) }}-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-{{ Str::slug($category->name) }}" type="button" role="tab"
                                    aria-controls="pills-{{ Str::slug($category->name) }}" aria-selected="false">{{ $category->name }}</button>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                    tabindex="0">
                    <div class="row">
                        @foreach($courses as $course)
                        @php
                            $totalDuration = 0;
                            foreach($course->videos as $video){
                                $totalDuration += $video->duration; // Asumsi duration dalam menit
                            }
                        @endphp
                        <div class="col-xl-3 col-md-6 col-lg-4">
                            <div class="wsus__single_courses_3">
                                <div class="wsus__single_courses_3_img">
                                    <img src="{{ Storage::url($course->thumbnail) }}" class="card-img-top rounded-top" alt="thumbnail" style="height: 200px; object-fit: cover;">
                                    <span class="time"><i class="far fa-clock"></i>
                                        {{ floor($totalDuration / 60) }}:{{ str_pad($totalDuration % 60, 2, '0', STR_PAD_LEFT) }} Minutes
                                    </span>
                                    </div>
                                <div class="wsus__single_courses_text_3">
                                    <a class="title" href="{{ route('frontend.pages.course-detail', $course->slug) }}">{{ $course->name }}</a>
                                    <ul>
                                        <li>{{ $course->videos_count }} Lessons</li>
                                        <li>{{ $course->employees_count }} Student</li>
                                    </ul>
                                    <a class="author" href="#">
                                        <div class="img">
                                            <img src="{{ Storage::url($course->teacher->user->avatar) }}" class="w-100 h-100 object-cover" alt="icon">
                                        </div>
                                        <h4>{{ $course->teacher->user->name ?? 'Teacher Name' }}</h4>
                                    </a>
                                </div>
                                <div class="wsus__single_courses_3_footer">
                                    <a class="common_btn" href="{{ route('frontend.pages.course-detail', $course->slug) }}">Enroll <i class="far fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @foreach($categories as $category)
                <div class="tab-pane fade" id="pills-{{ Str::slug($category->name) }}" role="tabpanel" aria-labelledby="pills-{{ Str::slug($category->name) }}-tab"
                    tabindex="0">
                    <div class="row">
                        @foreach($category->courses as $course)
                        @php
                            $totalDuration = 0;
                            foreach($course->videos as $video){
                                $totalDuration += $video->duration; // Asumsi duration dalam menit
                            }
                        @endphp
                        <div class="col-xl-3 col-md-6 col-lg-4">
                            <div class="wsus__single_courses_3">
                                <div class="wsus__single_courses_3_img">
                                    <img src="{{ Storage::url($course->thumbnail) }}" class="card-img-top rounded-top" alt="thumbnail" style="height: 200px; object-fit: cover;">
                                     <span class="time"><i class="far fa-clock"></i>
                                        {{ floor($totalDuration / 60) }}:{{ str_pad($totalDuration % 60, 2, '0', STR_PAD_LEFT) }} Minutes
                                    </span>
                                     </div>
                                <div class="wsus__single_courses_text_3">
                                    <div class="rating_area">
                                        <p class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <span>(4.8 Rating)</span>
                                        </p>
                                    </div>
                                    <a class="title" href="{{ route('frontend.pages.course-detail', $course->slug) }}">{{ $course->name }}</a>
                                    <ul>
                                        <li>{{ $course->videos_count }} Lessons</li>
                                        <li>{{ $course->employees_count }} Student</li>
                                    </ul>
                                    <a class="author" href="#">
                                        <div class="img">
                                            <img src="{{ Storage::url($course->teacher->user->avatar) }}" class="w-100 h-100 object-cover" alt="icon">
                                        </div>
                                        <h4>{{ $course->teacher->user->name ?? 'Teacher Name' }}</h4>
                                    </a>
                                </div>
                                <div class="wsus__single_courses_3_footer">
                                    <a class="common_btn" href="#">Enroll <i class="far fa-arrow-right"></i></a>

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="row mt_60 wow fadeInUp">
            <div class="col-12 text-center">
                <a class="common_btn" href="{{ route('frontend.pages.courses') }}">Browse More Courses <i class="far fa-angle-right"></i></a>
            </div>
        </div>
    </section>
    <!--===========================
        COUESES 3 END
    ============================-->
