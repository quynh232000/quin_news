@extends('layouts.rootLayout')
@section('viewTitle')
    Đăng nhập
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
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start bg-transparent">
                                    <h4 class="font-weight-bolder">Thay đổi mật khẩu mật khẩu</h4>
                                    <p class="mb-0">Tiến hành cập nhật mật khẩu mới </p>

                                </div>
                                @if ($check_token == false)
                                    <div class="card-body">
                                        <div class="alert alert-danger text-white p-5">
                                            Token đã hết hạn, vui lòng đăng nhập lại để tiếp tục.
                                        </div>

                                    </div>
                                @else
                                    <div class="card-body">
                                        <form role="form" method="POST"
                                            action="{{ route('_forgotpassword_token', ['token' => $token]) }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="">Mật khẩu mới</label>
                                                <input type="password" name="password" class="form-control form-control-lg"
                                                    placeholder="Mật khẩu mới" value="{{ old('password') }}"
                                                    aria-label="Email">
                                            </div>
                                            @error('password')
                                                <div class="w-100 ">
                                                    <small class="text-danger ">{{ $message }}</small>
                                                </div>
                                            @enderror
                                            <div class="mb-3">
                                                <label for="">Xác nhận mật khẩu </label>
                                                <input type="password" name="password_confirmation"
                                                    class="form-control form-control-lg" placeholder="Xác nhận mật khẩu "
                                                    value="{{ old('password_confirmation') }}" aria-label="Email">
                                            </div>
                                            @error('password_confirmation')
                                                <div class="w-100 ">
                                                    <small class="text-danger ">{{ $message }}</small>
                                                </div>
                                            @enderror

                                            @if (session('error'))
                                                <div class="w-100 ">
                                                    <small class="text-danger ">{{ session('message') }}</small>
                                                </div>
                                            @endif

                                            <div class="text-center">
                                                <button type="submit"
                                                    class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Cập nhật
                                                </button>
                                            </div>
                                        </form>
                                        <div>
                                            <p class="mb-4 text-sm mx-auto text-center mt-5">
                                                Bạn đã có tài khoản? <a href="{{ route('login') }}"
                                                    class="text-primary fw-bold ms-1">Đăng nhập</a>
                                            </p>
                                        </div>

                                    </div>
                                @endif
                            </div>
                        </div>
                        <div
                            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                                style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-ill.jpg');background-size: cover;">
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
