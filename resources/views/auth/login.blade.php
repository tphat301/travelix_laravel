@extends('admin')
@section('title', 'Travelix | Đăng nhập')
@section('content')
 <marquee direction="right" class="text-white header-login">Chào mừng bạn đến với trang đăng nhập của Travelix</marquee>
<div class="login-box">
  <h2 class="uppercase animate-charcter">Đăng nhập</h2>
  <form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="user-box">
        <input type="text" class="@error('username') is-invalid @enderror username__login" name="username" id="username" value="{{ old('username') }}" required autocomplete="off" autofocus="off">
        <label for="username">Tài khoản</label>
        @error('username')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="user-box">
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="off">
        <label for="password">Mật khẩu</label>
    </div>
    <div class="">
        <div class="flex pr-8">
            <input class="form-check-input mr-2" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="save-password text-white" for="remember">
                Ghi nhớ
            </label>
        </div>
        @if (Route::has('password.request'))
            <div class="text-center repassword-dev">
                <a class=" text-white" href="{{ route('password.request') }}">
                    Quên mật khẩu?
                </a>
            </div>
        @endif
    </div>
    <button type="submit" class="btn-login" href="#">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        Đăng nhập
    </button>
    <div class="text-center mt-8 question-user">
        <span class="text-white">Bạn đã có tài khoản chưa?</span>
        <a href="{{ route('register') }}" class="text-white ml-2">Đăng ký ngay</a>
    </div>
    <div class="text-center choose-login">
        <span class="text-white">
            Hoặc đăng nhập bằng
        </span>
    </div>
    <div class="flex items-center justify-center"> 
        <svg class="svg-gg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48"><defs><path id="a" d="M44.5 20H24v8.5h11.8C34.7 33.9 30.1 37 24 37c-7.2 0-13-5.8-13-13s5.8-13 13-13c3.1 0 5.9 1.1 8.1 2.9l6.4-6.4C34.6 4.1 29.6 2 24 2 11.8 2 2 11.8 2 24s9.8 22 22 22c11 0 21-8 21-22 0-1.3-.2-2.7-.5-4z"/></defs><clipPath id="b"><use xlink:href="#a" overflow="visible"/></clipPath><path clip-path="url(#b)" fill="#FBBC05" d="M0 37V11l17 13z"/><path clip-path="url(#b)" fill="#EA4335" d="M0 11l17 13 7-6.1L48 14V0H0z"/><path clip-path="url(#b)" fill="#34A853" d="M0 37l30-23 7.9 1L48 0v48H0z"/><path clip-path="url(#b)" fill="#4285F4" d="M48 48L17 24l-4-3 35-10z"/></svg>
        <a href="{{ url('/get-info-google-login') }}" class="text-white ml-4 google uppercase">Google</a>
    </div>
</form>
</div>
@endsection
