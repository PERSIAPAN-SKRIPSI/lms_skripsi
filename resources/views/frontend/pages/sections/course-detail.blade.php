@extends('frontend.layouts.master')

@section('content')
    <!--===========================
                        BREADCRUMB START
                    ============================-->
    <!--===========================
                    BREADCRUMB START
                ============================-->
    <section class="wsus__breadcrumb course_details_breadcrumb"
        style="background: url({{ asset('images/breadcrumb_bg.jpg') }});">
        <div class="wsus__breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12 wow fadeInUp">
                        <div class="wsus__breadcrumb_text">

                            <h1>{{ $course->name }}</h1>
                            <ul class="list">
                                @if ($course->teacher)
                                    <li>
                                        <span><img src="{{ asset('frontend/assets/images/user_icon_blue.png') }}"
                                                alt="user" class="img-fluid"></span>
                                        By {{ $course->teacher->name }}
                                    </li>
                                @endif
                                @if ($course->teacher && $course->teacher->occupation)
                                    <li>
                                        <span><img src="{{ asset('frontend/assets/images/globe_icon_blue.png') }}"
                                                alt="Globe" class="img-fluid"></span>
                                        {{ $course->teacher->occupation }}
                                    </li>
                                @elseif($course->teacher)
                                    <li>
                                        <span><img src="{{ asset('frontend/assets/images/globe_icon_blue.png') }}"
                                                alt="Globe" class="img-fluid"></span>
                                        Instruktur
                                    </li>
                                @endif
                                @if ($course->updated_at)
                                    <li>
                                        <span><img src="{{ asset('frontend/assets/images/calendar_blue.png') }}"
                                                alt="Calendar" class="img-fluid"></span>
                                        Last updated {{ $course->updated_at->format('d/Y') }}
                                    </li>
                                @endif
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
                        BREADCRUMB END
                    ============================-->

    <!--===========================
                        COURSES DETAILS START
                    ============================-->
    {{-- Course Details Section --}}
    <section class="wsus__courses_details pb_120 xs_pb_100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 wow fadeInLeft">
                    <div class="wsus__courses_details_area mt_40">
                        {{-- Tabs Navigation --}}
                        <ul class="nav nav-pills mb_40" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-home" type="button" role="tab">Overview</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-profile" type="button" role="tab">Curriculum</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-contact" type="button" role="tab">Instructor</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-disabled-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-disabled" type="button" role="tab">FAQs</button>
                            </li>
                        </ul>

                        {{-- Tab Contents --}}
                        <div class="tab-content" id="pills-tabContent">
                            {{-- Overview Tab --}}
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel">
                                <div class="wsus__courses_overview box_area">
                                    <h3>Course Description</h3>
                                    <div>{!! $course->description !!}</div>

                                    <h3>What Will You Learn?</h3>
                                    <ul>
                                        @foreach ($course->keypoints as $keypoint)
                                            <li>{{ $keypoint->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            {{-- Curriculum Tab --}}
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel">
                                <div class="wsus__courses_curriculum box_area">
                                    <h3>Course Curriculum</h3>
                                    <div class="accordion" id="accordionExample">
                                        @foreach ($course->chapters->sortBy('order') as $chapter)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}"
                                                        type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapse{{ $chapter->id }}">
                                                        {{ $chapter->name }}
                                                    </button>
                                                </h2>
                                                <div id="collapse{{ $chapter->id }}"
                                                    class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                                    data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <ul>
                                                            @foreach ($chapter->videos as $video)
                                                                <li>
                                                                    <p>{{ $video->name }}</p>
                                                                    <span class="right_text">
                                                                        @if ($video->duration)
                                                                            {{ $video->duration }} minutes
                                                                        @else
                                                                            Preview
                                                                        @endif
                                                                    </span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            {{-- Instructor Tab --}}
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel">
                                <div class="wsus__courses_instructor box_area">
                                    <h3>Instructor Details</h3>
                                    @if ($course->teacher)
                                        <div class="row align-items-center">
                                            <div class="col-lg-4 col-md-6">
                                                <div class="wsus__courses_instructor_img">
                                                    @if ($course->teacher->user && $course->teacher->user->avatar)
                                                        <img src="{{ Storage::url($course->teacher->user->avatar) }}"
                                                            alt="{{ $course->teacher->user->name }}" class="img-fluid">
                                                    @else
                                                        <img src="{{ asset('frontend/assets/images/default-avatar.png') }}"
                                                            alt="Default Avatar" class="img-fluid">
                                                    @endif

                                                    {{-- Teacher Status Badge --}}
                                                    @if ($course->teacher->is_active)
                                                        <div class="verification-badge verified">
                                                            <i class="fas fa-check-circle"></i> Verified Instructor
                                                        </div>
                                                    @else
                                                        <div class="verification-badge pending">
                                                            <i class="fas fa-clock"></i> Verification Pending
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col-md-6">
                                                <div class="wsus__courses_instructor_text">
                                                    <h4>{{ $course->teacher->user->name }}</h4>
                                                    <p class="designation">{{ $course->teacher->specialization }}</p>

                                                    {{-- Teacher Stats --}}
                                                    <ul class="list">
                                                        <li>
                                                            <span><img
                                                                    src="{{ asset('frontend/assets/images/book_icon.png') }}"
                                                                    alt="book" class="img-fluid"></span>
                                                            {{ $course->teacher->courses->count() }} Courses
                                                        </li>
                                                        <li>
                                                            <span><img
                                                                    src="{{ asset('frontend/assets/images/user_icon_gray.png') }}"
                                                                    alt="user" class="img-fluid"></span>
                                                            {{ $course->teacher->courses->flatMap->students->unique()->count() }}
                                                            Students
                                                        </li>
                                                        @if ($course->teacher->experience_years)
                                                            <li>
                                                                <span><i class="fas fa-briefcase"></i></span>
                                                                {{ $course->teacher->experience_years }} Years Experience
                                                            </li>
                                                        @endif
                                                    </ul>

                                                    {{-- Teacher Verification Documents --}}
                                                    @if ($course->teacher->is_active)
                                                        <div class="instructor-documents mb-4">
                                                            <h5>Verified Documents</h5>
                                                            <ul class="badge d-flex flex-wrap gap-3">
                                                                @if ($course->teacher->certificate)
                                                                    <li class="verified-doc">
                                                                        <div class="doc-item" data-bs-toggle="tooltip"
                                                                            data-bs-placement="top"
                                                                            title="View Certificate">
                                                                            <a href="{{ Storage::url($course->teacher->certificate) }}"
                                                                                target="_blank"
                                                                                class="d-flex align-items-center">
                                                                                <i class="fas fa-certificate me-2"></i>
                                                                                <span>Teaching Certificate</span>
                                                                                <i
                                                                                    class="fas fa-check-circle text-success ms-2"></i>
                                                                            </a>
                                                                        </div>
                                                                    </li>
                                                                @endif

                                                                @if ($course->teacher->cv)
                                                                    <li class="verified-doc">
                                                                        <div class="doc-item" data-bs-toggle="tooltip"
                                                                            data-bs-placement="top" title="View CV">
                                                                            <a href="{{ Storage::url($course->teacher->cv) }}"
                                                                                target="_blank"
                                                                                class="d-flex align-items-center">
                                                                                <i class="fas fa-file-alt me-2"></i>
                                                                                <span>Professional CV</span>
                                                                                <i
                                                                                    class="fas fa-check-circle text-success ms-2"></i>
                                                                            </a>
                                                                        </div>
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    @endif

                                                    {{-- Teacher Description --}}
                                                    @if ($course->teacher->about)
                                                        <p class="description">
                                                            {{ $course->teacher->about }}
                                                        </p>
                                                    @endif

                                                    {{-- Social Media Links --}}
                                                    <ul class="link d-flex flex-wrap">
                                                        @if ($course->teacher->twitter)
                                                            <li><a href="{{ $course->teacher->twitter }}"
                                                                    target="_blank">
                                                                    <i class="fab fa-twitter"></i></a></li>
                                                        @endif
                                                        @if ($course->teacher->facebook)
                                                            <li><a href="{{ $course->teacher->facebook }}"
                                                                    target="_blank">
                                                                    <i class="fab fa-facebook-f"></i></a></li>
                                                        @endif
                                                        @if ($course->teacher->linkedin)
                                                            <li><a href="{{ $course->teacher->linkedin }}"
                                                                    target="_blank">
                                                                    <i class="fab fa-linkedin-in"></i></a></li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <p>No instructor information available.</p>
                                    @endif
                                </div>
                            </div>

                            {{-- FAQs Tab --}}
                            <div class="tab-pane fade" id="pills-disabled" role="tabpanel">
                                <div class="wsus__course_faq box_area">
                                    <div class="accordion accordion-flush" id="accordionFlushExample">
                                        {{-- Add your FAQ items here if you have them in your database --}}
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#flush-collapseOne">
                                                    How long does it take to complete this course?
                                                </button>
                                            </h2>
                                            <div id="flush-collapseOne" class="accordion-collapse collapse show">
                                                <div class="accordion-body">
                                                    The course is self-paced and depends on your dedication and prior
                                                    experience.
                                                    Most students complete it within {{ $course->duration }} hours.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8 wow fadeInRight">
                    <div class="wsus__courses_sidebar">
                        <div class="wsus__courses_sidebar_video">
                            <img src="images/course_sidebar_video_img.jpg" alt="Video" class="img-fluid">
                            <a class="play_btn venobox vbox-item" data-autoplay="true" data-vbtype="video"
                                href="https://youtu.be/sVPYIRF9RCQ?si=labNkx-xlyOWtptr">
                                <img src="images/play_icon_white.png" alt="Play" class="img-fluid">
                            </a>
                        </div>
                        <div class="wsus__courses_sidebar_list_info">
                            <ul>
                                <li>
                                    <p>
                                        <span><img src="images/clock_icon_black.png" alt="clock"
                                                class="img-fluid"></span>
                                        Course Duration
                                    </p>
                                    34 min 54 sec
                                </li>
                                <li>
                                    <p>
                                        <span><img src="images/network_icon_black.png" alt="network"
                                                class="img-fluid"></span>
                                        Skill Level
                                    </p>
                                    Medium
                                </li>
                                <li>
                                    <p>
                                        <span><img src="images/user_icon_black_2.png" alt="User"
                                                class="img-fluid"></span>
                                        Student Enrolled
                                    </p>
                                    47
                                </li>
                            </ul>
                            <a class="common_btn" href="#">Enroll The Course <i class="far fa-arrow-right"></i></a>
                        </div>

                        <div class="wsus__courses_sidebar_share_area">
                            <span>Share:</span>
                            <ul>
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-behance"></i></a></li>
                            </ul>
                        </div>
                        <div class="wsus__courses_sidebar_info">
                            <h3>This Course Includes</h3>
                            <ul>
                                <li>
                                    <span><img src="images/video_icon_black.png" alt="video" class="img-fluid"></span>
                                    54 min 24 sec Video Lectures
                                </li>
                                <li>
                                    <span><img src="images/file_download_icon_black.png" alt="download"
                                            class="img-fluid"></span>
                                    3 Downloadable Resources File
                                </li>
                                <li>
                                    <span><img src="images/certificate_icon_black.png" alt="Certificate"
                                            class="img-fluid"></span>
                                    Certificate of Completion
                                </li>
                                <li>
                                    <span><img src="images/life_time_icon.png" alt="Certificate"
                                            class="img-fluid"></span>
                                    Course Lifetime Access
                                </li>
                            </ul>

                        </div>
                        <div class="wsus__courses_sidebar_instructor">
                            <div class="image_area d-flex flex-wrap align-items-center">
                                <div class="img">
                                    <img src="images/testimonial_user_1.png" alt="Instructor" class="img-fluid">
                                </div>
                                <div class="text">
                                    <h3>Dominic L. Ement</h3>
                                    <p><span>Instructor</span> Level 2</p>
                                </div>
                            </div>
                            <ul class="d-flex flex-wrap">
                                <li data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Exclusive Author">
                                    <img src="images/badge_1.png" alt="Badge" class="img-fluid">
                                </li>
                                <li data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Top Earning"><img
                                        src="images/badge_2.png" alt="Badge" class="img-fluid"></li>
                                <li data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Trending"><img
                                        src="images/badge_3.png" alt="Badge" class="img-fluid"></li>
                                <li data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="2 Years of Membership"><img src="images/badge_4.png" alt="Badge"
                                        class="img-fluid"></li>
                                <li data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Collector Lavel 1">
                                    <img src="images/badge_5.png" alt="Badge" class="img-fluid">
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--===========================
                        COURSES DETAILS END
                    ============================-->
@endsection
