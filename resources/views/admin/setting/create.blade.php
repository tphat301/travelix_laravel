@extends('admin.index')
@section('title' , "Thiết lập chung")

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
    {!! Form::open(['url' => ['admin/setting/store'.'/'], 'class' => ['card__form'], 'files' => true]) !!}
        @csrf
        <div class="row g-4">
            <div class="col-sm-12 col-xl-6">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">Thiết lập chung</h6>
                    <div class="mb-3">
                        {!! Form::label('zalo', 'Zalo:', ['class'=>['card__label--name','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::text('zalo', '', ['class'=>['card__name', 'card__zalo', 'form-control'] ,'placeholder'=>'Zalo']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('call', 'Điện thoại:', ['class'=>['card__label--name','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::number('call', '', ['class'=>['card__name', 'card__call', 'form-control'] ,'placeholder'=>'Điện thoại']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('hotline', 'Liên hệ:', ['class'=>['card__label--name','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::number('hotline', '', ['class'=>['card__name', 'card__call', 'form-control'] ,'placeholder'=>'Liên hệ']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('messager', 'Messager', ['class'=>['card__label--name','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::text('messager', '', ['class'=>['card__name', 'card__messager', 'form-control'] ,'placeholder'=>'Messager']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('map', 'Bản đồ:', ['class'=>['card__label--desc','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::textarea('map', '', ['class' => ['form-control','card__desc'], 'placeholder' => 'Bản đồ']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('fanpage', 'Fanpage:', ['class'=>['card__label--desc','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::textarea('fanpage', '', ['class' => ['form-control','card__desc'], 'placeholder' => 'Fanpage']) !!}
                    </div>
                    {!! Form::submit("Thêm", ["class"=>["btn-create", "card__btn--service","btn", "btn-danger" ,"mt-[12px]", "p-[12px]", "rounded", "text-white"], "type"=>"submit"]) !!}
                </div>
            </div>
            <div class="col-sm-12 col-xl-6 bg-secondary">
                <div class="mb-3">
                    {!! Form::label('name', 'Tên công ty:', ['class'=>['card__label--name','col-sm-4', 'col-form-label']]); !!}
                    {!! Form::text('name', '', ['class'=>['card__name', 'card__call', 'form-control'] ,'placeholder'=>'Tên công ty']) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label('worktime', 'Thời gian làm việc:', ['class'=>['card__label--name','col-sm-4', 'col-form-label']]); !!}
                    {!! Form::text('worktime', '', ['class'=>['card__name', 'card__call', 'form-control'] ,'placeholder'=>'Thời gian làm việc']) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label('address', 'Địa chỉ:', ['class'=>['card__label--name','col-sm-4', 'col-form-label']]); !!}
                    {!! Form::text('address', '', ['class'=>['card__name', 'card__call', 'form-control'] ,'placeholder'=>'Địa chỉ']) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label('copyright', 'Copyright:', ['class'=>['card__label--name','col-sm-4', 'col-form-label']]); !!}
                    {!! Form::text('copyright', '', ['class'=>['card__name', 'card__call', 'form-control'] ,'placeholder'=>'Copyright']) !!}
                </div>
            </div>
        </div>
    {!! Form::close() !!}
</div>
@include("admin.layout.tiny")
@endsection