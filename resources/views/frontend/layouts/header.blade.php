<!--============ PRELOADER START ===========-->
<div id="preloader">
    <div class="preloader_icon">
        <img src="{{ asset('frontend/assets/images/preloader.png') }}" alt="Loading..." class="img-fluid">
    </div>
</div>
<!--============ PRELOADER START ===========-->

<!--===========================
    MAIN MENU START
============================-->
<nav class="navbar navbar-expand-lg main_menu main_menu_3">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('frontend/assets/images/logo.png') }}" alt="EduCore" class="img-fluid"
                style="max-height: 40px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="menu_category">
                <div class="icon">
                    <img src="{{ asset('frontend/assets/images/grid_icon.png') }}" alt="Category" class="img-fluid">
                </div>
                Category
                <ul>
                    @foreach ($categories as $category)
                        @if ($category->parent_id === null)
                            <li>
                                <a href="{{ route('frontend.pages.category', $category->slug) }}">
                                    <span>
                                        @if ($category->icon)
                                            <img src="{{ filter_var($category->icon, FILTER_VALIDATE_URL) ? $category->icon : Storage::url($category->icon) }}"
                                                alt="Image" class="img-fluid w-100">
                                        @else
                                            <div class="category-placeholder">
                                                <svg class="w-10 h-10" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                        @endif
                                    </span>
                                    {{ $category->name }}
                                </a>
                                @if ($category->children->count() > 0)
                                    <ul class="category_sub_menu">
                                        @foreach ($category->children as $subcategory)
                                            <li>
                                                <a href="{{ route('frontend.pages.category', ['category' => $category->slug, 'subcategory' => $subcategory->slug]) }}">
                                                    {{ $subcategory->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <ul class="navbar-nav m-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('courses') ? 'active' : '' }}" href="{{ route('frontend.pages.courses') }}">Courses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact Us</a>
                </li>
            </ul>

            <!-- Right Menu -->
            <div class="right_menu">
                @auth
                    <div class="d-flex align-items-center gap-2">
                        <!-- Profile Info (Kiri) -->
                        <div class="profile-info d-none d-md-block">
                            <p class="mb-0 fw-semibold text-nowrap" style="color: #333333;">
                                @if (Auth::user()->hasRole('admin'))
                                    (Admin)
                                @elseif (Auth::user()->hasRole('teacher'))
                                    (Teacher)
                                @elseif (Auth::user()->hasRole('employee'))
                                    (Employee)
                                @else
                                    (User)
                                    <!-- Default role jika tidak ada role yang sesuai -->
                                @endif
                            </p>
                        </div>

                        <!-- Profile Avatar (Kanan) -->
                        <div class="profile-avatar-wrapper position-relative">
                            <a href="{{ route('dashboard') }}" class="profile-avatar rounded-circle overflow-hidden"
                                aria-label="Dashboard">
                                @if (Auth::user()->avatar)
                                    <img src="{{ Storage::url(Auth::user()->avatar) }}" class="w-100 h-100 object-cover"
                                        alt="{{ Auth::user()->name }}'s Profile">
                                @else
                                    <img src="{{ asset('path/to/default/avatar.png') }}" class="w-100 h-100 object-cover"
                                        alt="{{ Auth::user()->name }}'s Profile">
                                @endif
                            </a>
                        </div>
                    </div>
                @else
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('register') }}"
                            class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-semibold"
                            style="color: #2E86C1; border-color: #2E86C1;">
                            Sign Up
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm rounded-pill px-3 fw-semibold"
                            style="background-color: #2E86C1; border-color: #2E86C1;">
                            Sign In
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
<!--===========================
    MAIN MENU END
============================-->

<!--============================
    MOBILE MENU START
