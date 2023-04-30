@extends('admin')
@section('title', 'Travelix | Cập nhật mật khẩu')
@section('content')
    <marquee direction="right" class="text-white header-login">Chào mừng bạn đến với trang cập nhật mật khẩu của Travelix</marquee>
<div class="login-box">
    <h2 class="uppercase">Cập nhật mật khẩu</h2>
        <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="user-box">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
            <label for="email">Nhập email của bạn</label>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="user-box">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
            <label for="password">{{ __('Confirm Password') }}</label>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <button type="submit" class="btn-register" href="#">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            {{ __('Reset Password') }}
        </button>
        <div class="text-center mt-8 question-user">
            <span class="text-white">Bạn đã có tài khoản chưa?</span>
            <a href="{{ route('login') }}" class="text-white ml-2">Đăng nhập ngay</a>
        </div>
    </form>
</div>
@endsection

