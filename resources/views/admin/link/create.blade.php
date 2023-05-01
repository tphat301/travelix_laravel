@extends('admin.index')
@section('title' , "Thêm link")

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
    {!! Form::open(['url' => ['admin/link/store'.'/'], 'class' => ['card__form'], 'files' => true]) !!}
        @csrf
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">Thêm link</h6>
                    <div class="mb-3">
                        {!! Form::label('link', 'Link:', ['class'=>['card__label--name','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::text('link', '', ['class'=>['card__name', '', 'form-control'] ,'placeholder'=>'Link']) !!}
                        @error('link')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    {!! Form::submit("Thêm", ["class"=>["btn-create", "card__btn--service","btn", "btn-danger" ,"mt-[12px]", "p-[12px]", "rounded", "text-white"], "type"=>"submit"]) !!}
                </div>
            </div>
        </div>
    {!! Form::close() !!}
</div>
@include("admin.layout.tiny")
@endsection