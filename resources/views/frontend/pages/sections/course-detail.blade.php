@extends('frontend.layouts.master')

@section('content')
   <!--===========================
                 BREADCRUMB START
                 ============================-->
   <!--===========================
                 BREADCRUMB START
                 ============================-->
   <section class="wsus__breadcrumb course_details_breadcrumb"
      style="background: url({{ asset('frontend/assets/images/breadcrumb_bg.jpg') }});">
      <div class="wsus__breadcrumb_overlay">
         <div class="container">
            <div class="row">
               <div class="col-12 wow fadeInUp">
                  <div class="wsus__breadcrumb_text">

                     <h1>{{ $course->name }}</h1>
                     <ul class="list">
                        @if ($course->teacher)
                           <li>
                              <span><img class="img-fluid" src="{{ asset('frontend/assets/images/user_icon_blue.png') }}"
                                    alt="user"></span>
                              By {{ $course->teacher->user->name }}
                           </li>
                        @endif
                        @if ($course->category)
                           <li>
                              <span><img class="img-fluid" src="{{ asset('frontend/assets/images/globe_icon_blue.png') }}"
                                    alt="Globe"></span>
                              {{ $course->category->name }}
                           </li>
                        @else
                           <li>
                              <span><img class="img-fluid" src="{{ asset('frontend/assets/images/globe_icon_blue.png') }}"
                                    alt="Globe"></span>
                              Uncategorized
                           </li>
                        @endif
                        @if ($course->updated_at)
                           <li>
                              <span><img class="img-fluid" src="{{ asset('frontend/assets/images/calendar_blue.png') }}"
                                    alt="Calendar"></span>
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
                 ===========================-->

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
                     <!-- Curriculum Tab -->
                     <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
                        tabindex="0">
                        <div class="wsus__courses_curriculum box_area">
                           <h3 class="mb-4 text-primary fw-bold">Course Curriculum</h3>
                           <div class="accordion" id="accordionExample">
                              @foreach ($course->chapters as $chapter)
                                 <div class="accordion-item shadow rounded mb-2">
                                    <h2 class="accordion-header" id="heading{{ $chapter->id }}">
                                       <button class="accordion-button collapsed py-3" data-bs-toggle="collapse"
                                          data-bs-target="#collapse{{ $chapter->id }}" type="button"
                                          aria-expanded="false" aria-controls="collapse{{ $chapter->id }}"
                                          style="background-color: #f8f9fa;">
                                          <i class="fas fa-folder me-2 text-secondary"></i>
                                          <span class="fw-bold text-dark">{{ $chapter->name }}</span>
                                       </button>
                                    </h2>
                                    <div class="accordion-collapse collapse" id="collapse{{ $chapter->id }}"
                                       data-bs-parent="#accordionExample" aria-labelledby="heading{{ $chapter->id }}">
                                       <div class="accordion-body p-3">
                                          <ul class="list-unstyled">
                                             @foreach ($chapter->videos as $video)
                                                <li
                                                   class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                                   <div class="d-flex align-items-center">
                                                      <i class="fas fa-play-circle me-2 text-primary"></i>
                                                      <span class="text-dark">{{ $video->name }}</span>
                                                   </div>
                                                   <div class="d-flex align-items-center gap-3">
                                                      @if ($loop->first)
                                                         <button class="btn btn-sm btn-outline-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#videoModal{{ $video->id }}"
                                                            type="button">
                                                            Preview
                                                         </button>
                                                      @endif
                                                      @if ($video->duration)
                                                         <span class="text-muted">
                                                            <i class="far fa-clock me-1"></i>
                                                            {{ floor($video->duration / 60) }}:{{ str_pad($video->duration % 60, 2, '0', STR_PAD_LEFT) }}
                                                            minutes
                                                         </span>
                                                      @endif
                                                      @if (!$loop->first)
                                                         <i class="fas fa-lock text-secondary"></i>
                                                      @endif
                                                   </div>
                                                </li>

                                                @if ($loop->first)
                                                   <div class="modal fade" id="videoModal{{ $video->id }}"
                                                      aria-hidden="true" tabindex="-1">
                                                      <div class="modal-dialog modal-xl modal-dialog-centered">
                                                         <div class="modal-content shadow-lg rounded-4 border-0">
                                                            <div class="modal-header p-4">
                                                               <h5 class="modal-title fw-bold text-primary">
                                                                  {{ $video->name }}</h5>
                                                               <button
                                                                  class="btn btn-outline-secondary btn-sm rounded-circle"
                                                                  data-bs-dismiss="modal" type="button"
                                                                  aria-label="Close">
                                                                  <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg"
                                                                     fill="none" viewBox="0 0 24 24"
                                                                     stroke-width="1.5" stroke="currentColor">
                                                                     <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M6 18L18 6M6 6l12 12" />
                                                                  </svg>
                                                               </button>
                                                            </div>
                                                            <div class="modal-body p-0">
                                                               <div class="video-container position-relative"
                                                                  style="padding-bottom: 56.25%;">
                                                                  <iframe
                                                                     class="preview-iframe position-absolute top-0 start-0 w-100 h-100"
                                                                     src="https://www.youtube.com/embed/{{ $video->path_video }}?autoplay=1&rel=0"
                                                                     style="border: none;" allowfullscreen
                                                                     allowtransparency>
                                                                  </iframe>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                @endif
                                             @endforeach

                                             @foreach ($chapter->quizzes as $quiz)
                                                <li
                                                   class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                                   <div class="d-flex align-items-center">
                                                      <i class="fas fa-question-circle me-2 text-warning"></i>
                                                      <span class="text-dark">{{ $quiz->title }}</span>
                                                   </div>
                                                   <div class="d-flex align-items-center gap-3">
                                                      <span class="badge bg-info text-dark">Quiz</span>
                                                      <i class="fas fa-lock text-secondary"></i>
                                                   </div>
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
                     <div class="tab-content" id="pills-tabContent">
                        {{-- Your Instructor Tab Snippet (which is correct in itself) --}}
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                           aria-labelledby="pills-contact-tab" tabindex="0">
                           <div class="wsus__courses_instructor box_area">
                              <h3>Instructor Details</h3>
                              @if ($course->teacher)
                                 <div class="row align-items-center">
                                    <div class="col-lg-4 col-md-6">
                                       <div class="wsus__courses_instructor_img">
                                          @if ($course->teacher->user && $course->teacher->user->avatar)
                                             <img class="img-fluid"
                                                src="{{ Storage::url($course->teacher->user->avatar) }}"
                                                alt="{{ $course->teacher->user->name }}">
                                          @else
                                             <img class="img-fluid"
                                                src="{{ asset('frontend/assets/images/default-avatar.png') }}"
                                                alt="Default Avatar">
                                          @endif
                                       </div>
                                    </div>
                                    <div class="col-lg-8 col-md-6">
                                       <div class="wsus__courses_instructor_text">
                                          <h4>
                                             {{ $course->teacher->user ? $course->teacher->user->name : 'Instructor Name Not Available' }}
                                          </h4>
                                          <p class="occupation">
                                             {{ $course->teacher->user->occupation ?? 'Occupation Not Available' }}
                                          </p>
                                          <ul class="list">
                                             <li>
                                                <span><img class="img-fluid"
                                                      src="{{ asset('frontend/assets/images/book_icon.png') }}"
                                                      alt="book"></span>
                                                {{ $course->teacher->courses->count() }} Courses
                                             </li>
                                             <li>
                                                <span><img class="img-fluid"
                                                      src='{{ asset('frontend/assets/images/user_icon_gray.png') }}'
                                                      alt="user"></span>
                                                {{ $course->teacher->courses->flatMap->students->unique()->count() }}
                                                Students
                                             </li>
                                          </ul>
                                          <ul class="badge d-flex flex-wrap">
                                             <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-title="Exclusive Author">
                                                <img class="img-fluid"
                                                   src="{{ asset('frontend/assets/images/badge_1.png') }}"
                                                   alt="Badge">
                                             </li>
                                             <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-title="Top Earning"><img class="img-fluid"
                                                   src="{{ asset('frontend/assets/images/badge_2.png') }}"
                                                   alt="Badge"></li>
                                             <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-title="Trending"><img class="img-fluid"
                                                   src="{{ asset('frontend/assets/images/badge_3.png') }}"
                                                   alt="Badge"></li>
                                             <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-title="2 Years of Membership"><img class="img-fluid"
                                                   src="{{ asset('frontend/assets/images/badge_4.png') }}"
                                                   alt="Badge">
                                             </li>
                                             <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-title="Collector Lavel 1">
                                                <img class="img-fluid"
                                                   src="{{ asset('frontend/assets/images/badge_5.png') }}"
                                                   alt="Badge">
                                             </li>
                                          </ul>
                                          @if ($course->teacher->about)
                                             <p class="description">
                                                {{ $course->teacher->about }}
                                             </p>
                                          @endif
                                       </div>
                                    </div>
                                 </div>
                              @endif {{-- Closing @if for the instructor details section --}}
                           </div>
                        </div>
                     </div> {{-- Closing tab-content and pills-tabContent --}}


                     {{-- FAQs Tab --}}
                     <div class="tab-pane fade" id="pills-disabled" role="tabpanel">
                        <div class="wsus__course_faq box_area">
                           <div class="accordion accordion-flush" id="accordionFlushExample">
                              {{-- Add your FAQ items here if you have them in your database --}}
                              <div class="accordion-item">
                                 <h2 class="accordion-header">
                                    <button class="accordion-button" data-bs-toggle="collapse"
                                       data-bs-target="#flush-collapseOne" type="button">
                                       How long does it take to complete this course?
                                    </button>
                                 </h2>
                                 <div class="accordion-collapse collapse show" id="flush-collapseOne">
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
                  @php
                     // Inisialisasi array untuk menyimpan video demo dari setiap chapter
                     $chapterDemoVideos = [];

                     // Loop melalui setiap chapter dalam kursus
                     foreach ($course->chapters as $chapter) {
                         // Ambil video pertama dari chapter ini
                         $firstVideo = $chapter->videos->first();

                         // Jika video ditemukan, tambahkan ke daftar video demo
                         if ($firstVideo) {
                             // Set durasi maksimal demo (2 menit = 120 detik)
                             $maxDemoDuration = 120; // dalam detik

                             // Batasi durasi video menjadi maksimal 2 menit
                             $endTime = min($firstVideo->duration, $maxDemoDuration);

                             // Buat URL dengan parameter start dan end
                             $videoUrl = "https://youtu.be/{$firstVideo->path_video}?start=0&end={$endTime}";

                             $chapterDemoVideos[] = [
                                 'chapter_name' => $chapter->name,
                                 'video_id' => $firstVideo->path_video,
                                 'video_name' => $firstVideo->name,
                                 'video_url' => $videoUrl,
                                 'duration' => $endTime,
                             ];
                         }
                     }
                  @endphp

                  <!-- Tampilkan video pertama sebagai video utama -->
                  <div class="wsus__courses_sidebar_video">
                     <img class="img-fluid" src="{{ Storage::url($course->thumbnail) }}" alt="Video">
                     @if (count($chapterDemoVideos) > 0)
                        <a class="play_btn venobox vbox-item" data-autoplay="true" data-vbtype="video"
                           href="{{ $chapterDemoVideos[0]['video_url'] }}">
                           <img class="img-fluid" src="{{ asset('frontend/assets/images/play_icon_white.png') }}"
                              alt="Play">
                        </a>
                     @else
                        <p>Tidak ada video demo tersedia</p>
                     @endif
                  </div>

                  <!-- Menampilkan daftar semua video demo dari setiap chapter -->
                  @if (count($chapterDemoVideos) > 1)
                     <div class="demo-videos-list mt-3">
                        <h4>Video Demo Per Chapter</h4>
                        <ul>
                           @foreach ($chapterDemoVideos as $index => $demoVideo)
                              <li>
                                 <a class="venobox vbox-item" data-vbtype="video" href="{{ $demoVideo['video_url'] }}">
                                    <i class="fas fa-play-circle"></i> <!-- Icon play untuk setiap item -->
                                    {{ $demoVideo['chapter_name'] }}: {{ $demoVideo['video_name'] }}
                                 </a>
                              </li>
                           @endforeach
                        </ul>
                     </div>
                  @endif

                  <div class="wsus__courses_sidebar_list_info">
                     <ul>
                        <li>
                           <p>
                              <span><img class="img-fluid"
                                    src="{{ asset('frontend/assets/images/clock_icon_black.png') }}"></span>
                              Course Duration
                           </p>
                           {{-- **Dynamic Course Duration Calculation** --}}
                           @php
                              $totalDurationInSeconds = 0;
                              foreach ($course->chapters as $chapter) {
                                  foreach ($chapter->videos as $video) {
                                      $totalDurationInSeconds += $video->duration;
                                  }
                              }
                              $totalMinutes = floor($totalDurationInSeconds / 60);
                              $remainingSeconds = $totalDurationInSeconds % 60;
                           @endphp
                           {{ $totalMinutes }} min {{ $remainingSeconds }} sec
                        </li>
                        <li>
                           <p>
                              <span><img class="img-fluid"
                                    src="{{ asset('frontend/assets/images/user_icon_black_2.png') }}"></span>
                              Student Enrolled
                           </p>
                           {{-- **Dynamic Student Count** --}}
                           {{ $course->students()->count() }}
                        </li>
                     </ul>
                     <div class="enroll-section">
                        @php
                           $employee = Auth::user();
                           $courseEmployee = $employee
                               ? \App\Models\CourseEmployee::where('user_id', $employee->id)
                                   ->where('course_id', $course->id)
                                   ->first()
                               : null;
                        @endphp

                        @if (!$employee)
                           <p>Silakan login untuk mendaftar kursus ini.</p>
                        @elseif(!$courseEmployee)
                           <form action="{{ route('employees-dashboard.courses.enroll', $course->id) }}" method="POST">
                              @csrf
                              <button class="common_btn" type="submit">Enroll The Course <i
                                    class="far fa-arrow-right"></i></button>
                           </form>
                        @elseif(!$courseEmployee->is_approved)
                           <p>Menunggu Persetujuan Kursus</p>
                        @else
                           <a class="common_btn"
                              href="{{ route('employees-dashboard.courses.learn', $course->id) }}">Mulai Belajar <i
                                 class="far fa-arrow-right"></i></a>
                        @endif
                     </div>
                  </div>
                  <div class="wsus__courses_sidebar_info">
                     <h3>This Course Includes</h3>
                     <ul>
                        <li>
                           <span><img class="img-fluid"
                                 src="{{ asset('frontend/assets/images/life_time_icon.png') }}"></span>
                           Course Lifetime Access
                        </li>
                     </ul>
                  </div>
                  <div class="wsus__courses_sidebar_instructor">
                     <div class="image_area d-flex flex-wrap align-items-center">
                        <div class="img">
                           @if ($course->teacher && $course->teacher->user && $course->teacher->user->avatar)
                              <img class="img-fluid" src="{{ Storage::url($course->teacher->user->avatar) }}"
                                 alt="Instructor">
                           @else
                              <img class="img-fluid" src="{{ asset('frontend/assets/images/default-avatar.png') }}"
                                 alt="Default Instructor">
                           @endif
                        </div>
                        <div class="text">
                           @if ($course->teacher && $course->teacher->user)
                              <h3>{{ $course->teacher->user->name }}</h3>
                              {{-- **Dynamic Instructor Category/Role - Using Course Category Name** --}}
                              <span>{{ $course->category->name ?? 'Instructor' }}</span>
                           @else
                              <h3>Unnamed Instructor</h3>
                              <span>Instructor</span>
                           @endif
                        </div>
                     </div>
                     <ul class="d-flex flex-wrap">
                        <li data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Exclusive Author">
                           <img class="img-fluid" src="{{ asset('frontend/assets/images/badge_1.png') }}"
                              alt="Badge">
                        </li>
                        <li data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Top Earning"><img
                              class="img-fluid" src="{{ asset('frontend/assets/images/badge_5.png') }}"alt="Badge"></li>
                        <li data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Trending"><img
                              class="img-fluid" src="{{ asset('frontend/assets/images/badge_3.png') }}" alt="Badge">
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
