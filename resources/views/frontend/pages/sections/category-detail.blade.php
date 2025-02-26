@extends('frontend.layouts.master')

@section('content')
    <!--===========================
        BREADCRUMB START
    ============================-->
    <section class="wsus__breadcrumb" style="background: url({{ asset('assets/images/breadcrumb_bg.jpg') }});">
        <div class="wsus__breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12 wow fadeInUp">
                        <div class="wsus__breadcrumb_text">
                            <h1>{{ $category->name }}</h1>
                            <ul>
                                <li><a href="{{ route('frontend.index') }}">Home</a></li>
                                <li><a href="{{ route('frontend.pages.category') }}">Categories</a></li>
                                <li>{{ Str::limit($category->name, 25) }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @extends('frontend.layouts.master')

    @section('content')
        <!--===========================
            BREADCRUMB START
        ============================-->
        <section class="wsus__breadcrumb" style="background: url({{ asset('assets/images/breadcrumb_bg.jpg') }});">
            <div class="wsus__breadcrumb_overlay">
                <div class="container">
                    <div class="row">
                        <div class="col-12 wow fadeInUp">
                            <div class="wsus__breadcrumb_text">
                                <h1>{{ $category->name }}</h1>
                                <ul class="list-unstyled d-flex"> {{-- Use Bootstrap's d-flex for horizontal list --}}
                                    <li class="me-2"><a href="{{ route('frontend.index') }}">Home</a></li> {{-- me-2 for margin-right --}}
                                    <li class="me-2"><a href="{{ route('frontend.pages.category') }}">Categories</a></li> {{-- me-2 for margin-right --}}
                                    <li>{{ Str::limit($category->name, 25) }}</li>
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
            CATEGORY COURSES START
        ============================-->
        <section id="Top-Categories" class="container py-5"> {{-- Bootstrap container and py-5 for padding --}}
            <div class="row">
                <div class="col-12">
                    <div class="mb-4">
                        <div class="badge bg-warning text-dark rounded-pill border border-warning d-inline-flex align-items-center gap-2 px-3 py-2"> {{-- Bootstrap badge, background, text, border, rounded pill, flex and padding --}}
                            <div>
                                <img src="{{ asset('assets/icon/medal-star.svg') }}" alt="icon" style="width: 20px; height: 20px;"> {{-- Adjusted icon size with inline style --}}
                            </div>
                            <p class="mb-0 fw-medium small text-danger">Top Categories</p> {{-- Bootstrap typography classes --}}
                        </div>
                    </div>
                    <div class="mb-4">
                        <h2 class="fw-bold display-5">{{ $category->name }}</h2> {{-- Bootstrap display-5 for larger heading --}}
                        <p class="text-secondary fs-5">Catching up the on demand skills and high paying career
                            this year</p> {{-- Bootstrap text-secondary and fs-5 for description --}}
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4"> {{-- Bootstrap grid system --}}
                        @forelse ($category->courses as $course)
                            <div class="col">
                                <div class="card h-100 shadow-sm course-card"> {{-- Bootstrap card and shadow, custom course-card class for additional styling if needed --}}
                                    <a href="{{ route('frontend.pages.course-detail', $course) }}" class="card-img-top-link"> {{-- Added class for image link --}}
                                        <img src="{{ Storage::url($course->thumbnail) }}" class="card-img-top rounded-top" alt="thumbnail" style="height: 200px; object-fit: cover;"> {{-- card-img-top for rounded corners and fixed height --}}
                                    </a>
                                    <div class="card-body d-flex flex-column gap-3"> {{-- card-body and flex column layout --}}
                                        <div>
                                            <h5 class="card-title"><a href="{{ route('frontend.pages.course-detail', $course) }}" class="text-decoration-none text-dark course-title-link">{{ $course->name }}</a></h5> {{-- card-title and removed default link styling, added class for title link --}}
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center gap-1 rating-stars"> {{-- d-flex for rating stars --}}
                                                    @for ($i = 0; $i < 5; $i++)
                                                        <img src="{{ asset('assets/icon/star.svg') }}" alt="star" style="width: 16px; height: 16px;"> {{-- Adjusted star icon size --}}
                                                    @endfor
                                                </div>
                                                <p class="card-text text-muted small">{{ $course->students->count() }} students</p> {{-- card-text and text-muted for student count --}}
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 instructor-info"> {{-- d-flex for instructor info --}}
                                            <div class="instructor-avatar rounded-circle overflow-hidden" style="width: 32px; height: 32px;"> {{-- rounded-circle and fixed size for avatar --}}
                                                <img src="{{ Storage::url($course->teacher->user->avatar) }}" class="w-100 h-100 object-cover" alt="icon">
                                            </div>
                                            <div class="instructor-details">
                                                <p class="card-text fw-semibold mb-0 instructor-name">{{ $course->teacher->user->name }}</p> {{-- card-text and fw-semibold for instructor name --}}
                                                <p class="card-text text-muted small instructor-occupation">{{ $course->teacher->user->occupation }}</p> {{-- card-text and text-muted for occupation --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-muted">Data Course Not Available</p> {{-- text-muted for empty state message --}}
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </section>
        <!--===========================
            CATEGORY COURSES END
        ============================-->

        <style>
            /* Custom Styles to replicate Tailwind and enhance Bootstrap look */
            .badge.bg-warning {
                background: linear-gradient(to right, #FFF2E7, white); /* Replicate gradient background for badge */
            }
            .badge.border-warning {
                border-color: #FED6AD !important; /* Match border color */
            }
            .badge.text-dark .text-danger {
                color: #FF6129 !important; /* Match text color inside badge */
            }
            .course-card {
                border-radius: 12px 24px; /* Rounded corners for card */
                border: 1px solid #DADEE4; /* Border color */
                transition: all 0.3s ease; /* Transition for hover effect */
            }
            .course-card:hover {
                border-width: 2px;
                border-color: #FF6129; /* Hover border color */
                box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15); /* Add a bit more shadow on hover if needed */
            }
            .card-img-top-link {
                display: block; /* Make image link fill container */
                border-radius: 10px;
                overflow: hidden;
            }

            .course-title-link {
                color: #343a40; /* Example dark text color for title */
                transition: color 0.3s ease;
            }

            .course-title-link:hover {
                color: #0a58ca; /* Example primary color on hover, adjust to your theme */
            }

            .rating-stars img {
                filter: brightness(1); /* Ensure star icons are visible, adjust if needed */
            }

        </style>

    @endsection


