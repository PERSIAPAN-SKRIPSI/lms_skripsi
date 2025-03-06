<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport"
      content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
   <meta name="base_url" content="{{ url('/') }}">
   <meta name="csrf_token" content="{{ csrf_token() }}">
   <title>EduCore - Online Courses & Education HTML Template</title>
   <link type="image/png" href="images/favicon.png" rel="icon">
   <link href="{{ asset('frontend/assets/css/all.min.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/animated_barfiller.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/slick.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/venobox.min.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/scroll_button.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/nice-select.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/pointer.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/jquery.calendar.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/range_slider.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/startRating.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/video_player.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/jquery.simple-bar-graph.min.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/select2.min.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/sticky_menu.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/animate.css') }}" rel="stylesheet">
   <link href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css" rel="stylesheet">

   <link href="{{ asset('frontend/assets/css/spacing.css') }}" rel=" stylesheet">
   <link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/responsive.css') }}" rel="stylesheet">
   @vite(['resources/js/frontend/player.js'])
</head>

<body class="home_3">


   <!--============ PRELOADER START ===========-->
   <div id="preloader">
      <div class="preloader_icon">
         <img class="img-fluid" src="{{ asset('frontend/assets/images/preloader.png') }}" alt="Preloader">
      </div>
   </div>
   <!--============ PRELOADER START ===========-->


   <!--===========================
        COURSE VIDEO START
    ============================-->
   <section class="wsus__course_video">
      <div class="col-12">
         <div class="wsus__course_header">
            <a href="{{ route('employees-dashboard.courses.index') }}"><i class="fas fa-angle-left"></i>
               {{ $course->name }}</a>

         </div>
      </div>
      <div class="wsus__course_video_player">
         @if ($firstVideo)
            <div class="video-container"
               style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; background-color: #000;">
               <iframe id="main-video" data-video-id="{{ $firstVideo->id }}"
                  src="https://www.youtube.com/embed/{{ $firstVideo->path_video }}?rel=0&enablejsapi=1"
                  style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" frameborder="0"
                  allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen
                  >
               </iframe>
               <div class="video-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; color: white; font-size: 2em; cursor: pointer;">
               </div>
            </div>
         @else
            <p>Tidak ada video yang tersedia untuk saat ini.</p>
         @endif
      </div>
      <!-- Course Content -->
      <!-- Course Content -->
      <div class="wsus__course_sidebar d-none d-lg-block md:w-1/4">
         <h2 class="video_heading">Course Content</h2>
         <div class="accordion" id="accordionExample">
            @foreach ($chapters as $chapter)
               <div class="accordion-item">
                  <h2 class="accordion-header">
                     <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" data-bs-toggle="collapse"
                        data-bs-target="#collapse{{ $chapter->id }}" type="button"
                        aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                        aria-controls="collapse{{ $chapter->id }}">
                        <b>{{ $chapter->name }}</b>
                        <span>{{ $chapter->videos->count() }}/{{ $chapter->videos->count() }}</span>
                     </button>
                  </h2>
                  <div class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                     id="collapse{{ $chapter->id }}" data-bs-parent="#accordionExample">
                     <div class="accordion-body">
                        @foreach ($chapter->videos as $video)
                           <div class="form-check">
                              <input class="form-check-input video-checkbox" id="video-{{ $video->id }}"
                                 data-video-id="{{ $video->id }}" type="checkbox" value="">
                              <label class="form-check-label video-link" data-video-id="{{ $video->id }}"
                                 data-video-path="{{ $video->path_video }}" data-video-name="{{ $video->name }}"
                                 for="video-{{ $video->id }}">
                                 {{ $video->name }}
                                 <span>
                                    <img class="img-fluid"
                                       src="{{ asset('frontend/assets/images/video_icon_black_2.png') }}"
                                       alt="video">
                                    {{ $video->duration }}
                                 </span>
                              </label>
                           </div>
                        @endforeach

                        <!-- Resources (jika ada) -->
                        <div class="dropdown">
                           <button class="btn btn-secondary" type="button">
                              <i class="fas fa-folder-open"></i> Resources
                           </button>
                           <ul>
                              <li><a class="dropdown-item" href="#">Resources File 01</a></li>
                              <li><a class="dropdown-item" href="#">Resources 02</a></li>
                              <li><a class="dropdown-item" href="#">Resources 03</a></li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            @endforeach
         </div>
      </div>
   </section>
   <!--===========================
        COURSE VIDEO END
    ============================-->

   <!--jquery library js-->
   <script src="{{ asset('frontend/assets/js/jquery-3.7.1.min.js') }}"></script>
   <!--bootstrap js-->
   <script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>
   <!--font-awesome js-->
   <script src="{{ asset('frontend/assets/js/Font-Awesome.js') }}"></script>
   <!--marquee js-->
   <script src="{{ asset('frontend/assets/js/jquery.marquee.min.js') }}"></script>
   <!--slick js-->
   <script src="{{ asset('frontend/assets/js/slick.min.js') }}"></script>
   <!--countup js-->
   <script src="{{ asset('frontend/assets/js/jquery.waypoints.min.js') }}"></script>
   <script src="{{ asset('frontend/assets/js/jquery.countup.min.js') }}"></script>
   <!--venobox js-->
   <script src="{{ asset('frontend/assets/js/venobox.min.js') }}"></script>
   <!--nice-select js-->
   <script src="{{ asset('frontend/assets/js/jquery.nice-select.min.js') }}"></script>
   <!--Scroll Button js-->
   <script src="{{ asset('frontend/assets/js/scroll_button.js') }}"></script>
   <!--pointer js-->
   <script src="{{ asset('frontend/assets/js/pointer.js') }}"></script>
   <!--range slider js-->
   <script src="{{ asset('frontend/assets/js/range_slider.js') }}"></script>
   <!--barfiller js-->
   <script src="{{ asset('frontend/assets/js/animated_barfiller.js') }}"></script>
   <!--calendar js-->
   <script src="{{ asset('frontend/assets/js/jquery.calendar.js') }}"></script>
   <!--starRating js-->
   <script src="{{ asset('frontend/assets/js/starRating.js') }}"></script>
   <!--Bar Graph js-->
   <script src="{{ asset('frontend/assets/js/jquery.simple-bar-graph.min.js') }}"></script>
   <!--select2 js-->
   <script src="{{ asset('frontend/assets/js/select2.min.js') }}"></script>
   <!--Video player js-->
   <script src="{{ asset('frontend/assets/js/video_player.min.js') }}"></script>
   <script src="{{ asset('frontend/assets/js/video_player_youtube.js') }}"></script>
   <script src="{{ asset('frontend/assets/js/videojs-vimeo.umd.js') }}"></script>
   <script src="https://unpkg.com/jszip/dist/jszip.min.js"></script>
   <script src="{{ asset('frontend/assets/js/docx-preview.min.js') }}"></script>
   <!--wow js-->
   <script src="{{ asset('frontend/assets/js/wow.min.js') }}"></script>
   <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

   <!--main/custom js-->
   <script src="{{ asset('frontend/assets/js/main.js') }}"></script>
   <script src="{{ asset('frontend/assets/js/player.js') }}"></script>



</body>

</html>