==============================-->
<div class="mobile_menu_area d-lg-none">
    <div class="mobile_menu_area_top d-flex justify-content-between align-items-center p-3 bg-white border-bottom">
        <a class="mobile_menu_logo" href="{{ url('/') }}">
            <img src="{{ asset('frontend/assets/images/logo.png') }}" alt="EduCore" class="img-fluid"
                style="max-height: 40px;">
        </a>
        <button class="mobile_menu_icon d-block d-lg-none" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
            <span class="mobile_menu_icon=>
        <span class="mobile_menu_icon"><i class="far fa-stream menu_icon_bar"></i></span>
        </button>
    </div>

    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="fal fa-times"></i>
        </button>
        <div class="offcanvas-body">
            <div class="mobile_menu_item_area">
                <!-- Profile Section for Logged-In Users -->
                @auth
                    <div class="mobile_menu_header p-3 border-bottom">
                        <div class="d-flex align-items-center gap-3">
                            <!-- Profile Avatar (Kiri) -->
                            <div class="profile-avatar-wrapper position-relative">
                                <a href="{{ route('dashboard') }}" class="profile-avatar rounded-circle overflow-hidden"
                                    aria-label="Dashboard">
                                    @if (Auth::user()->avatar)
                                        <img src="{{ Storage::url(Auth::user()->avatar) }}" class="w-100 h-100 object-cover"
                                            alt="{{ Auth::user()->name }}'s Profile">
                                    @else
                                        <img src="{{ asset('path/to/default/avatar.png') }}" class="w-100 h-100 object-cover"
                                            alt="{{ Auth::user()->name }}'s Profile">
                                    @endif
                                </a>
                            </div>

                            <!-- Profile Info (Kanan) -->
                            <div>
                                <p class="mb-0 fw-semibold" style="color: #333333;">
                                    {{ Auth::user()->name }}
                                    @if (Auth::user()->hasRole('admin'))
                                        (Admin)
                                    @elseif (Auth::user()->hasRole('teacher'))
                                        (Teacher)
                                    @elseif (Auth::user()->hasRole('employee'))
                                        (Employee)
                                    @else
                                        (User)
                                    @endif
                                </p>
                                <a href="{{ route('dashboard') }}" class="text-muted small">Lihat Profil</a>
                            </div>
                        </div>
                    </div>
                @endauth

                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                            aria-selected="true">Menu</button>
                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile"
                            aria-selected="false">Categories</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                        aria-labelledby="nav-home-tab" tabindex="0">
                        <ul class="main_mobile_menu">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="#">About Us</a></li>
                            <li><a href="{{ route('frontend.pages.courses') }}">Courses</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Contact Us</a></li>
                            <!-- Add Login/Logout Options -->
                            @auth
                                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                    </form>
                                </li>
                            @else
                                <li><a href="{{ route('login') }}">Sign In</a></li>
                                <li><a href="{{ route('register') }}">Sign Up</a></li>
                            @endauth
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"
                        tabindex="0">
                        <ul class="main_mobile_menu">
                            @foreach ($categories as $category)
                                @if ($category->parent_id === null)
                                    <li class="mobile_dropdown">
                                        <a href="{{ route('frontend.pages.category', $category->slug) }}">
                                            <span>
                                                @if ($category->icon)
                                                    <img src="{{ filter_var($category->icon, FILTER_VALIDATE_URL) ? $category->icon : Storage::url($category->icon) }}"
                                                        alt="{{ $category->name }}" class="img-fluid rounded-circle"
                                                        style="width: 24px; height: 24px; object-fit: cover;">
                                                @else
                                                    <div class="category-placeholder rounded-circle d-flex justify-content-center align-items-center"
                                                        style="width: 24px; height: 24px; background-color: #EEEEEE;">
                                                        <svg class="w-6 h-6 text-secondary" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </span>
                                            {{ $category->name }}
                                        </a>
                                        @if ($category->children->count() > 0)
                                            <ul class="inner_menu">
                                                @foreach ($category->children as $subcategory)
                                                    <li>
                                                        <a href="{{ route('frontend.pages.category', ['category' => $category->slug, 'subcategory' => $subcategory->slug]) }}">
                                                            {{ $subcategory->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--============================
    MOBILE MENU END
==============================-->
