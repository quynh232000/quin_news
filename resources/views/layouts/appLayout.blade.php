@extends('layouts.rootLayout')

@section('body')
    <aside class="m-0 p-0 sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 fixed-start" id="sidenav-main">
        <div class="h-100 d-flex flex-column">
            <div class="sidenav-header">
                <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                    aria-hidden="true" id="iconSidenav"></i>
                <a class="navbar-brand m-0 d-flex align-items-end gap-2" href="{{ route('home') }}">
                    <img src="{{ asset('assets/images/logo/logo.png') }}" class="navbar-brand-img h-100" alt="main_logo" />
                    <span class="ms-1 font-weight-bold"> News</span>
                </a>
            </div>
            <hr class="horizontal dark mt-0" />
            <div class="d-flex flex-column flex-1">
                <div class="collapse navbar-collapse w-auto p-0" id="sidenav-collapse-main">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('home') }}">
                                <div
                                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">Trang chủ</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <div
                                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">Tin hot</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" href="#">
                                <div class="px-2 pe-3">
                                    <i class="fa-solid fa-people-group text-info text-sm opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">Diễn đàn</span>
                            </a>
                        </li>
                        @if (auth()->check())
                            <div class="border-top border-bottom">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('saved')}}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Đã lưu</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('mynews') }}">
                                        <div
                                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                            <i class="ni ni-world-2 text-danger text-sm opacity-10"></i>
                                        </div>
                                        <span class="nav-link-text ms-1">Tin của tôi</span>
                                    </a>
                                </li>
                            </div>
                            <li class="nav-item mt-3">
                                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">
                                    Đang theo dõi
                                </h6>
                            </li>
                            <div class="ps-3 py-3 border-bottom d-flex flex-column gap-3">

                                @foreach (auth()->user()->followings() as $item)
                                    <a href="{{ route('author', ['uuid' => $item->uuid]) }}"
                                        class="d-flex align-items-center gap-2 px-3">
                                        <div>
                                            <img width="36" height="36" class="rounded-circle"
                                                src="{{ $item->avatar }}" alt="" />
                                        </div>
                                        <div class="nav-link-text text-sm ms-1">{{ $item->name }}</div>
                                    </a>
                                @endforeach

                            </div>
                        @endif
                    </ul>
                </div>
                <div class="sidenav-footer mx-3 pt-4 flex-1">
                    @if (auth()->check())
                        <div class="d-flex flex-column align-items-center gap-2 py-3 pb-4">
                            <img src="{{ auth()->user()->avatar }}" class="rounded-circle img-thumbnail" width="46"
                                height="46" alt="">
                            <strong>{{ auth()->user()->name }}</strong>
                        </div>
                        <a class="btn btn-primary btn-sm mb-0 w-100" href="{{ route('logout') }}" type="button">Đăng
                            xuất</a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-dark btn-sm w-100 mb-3">Đăng ký</a>
                        <a class="btn btn-primary btn-sm mb-0 w-100" href="{{ route('login') }}" type="button">Đăng
                            nhập</a>
                    @endif
                    <div class="text-sm text-center pb-1 pt-4">
                        Copyright © 2024 Mr Quynh
                    </div>
                </div>
            </div>
        </div>
    </aside>
    <!-- right -->
    <aside class="m-0 p-0 bg-white navbar navbar-vertical navbar-expand-xs border-0" id="sidenav-main2"
        style="right: 0 !important">
        <div class="h-100 d-flex flex-column">
            <div class="d-flex flex-column flex-1">
                <div class="collapse navbar-collapse w-auto p-0 py-3" id="sidenav-collapse-main2">
                    {{-- <h6 class="px-3 text-uppercase text-xs font-weight-bolder opacity-6">
                        Thẻ nổi bật
                    </h6>
                    <div class="py-2 px-3 d-flex flex-column gap-2">
                        <div class="border-bottom py-2">
                            <div class="fw-bold">#bongda</div>
                            <div class="text-xs">1.2k tin</div>
                        </div>
                        <div class="border-bottom py-2">
                            <div class="fw-bold">#bongda</div>
                            <div class="text-xs">1.2k tin</div>
                        </div>
                        <div class="border-bottom py-2">
                            <div class="fw-bold">#bongda</div>
                            <div class="text-xs">1.2k tin</div>
                        </div>

                        <div class="d-flex align-items-center gap-2 text-primary text-sm fw-bold">
                            <i class="fa-solid fa-angle-down"></i> Xem thêm
                        </div>
                    </div> --}}
                    <h6 class="px-3 text-uppercase text-xs font-weight-bolder opacity-6 mt-5">
                        Tác giả nổi bật
                    </h6>
                    <div class="py-2 px-3 d-flex flex-column gap-2">
                        @foreach ($authors as $item)
                            <a href="{{ route('author', ['uuid' => $item->uuid]) }}"
                                class="d-flex gap-2 align-items-center border-bottom py-2 w-full">
                                <div>
                                    <img class="img-thumbnail rounded-circle" width="46" height="46"
                                        {{-- src={{asset('storage/'.$item->avatar)}} --}} src="{{ $item->avatar }}" alt="" />
                                </div>
                                <div class="flex-1">
                                    <div class="fw-bold text-sm">{{ $item->name }}</div>
                                    <div class="text-xs d-flex justify-content-between mt-1">
                                        <span>{{ $item->news_count() }} bài
                                            viết</span>
                                            <span>{{ $item->followers_count() }} theo dõi</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach

                        {{-- <div class="d-flex align-items-center gap-2 text-primary text-sm fw-bold">
                            <i class="fa-solid fa-angle-down"></i> Xem thêm
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </aside>
    <main class="position-relative w-100 m-auto p-4 bg-white" style="max-width: calc(100% - 520px)">
        <div class="rounded-3 position-relative overflow-hidden">
            <img class="w-100 rounded-3 object-fit-cover" height="180"
                src="https://www.shutterstock.com/shutterstock/videos/1080331217/thumb/1.jpg" alt="" />

            <div class="position-absolute top-0 start-0 bottom-0 end-0 bg-grandient" style="z-index: 1"></div>
            <div style="z-index: 2"
                class="d-flex justify-content-center align-items-center position-absolute top-0 start-0 bottom-0 end-0">
                <div class="w-100">
                    <form class="w-80 m-auto d-flex align-items-center bg-white py-1 ps-4 pe-2"
                        style="border-radius: 20px">
                        <input type="text" name="search" class="flex-1 py-1" style="border: none; outline: none"
                            placeholder="Tìm kiếm" value="{{ request()->search ? request()->search : '' }}" />

                        <button type="submit"
                            class="bg-primary rounded-circle btn btn-primary d-flex justify-content-center align-items-center text-white p-2">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                    <div class="w-80 m-auto mt-4 d-flex justify-content-center gap-3">
                        <span class="text-white">#thethao</span>
                        <span class="text-white">#thethao</span>
                        <span class="text-white">#thethao</span>
                        <span class="text-white">#thethao</span>
                    </div>
                </div>
            </div>
        </div>
        @if (!isset($has_cate) || $has_cate == true)
            <div>
                <div class="border-bottom mt-4 d-flex">
                    <a href="{{route('home')}}" class="text-center flex-1 py-2 text-primary fw-bold border-bottom border-2 border-primary">
                        Dành cho bạn
                    </a>
                    <a href="{{route('following')}}" class="text-center flex-1 py-2 fw-bold">Đang theo dõi</a>
                    <div class="text-center flex-1 py-2 fw-bold">Diễn đàn</div>
                </div>

                <div class="my-4 d-flex gap-3" style="flex-wrap: wrap">
                    <a href="{{ route('home') }}"
                        class="border px-3 py-1 rounded-lg shadow d-flex align-items-center gap-1 bg-primary text-white">
                        <span>Tất cả</span>
                    </a>
                    @foreach ($categories as $item)
                        <a href="{{ route('collection', ['slug_cate' => $item->slug]) }}"
                            class="border px-2 py-1 rounded-lg shadow d-flex align-items-center gap-1">
                            <div class="" style="width: 32px; height:32px">
                                <img src="{{ asset('storage/' . $item->icon_url) }}" class="w-100 h-100 rounded-circle "
                                    alt="">
                            </div>
                            <span>{{ $item->name }}</span>
                        </a>
                    @endforeach

                </div>
            </div>
        @endif
        @yield('main')
    </main>
@endsection
