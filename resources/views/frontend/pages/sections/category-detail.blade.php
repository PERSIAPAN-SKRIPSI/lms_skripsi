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
    <section id="Top-Categories" class="max-w-[1200px] mx-auto flex flex-col py-[70px] px-[100px] gap-[30px]">
        <div class="flex flex-col gap-[30px]">
            <div
                class="gradient-badge w-fit p-[8px_16px] rounded-full border border-[#FED6AD] flex items-center gap-[6px]">
                <div>
                    <img src="{{ asset('assets/icon/medal-star.svg') }}" alt="icon">
                </div>
                <p class="font-medium text-sm text-[#FF6129]">Top Categories</p>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-[40px] leading-[60px]">{{ $category->name }}</h2>
                <p class="text-[#6D7786] text-lg -tracking-[2%]">Catching up the on demand skills and high paying career
                    this year</p>
            </div>
            <div class="grid grid-cols-3 gap-[30px] w-full">
                @forelse ($category->courses as $course)
                    <div class="course-card">
                        <div class="flex flex-col rounded-t-[12px] rounded-b-[24px] gap-[32px] bg-white w-full pb-[10px] overflow-hidden ring-1 ring-[#DADEE4] transition-all duration-300 hover:ring-2 hover:ring-[#FF6129]">
                            <a href="{{ route('frontend.pages.course-detail', $course) }}"
                                class="thumbnail w-full h-[200px] shrink-0 rounded-[10px] overflow-hidden">
                                <img src="{{ Storage::url($course->thumbnail) }}" class="w-full h-full object-cover" alt="thumbnail">
                            </a>
                            <div class="flex flex-col px-4 gap-[32px]">
                                <div class="flex flex-col gap-[10px]">
                                    <a href="{{ route('frontend.pages.course-detail', $course) }}" class="font-semibold text-lg line-clamp-2 hover:line-clamp-none min-h-[56px]">
                                        {{ $course->name }}
                                    </a>
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center gap-[2px]">
                                            <div>
                                                <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                            </div>
                                            <div>
                                                <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                            </div>
                                            <div>
                                                <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                            </div>
                                            <div>
                                                <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                            </div>
                                            <div>
                                                <img src="{{ asset('assets/icon/star.svg') }}" alt="star">
                                            </div>
                                        </div>
                                        <p class="text-right text-[#6D7786]">{{ $course->students->count() }} students</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 flex shrink-0 rounded-full overflow-hidden">
                                        <img src="{{ Storage::url($course->teacher->user->avatar) }}" class="w-full h-full object-cover" alt="icon">
                                    </div>
                                    <div class="flex flex-col">
                                        <p class="font-semibold">{{ $course->teacher->user->name }}</p>
                                        <p class="text-[#6D7786]">{{ $course->teacher->user->occupation }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>Data Course Not Available</p>
                @endforelse
            </div>
        </div>

    </section>

@endsection

