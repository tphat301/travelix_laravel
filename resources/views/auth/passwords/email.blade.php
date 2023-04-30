@extends('admin')
@section('title', 'Travelix | Lấy lại mật khẩu')
@section('content')
    <marquee direction="right" class="text-white header-login">Chào mừng bạn đến với trang lấy lại mật khẩu của Travelix</marquee>
<div class="login-box">
    <h2 class="uppercase">Lấy lại mật khẩu</h2>
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="user-box">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            <label for="email">Nhập email của bạn</label>
            @error('email')
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
            Gửi Yêu Cầu
        </button>
        <div class="text-center mt-8 question-user">
            <span class="text-white">Bạn đã có tài khoản chưa?</span>
            <a href="{{ route('register') }}" class="text-white ml-2">Đăng ký ngay</a>
        </div>
    </form>
</div>
@endsection
