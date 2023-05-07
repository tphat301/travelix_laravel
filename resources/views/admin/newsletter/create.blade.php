@extends('admin.index')
@section('title' , "Thêm đăng ký mới")

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
    {!! Form::open(['url' => ['admin/news/store'.'/'], 'class' => ['card__form'], 'files' => true]) !!}
        @csrf
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">Thêm đăng ký mới</h6>
                    <div class="mb-3">
                        {!! Form::label('fullname', 'Họ tên:', ['class'=>['card__label--name','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::text('fullname', '', ['class'=>['card__name', 'fullname', 'form-control'] ,'placeholder'=>'Họ tên']) !!}
                        @error('fullname')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        {!! Form::label('email', 'Họ tên:', ['class'=>['card__label--name','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::text('email', '', ['class'=>['card__name', 'email', 'form-control'] ,'placeholder'=>'E-mail']) !!}
                        @error('email')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        {!! Form::label('phone', 'Số điện thoại', ['class'=>['card__label--name','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::number('phone', '', ['class'=>['card__name', 'phone', 'form-control'] ,'placeholder'=>'Số điện thoại']) !!}
                        @error('phone')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        {!! Form::label('address', 'Địa chỉ:', ['class'=>['card__label--address','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::text('address', '', ['class'=>['card__address', 'address', 'form-control'] ,'placeholder'=>'Địa chỉ']) !!}
                        @error('address')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        {!! Form::label('notes', 'Ghi chú:', ['class'=>['card__label--desc','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::textarea('notes', '', ['class' => ['form-control','card__desc'], 'placeholder' => 'Ghi chú']) !!}
                    </div>
                    {!! Form::submit("Thêm", ["class"=>["btn-create", "card__btn--service","btn", "btn-danger" ,"mt-[12px]", "p-[12px]", "rounded", "text-white"], "type"=>"submit"]) !!}
                </div>
            </div>
            {{-- <div class="col-sm-12 col-xl-6 bg-secondary">
                <div class="mb-3">
                    <h3 class="mb-2 mt-2 text-center uppercase">Hình ảnh</h3>
                    <img src="{{ asset('public/backend/img/img_error.png') }}" class="card__img card__img--dev">
                    {!! Form::file('photo', ['class' => ['card__file', 'form-control','bg-dark', 'mt-2']]) !!}
                </div>
                <div class="mb-3">
                    <h3 class="mb-2 mt-2 text-center uppercase">Hình ảnh 2</h3>
                    <img src="{{ asset('public/backend/img/img_error.png') }}" class="card__img1 card__img--dev">
                    {!! Form::file('photo1', ['class' => ['card__file1', 'form-control','bg-dark', 'mt-2']]) !!}
                </div>
                <div class="mb-3">
                    <h3 class="mb-2 mt-2 text-center uppercase">Hình ảnh 3</h3>
                    <img src="{{ asset('public/backend/img/img_error.png') }}" class="card__img2 card__img--dev">
                    {!! Form::file('photo2', ['class' => ['card__file2', 'form-control','bg-dark', 'mt-2']]) !!}
                </div>
                <div class="mb-3 upload">
                    <div class="upload__box">
                        <div class="upload__btn-box">
                            <label class="upload__btn">
                            <p>Thư viện ảnh</p>
                            {!! Form::file('gallery[]', ['class' => ['card__file2', 'form-control','bg-dark', 'mt-2', 'upload__inputfile'], 'multiple', "data-max_length=20"]) !!}
                            </label>
                        </div>
                        <div class="upload__img-wrap"></div>
                    </div>
                </div> 
            </div>--}}
        </div>
    {!! Form::close() !!}
</div>
@include("admin.layout.tiny")
@endsection