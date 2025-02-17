@extends('frontend.layouts.master')

@section('content')
    <!-- BREADCRUMB -->
    <section class="breadcrumb-section bg-light">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb py-2 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('frontend.index') }}" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('frontend.pages.category') }}" class="text-decoration-none">Categories</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($category->name, 25) }}</li>
                </ol>
            </nav>
            <h1 class="h2 mb-3">{{ $category->name }}</h1>
        </div>
    </section>

    <!-- COURSE GRID -->
    <section class="py-5">
        <div class="container">
            <!-- Header & Search -->
            <div class="row pb-4 mb-4 border-bottom">
                <div class="col-lg-8">
                    <h2 class="h3 mb-2">Kursus {{ $category->name }}</h2>
                    <p class="text-muted small">{{ $category->courses_count }} kursus tersedia</p>
                </div>
                 <div class="col-lg-4 mt-3 mt-lg-0">
                    <form method="GET" class="d-flex">
                         <input type="text" class="form-control rounded-start" placeholder="Cari kursus..." name="search">
                         <button class="btn btn-primary px-4 rounded-end" type="submit">
                             <i class="fas fa-search"></i>
                         </button>
                    </form>
                </div>
            </div>


            <!-- Course Cards -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                @forelse ($category->courses as $course)
                    <div class="col">
                        <div class="card shadow-sm h-100 overflow-hidden">
                            <!-- Thumbnail -->
                            <a href="{{ route('frontend.pages.course-detail', $course->slug) }}" class="position-relative">
                                <img src="{{ Storage::url($course->thumbnail) }}" class="card-img-top" alt="{{ $course->name }}" style="aspect-ratio: 16 / 9; object-fit: cover;">
                                <span class="badge bg-primary position-absolute top-0 end-0 m-2">
                                  {{-- BUATKAN Label gratis karena course ini ga ada pake duit  --}}
                                </span>
                            </a>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <!-- Instructor -->
                                     <div class="d-flex align-items-center small">
                                         <img src="{{ $course->teacher->user->avatar ? Storage::url($course->teacher->user->avatar) : asset('assets/images/default_avatar.png') }}"
                                             alt="Avatar {{ $course->teacher->user->name }}"
                                             class="rounded-circle me-2" width="30" height="30"
                                             style="object-fit: cover;">
                                        {{ Str::limit($course->teacher->user->name, 15) }}
                                    </div>
                                    <!-- Rating -->
                                    <span class="badge bg-warning text-dark small">
                                        <i class="fas fa-star me-1"></i> {{ number_format($course->averageRating, 1) }}
                                    </span>
                                </div>

                                <!-- Course Title (Stretched Link) -->
                                <h3 class="h5 card-title">
                                    <a href="{{ route('frontend.pages.course-detail', $course->slug) }}" class="text-decoration-none text-dark stretched-link">
                                        {{ $course->name }}
                                    </a>
                                </h3>

                                <!-- Meta (Lessons & Duration) -->
                                <div class="text-muted small">
                                    <i class="fas fa-video me-1"></i> {{ $course->lessons_count }} Pelajaran
                                    <span class="mx-2">|</span>
                                    <i class="fas fa-clock me-1"></i> {{ $course->duration ?? '0j 0m' }}
                                </div>
                                  <!-- Enrollment -->
                                <div class="mt-2">
                                    <span class="badge bg-light text-muted border small">
                                        <i class="fas fa-users me-1"></i> {{ $course->students_count }} Terdaftar
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                   <div class="col-12">
                       <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-triangle me-2"></i> Tidak ada kursus yang ditemukan.
                            <a href="{{ route('frontend.pages.category') }}" class="ms-2 btn btn-outline-primary btn-sm">Lihat Semua Kategori</a>
                       </div>

                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($courses->hasPages())
                <div class="mt-5">
                    {{ $courses->onEachSide(1)->links() }} <!-- Default Laravel pagination -->
                </div>
            @endif
        </div>
    </section>
@endsection

@push('styles')
<style>
.breadcrumb-section{
    border-bottom: 1px solid #dee2e6;
}

/* Card Hover Effect */
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

/* Stretched Link (Title) - Make the whole title area clickable */
.card-title .stretched-link:hover {
    color: #0d6efd !important;  /* Or your primary color */
}

/* Responsive Image */
.card-img-top{
    transition: transform 0.2s ease-in-out;
}

.card:hover .card-img-top {
    transform: scale(1.05);
}
</style>
@endpush
