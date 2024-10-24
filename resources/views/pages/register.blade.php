@extends('layouts.rootLayout')
@section('viewTitle')
    Đăng ký tài khoản
@endsection
@section('body')
    <main class="main-content  mt-0 ">

        <section class="position-relative">
            <div class="page-header min-vh-100">
                <a href="{{ route('home') }}" class=" position-absolute" style="top: 20px; left:30px">
                    <img width="94px" src="{{ asset('assets/images/logo/logo.png') }}" alt="">
                </a>
                <div class="container">
                    <div class="row">
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
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start bg-transparent">
                                    <h4 class="font-weight-bolder">Đăng Ký</h4>
                                    <p class="mb-0">Đăng ký 1 tài khoản mới trên Quin </p>
                                </div>
                                <div class="card-body">
                                    <form role="form" method="post" action="{{route('_register')}}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="">Email</label>
                                            <input type="email" name="email" class="form-control form-control-lg"
                                                placeholder="Email" value="{{ old('email') }}" aria-label="Email">
                                        </div>
                                        @error('email')
                                            <div class="w-100 ">
                                                <small class="text-danger ">{{ $message }}</small>
                                            </div>
                                        @enderror
                                        <div class="mb-3">
                                            <label for="">Mật khẩu</label>
                                            <input type="password" class="form-control form-control-lg"
                                                placeholder="Password" value="{{ old('password') }}" name="password"
                                                aria-label="Password">
                                        </div>
                                        @error('password')
                                            <div class="w-100 ">
                                                <small class="text-danger ">{{ $message }}</small>
                                            </div>
                                        @enderror
                                        <div class="mb-3">
                                            <label for="">Xác nhận mật khẩu</label>
                                            <input type="password" class="form-control form-control-lg"
                                                placeholder="Password confirm" value="{{ old('password_confirmation') }}"
                                                name="password_confirmation" aria-label="Password">
                                        </div>
                                        @error('password_confirmation')
                                            <div class="w-100 ">
                                                <small class="text-danger ">{{ $message }}</small>
                                            </div>
                                        @enderror

                                        @if (session('message'))
                                            <div class="w-100 ">
                                                <small class="text-danger ">{{ session('message') }}</small>
                                            </div>
                                        @endif

                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Đăng ký</button>
                                        </div>
                                    </form>
                                    <div>
                                        <p class="mb-4 text-sm mx-auto text-center mt-5">
                                            Bạn đã có tài khoản? <a href="{{ route('login') }}"
                                                class="text-primary fw-bold ms-1">Đăng nhập</a>
                                        </p>
                                    </div>
                                    <div class="card-footer text-center pt-0 px-lg-2 px-1 mt-3">

                                        <div class="my-5 border-bottom position-relative">
                                            <div class="d-flex justify-content-center position-absolute end-0 start-0"
                                                style="bottom:-12px"><span class="px-3"
                                                    style="font-size: 14px; background-color:#f8f9fa">Or</span></div>
                                        </div>
                                        <div class="w-100 d-flex flex-column gap-3">
                                            <a class="btn btn-primary btn-lg btn-block w-100 d-flex gap-2 align-items-center justify-content-center"
                                                style="background-color: #DB4437" href="/auth/google/redirect"
                                                role="button">
                                                <i class="fa-brands fa-google"></i>Tiếp tục với Goolge
                                            </a>
                                            <a class="btn btn-primary btn-lg btn-block w-100 d-flex gap-2 align-items-center bg-dark justify-content-center"
                                                style="background-color: #55acee" href="/auth/github/redirect"
                                                role="button">
                                                <i class="fa-brands fa-github"></i>Tiếp tục với Github</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
