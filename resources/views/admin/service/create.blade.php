@extends('admin.index')
@section('title' , "Thêm dịch vụ")

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
    {!! Form::open(['url' => ['admin/service/store'.'/'], 'class' => ['card__form'], 'files' => true]) !!}
        @csrf
        <div class="row g-4">
            <div class="col-sm-12 col-xl-6">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">Thêm {{ __('Service') }}</h6>
                    <div class="mb-3">
                        {!! Form::label('slug', 'Tên đường dẫn:', ['class'=>['card__label--slug','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::text('slug', '', ['class'=>['card__slug', 'slug__type', 'form-control'] ,'placeholder'=>'Tên đường dẫn']) !!}
                        @error('slug')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        {!! Form::label('name', 'Tiêu đề:', ['class'=>['card__label--name','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::text('name', '', ['class'=>['card__name', 'name__type', 'form-control'] ,'placeholder'=>'Tiêu đề']) !!}
                        @error('name')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        {!! Form::label('brand', 'Tên thương hiệu:', ['class'=>['card__label--brand','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::text('brand', '', ['class'=>['card__brand', 'brand__type', 'form-control'] ,'placeholder'=>'Tên thương hiệu']) !!}
                        @error('brand')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        {!! Form::label('price', 'Giá tiền:', ['class'=>['card__label--price','col-form-label']]); !!}
                        {!! Form::number('price', '', ['class'=>['form-control', 'card__price', 'sale_price'] ,'placeholder'=>'Giá tiền']) !!}
                        @error('price')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        {!! Form::label('price_old', 'Giá cũ:', ['class'=>['card__label--priceOld','col-form-label']]); !!}
                        {!! Form::number('price_old', '', ['class'=>['form-control', 'price__old', 'regular_price'] ,'placeholder'=>'Giá cũ']) !!}
                        @error('price_old')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        {!! Form::label('discount', 'Giảm giá:', ['class'=>['card__label--discount','col-form-label']]); !!}
                        {!! Form::number('discount', '', ['class'=>['form-control', 'card__discount', 'discount'] ,'placeholder'=>'Giảm giá', 'readonly'=>'readonly']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('code', 'Mã dịch vụ:', ['class'=>['card__label--username','col-form-label']]); !!}
                        {!! Form::text('code', '', ['class'=>['form-control', 'card__code'] ,'placeholder'=>'Mã dịch vụ']) !!}
                        @error('code')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        {!! Form::label('qty', 'Số lượng dịch vụ:', ['class'=>['card__label--username','col-form-label']]); !!}
                        {!! Form::text('qty', '', ['class'=>['form-control', 'card__code'] ,'placeholder'=>'Số lượng dịch vụ']) !!}
                        @error('qty')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        {!! Form::label('desc', 'Mô tả:', ['class'=>['card__label--desc','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::textarea('desc', '', ['class' => ['medium_text','card__desc'], 'placeholder' => 'Mô tả sản phẩm']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('content', 'Nội dung:', ['class'=>['card__label--content','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::textarea('content', '', ['class' => ['medium_text','card__content'], 'placeholder' => 'Nội dung sản phẩm']) !!}
                    </div>
                    {!! Form::submit("Thêm", ["class"=>["btn-create", "card__btn--service","btn", "btn-danger" ,"mt-[12px]", "p-[12px]", "rounded", "text-white"], "type"=>"submit"]) !!}
                </div>
            </div>
            <div class="col-sm-12 col-xl-6 bg-secondary">
                <div class="mb-3">
                    <h3 class="mb-2 mt-2 text-center uppercase">Hình ảnh 1</h3>
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
            </div>
        </div>
    {!! Form::close() !!}
</div>
@include("admin.layout.tiny")
@endsection