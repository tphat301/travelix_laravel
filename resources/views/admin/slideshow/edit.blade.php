@extends("admin.index")

@section("title", "Cập nhật slideshow")

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
    {!! Form::open(['url' => ['admin/slideshow/store/'.$slideshowById->id], 'class' => ['card__form'], 'files' => true]) !!}
        @csrf
        <div class="row g-4">
            <div class="col-sm-12 col-xl-6">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">Cập nhật {{ __('Slideshow') }}</h6>
                    <div class="mb-3">
                        {!! Form::label('name', 'Tên slishow:', ['class'=>['card__label--name','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::text('name', $slideshowById->name, ['class'=>['card__name', 'form-control'] ,'placeholder'=>'Tên slishow']) !!}
                        @error('name')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        {!! Form::label('link', 'Link:', ['class'=>['card__label--brand','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::text('link', $slideshowById->link, ['class'=>['card__brand', 'brand__type', 'form-control'] ,'placeholder'=>'Link']) !!}
                        @error('link')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    {!! Form::submit("Cập nhật", ["class"=>["btn-update", "card__btn--service","btn", "btn-danger" ,"mt-[12px]", "p-[12px]", "rounded", "text-white"], "type"=>"submit"]) !!}
                </div>
            </div>
            <div class="col-sm-12 col-xl-6 bg-secondary">
                <div class="mb-3">
                    <h3 class="mb-2 mt-2 text-center uppercase">Hình ảnh</h3>
                    @if ($slideshowById->photo)
                        <img src="{{ asset($slideshowById->photo) }}" class="card__img card__img--dev">
                    @else
                        <img src="{{ asset('public/backend/img/img_error.png') }}" class="card__img card__img--dev">
                    @endif
                    {!! Form::file('photo',['class' => ['card__file', 'form-control','bg-dark', 'mt-2']]) !!}
                </div>
            </div>
        </div>
    {!! Form::close() !!}
</div>
@include("admin.layout.tiny")
@endsection