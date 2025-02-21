
<!--===========================
    CATEGORY DESIGN 3: GLASSMORPHISM EFFECT WITH NEUMORPHIC ELEMENTS
============================-->
<section class="wsus__category_4 mt_190 xs_mt_100">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 m-auto wow fadeInUp">
                <div class="wsus__section_heading mb_35">
                    <h5>Categories</h5>
                    <h2>Explore Categories </h2>
                    <p>Modern glassmorphism effect combined with neumorphic elements</p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($categories as $category)
            <div class="col-xxl-3 col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="{{$loop->index * 0.1}}s">
                <a href="{{ route('frontend.pages.category-detail', $category->slug) }}" class="wsus__single_category_4">
                    <div class="icon">
                        @if ($category->icon)
                        <img src="{{ filter_var($category->icon, FILTER_VALIDATE_URL) ? $category->icon : Storage::url($category->icon) }}"
                            alt="{{ $category->name }}" class="img-fluid w-100" style="max-width: 70px; max-height: 70px; display: inline-block;">
                        @else
                        <div class="category-icon-placeholder">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" style="width: 35px; height: 35px; vertical-align: middle; color: #ced4da;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        @endif
                    </div>
                    <div class="text">
                        <h4>{{ $category->name }}</h4>
                        <p>{{ $category->courses_count }} Course{{ $category->courses_count > 1 ? 's' : '' }}</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        <div class="row mt_60 wow fadeInUp">
            <div class="col-12 text-center">
                <a class="common_btn" href="{{ route('frontend.pages.category') }}">View All Categories <i class="far fa-angle-right" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
</section>
<!--===========================
    CATEGORY DESIGN 3 END
============================-->
