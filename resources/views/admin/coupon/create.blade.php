@extends('admin.index')
@section('title' , __('Create coupon'))

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
    {!! Form::open(['url' => ['admin/coupon/store'.'/'], 'class' => ['card__form'], 'files' => true]) !!}
        @csrf
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">{{ __('Create coupon') }}</h6>
                    <div class="mb-3">
                        <select class="form-select" name="discount_form" aria-label="Default select example">
                            <option selected>Hình thức giảm giá</option>
                            <option value="price">Giảm theo giá</option>
                            <option value="percent">Giảm theo phần trăm</option>
                        </select>
                        @error('discount')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <select class="form-select" name="code_product" aria-label="Default select example">
                            <option selected>Mã dịch vụ</option>
                            @foreach ($codeByServices as $kcode => $vcode)
                                <option value="{{ $vcode->code }}">{{ $vcode->code }}</option>
                            @endforeach
                        </select>
                        @error('code_product')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        {!! Form::label('code', 'Mã giảm giá:', ['class'=>['card__label--name','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::text('code', '', ['class'=>['card__name', 'name__type', 'form-control'] ,'placeholder'=>'Mã giảm giá']) !!}
                        @error('code')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        {!! Form::label('discount', 'Chỉ số giảm:', ['class'=>['card__label--brand','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::text('discount', '', ['class'=>['card__brand', 'brand__type', 'form-control'] ,'placeholder'=>'Chỉ số giảm']) !!}
                        @error('discount')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        {!! Form::label('qty', 'Số lượng:', ['class'=>['card__label--brand','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::text('qty', '', ['class'=>['card__brand', 'brand__type', 'form-control'] ,'placeholder'=>'Số lượng']) !!}
                        @error('qty')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    {!! Form::submit("Thêm", ["class"=>["btn-create", "card__btn--coupon","btn", "btn-danger" ,"mt-[12px]", "p-[12px]", "rounded", "text-white"], "type"=>"submit"]) !!}
                </div>
            </div>
        </div>
    {!! Form::close() !!}
</div>
@endsection