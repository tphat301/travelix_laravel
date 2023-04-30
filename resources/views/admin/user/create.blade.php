@extends("admin.index")

@section("title", "Thêm thành viên")

@section("content")
<div class="container-fluid pt-4 px-4">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i><strong>{{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('danger'))
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i><strong>{{ session('danger') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    {!! Form::open(['url' => ['admin/user/create/store'], 'class' => ['card__form'], 'files' => true]) !!}
        @csrf
        <div class="row g-4">
            <div class="col-sm-12 col-xl-6">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">Cập nhật thành viên</h6>
                    <div class="mb-3">
                        {!! Form::label('name', 'Họ và Tên:', ['class'=>['card__label--name','col-sm-2', 'col-form-label']]); !!}
                        {!! Form::text('name', '', ['class'=>['card__name', 'form-control'],'placeholder'=>'Nhập họ và tên...']) !!}
                        @error('name')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        {!! Form::label('username', 'Tài khoản:', ['class'=>['card__label--username','col-sm-2', 'col-form-label']]); !!}
                        {!! Form::text('username', '', ['class'=>['card__username', 'form-control'] ,'placeholder'=>'Nhập tài khoản']) !!}
                        @error('username')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        {!! Form::label('email', 'Tài khoản:', ['class'=>['card__label--email','col-sm-2', 'col-form-label']]); !!}
                        {!! Form::text('email', '', ['class'=>['card__email', 'form-control'] ,'placeholder'=>'Nhập email']) !!}
                        @error('email')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        {!! Form::label('password', 'Mật khẩu:', ['class'=>['card__label--password','col-sm-2', 'col-form-label']]); !!}
                        {!! Form::password('password' ,['class'=>['card__password', 'card__username', 'form-control'] ,'placeholder'=>'Nhập mật khẩu...', 'type'=>'password']) !!}
                        @error('password')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        {!! Form::label('password', 'Xác nhận mật khẩu:', ['class'=>['card__label--password','col-sm-2', 'col-form-label']]); !!}
                        {!! Form::password('password_confirmation', ['class'=>['card__password--confirmation', 'card__username', 'form-control'] ,'placeholder'=>'Xác nhận mật khẩu...']) !!}
                        @error('password_confirmation')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    {!! Form::submit("Thêm", ["class"=>["btn-update", "btn", "btn-primary", "card__btn--update", "mt-[12px]", "p-[12px]", "rounded", "text-white"], "type"=>"submit"]) !!}
                </div>
            </div>
            <div class="col-sm-12 col-xl-6 bg-secondary">
                <img src="{{ asset('public/backend/img/img_error.png') }}" class="card__img">
                {!! Form::file('photo', ['class' => ['card__file', 'form-control', 'bg-dark', 'mt-2']]) !!}
            </div>
        </div>
    {!! Form::close() !!}
</div>
@endsection