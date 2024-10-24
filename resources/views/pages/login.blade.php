@extends('layouts.rootLayout')
@section('viewTitle')
    Đăng nhập
@endsection
@push('js1')
    {{-- <script src="https://challenges.cloudflare.com/turnstile/v0/api.js?onload=onloadTurnstileCallback" defer></script> --}}
@endpush
@section('body')
    <main class="main-content  mt-0 ">

        <section class="position-relative">
            <div class="page-header min-vh-100">
                <a href="{{ route('home') }}" class=" position-absolute" style="top: 20px; left:30px">
                    <img width="94px" src="{{ asset('assets/images/logo/logo.png') }}" alt="">
                </a>
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start bg-transparent">
                                    <h4 class="font-weight-bolder">Đăng nhập</h4>
                                    <p class="mb-0">Nhập Email và mật khẩu để đăng nhập </p>
                                </div>
                                <div class="card-body">
                                    <form role="form" method="POST" action="">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="">Email</label>
                                            <input type="email" name="email" class="form-control form-control-lg"
                                                placeholder="Email" value="{{ old('email') }}" aria-label="Email">
                                            @error('email')
                                                <div class="w-100 ">
                                                    <small class="text-danger ">{{ $message }}</small>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Mật khẩu</label>
                                            <input type="password" class="form-control form-control-lg"
                                                placeholder="Password" value="{{ old('password') }}" name="password"
                                                aria-label="Password">
                                            @error('password')
                                                <div class="w-100 ">
                                                    <small class="text-danger ">{{ $message }}</small>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="d-flex justify-content-end text-sm">
                                            <a href="{{ route('forgotpassword') }}">Quên mật khẩu?</a>
                                        </div>
                                        <div id="show-verify">

                                        </div>
                                        <div class="mt-1" style="display: block; flex-flow: row;">
                                            <div class="cf-turnstile bg-white" data-sitekey="{{ $TURNSTILE_SITE_KEY }}"
                                                data-size="flexible"></div>
                                        </div>
                                        @if (session('message'))
                                            <div class="w-100 ">
                                                <small class="text-danger ">{{ session('message') }}</small>
                                            </div>
                                        @endif
                                        @if (session('success'))
                                            <div class="w-100 ">
                                                <small class="text-success  ">{{ session('success') }}</small>
                                            </div>
                                        @endif

                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Đăng nhập</button>
                                        </div>
                                    </form>
                                    <div>
                                        <p class="mb-4 text-sm mx-auto text-center mt-5">
                                            Bạn chưa có tài khoản? <a href="{{ route('register') }}"
                                                class="text-primary fw-bold ms-1">Đăng kí</a>
                                        </p>
                                    </div>
                                    <div class="card-footer text-center pt-0 px-lg-2 px-1 mt-3">

                                        <div class="mt-5 mb-4 border-bottom position-relative">
                                            <div class="d-flex justify-content-center position-absolute end-0 start-0"
                                                style="bottom:-12px"><span class="px-3"
                                                    style="font-size: 14px; background-color:#f8f9fa">Hoặc</span></div>
                                        </div>
                                        <style>
                                            .btn-login {
                                                background-color: #DB4437;
                                                color: white
                                            }
                                            .btn-login:hover{
                                                 background-color: #DB4437;
                                                 color: white;
 
                                            }
                                        </style>
                                        <div class="w-100 d-flex  gap-3 justify-content-center">
                                            <a style="width: 42px;height:42px"
                                                class="btn btn-login google  btn-lg btn-block w-fit rounded-2 d-flex gap-2 align-items-center justify-content-center"
                                                style="background-color: #DB4437" href="/auth/google/redirect">
                                                <i class="fa-brands fa-google"></i>Goolge
                                            </a>
                                            <a style="width: 42px;height:42px"
                                                class="btn btn-primary btn-lg btn-block w-fit rounded-2 d-flex gap-2 align-items-center bg-dark justify-content-center"
                                                style="background-color: #55acee" href="/auth/github/redirect">
                                                <i class="fa-brands fa-github"></i>Github</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                                style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-ill.jpg');
          background-size: cover;">
                                <span class="mask bg-gradient-primary opacity-6"></span>
                                <h4 class="mt-5 text-white font-weight-bolder position-relative">"Cập nhật tin tức mới nhất
                                    tại Quin News"
                                </h4>
                                <p class="text-white position-relative">Tin tức mới nhất, nóng nhất được cập nhật thường
                                    xuyên, đừng bỏ lỡ bất kì tin gì nhé!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
@push('js2')
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
@endpush
