@extends('frontend.layouts.master')

@section('content')
    <!--===========================
                BREADCRUMB START
            ============================-->
    <section class="wsus__breadcrumb" style="background: url({{ asset('frontend/assets/images/breadcrumb_bg.jpg') }});">
        <div class="wsus__breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12 wow fadeInUp">
                        <div class="wsus__breadcrumb_text">
                            <h1>Categories</h1>
                            <ul>
                                <li><a href="{{ route('frontend.index') }}">Home</a></li>
                                <li>Categories</li>
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
                CATEGORY PAGE START
            ============================-->
    <section class="wsus__category_page mt_95 xs_mt_75 pb_120 xs_pb_100">
        <div class="container">
            <div class="row">
                @forelse ($categories as $category)
                    <div class="col-xl-3 col-sm-6 col-lg-4 wow fadeInUp">
                        <div class="wsus__category_item_2">
                            <a href="{{ route('frontend.pages.category-detail', $category->slug) }}"
                                class="wsus__category_item_2_img">
                                @if ($category->image)
                                    <img src="{{ filter_var($category->image, FILTER_VALIDATE_URL) ? $category->image : Storage::url($category->image) }}"
                                        alt="Image" class="img-fluid w-100">
                                @else
                                    <div class="category-placeholder">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                            </a>
                            <div class="wsus__category_item_2_text">
                                <span style="display: flex; justify-content: center; align-items: center;">
                                    @if ($category->icon)
                                        <img src="{{ filter_var($category->icon, FILTER_VALIDATE_URL) ? $category->icon : Storage::url($category->icon) }}"
                                            alt="Icon" class="img-fluid w-100">
                                    @else
                                        <div class="category-icon-placeholder">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                </span>
                                <a href="{{ route('frontend.pages.category-detail', $category->slug) }}"
                                    class="title">{{ $category->name }}</a>
                                <p>{{ $category->courses_count }} Course <i class="far fa-arrow-right"></i></p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>Data Category Not Available</p>
                @endforelse
            </div>
            <div class="wsus__pagination mt_50 wow fadeInUp">
                {{ $categories->links() }}
            </div>
        </div>
    </section>
    <!--===========================
                CATEGORY PAGE END
            ============================-->
@endsection
