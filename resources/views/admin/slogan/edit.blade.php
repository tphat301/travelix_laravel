@extends("admin.index")

@section("title", "Cập nhật slogan")

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
    {!! Form::open(['url' => ['admin/slogan/store/'.$sloganBySlug->slug], 'class' => ['card__form'], 'files' => true]) !!}
        @csrf
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">Cập nhật slogan</h6>
                    <div class="mb-3">
                        {!! Form::label('slug', 'Tên đường dẫn:', ['class'=>['card__label--slug','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::text('slug', $sloganBySlug->slug, ['class'=>['card__slug', 'slug__type', 'form-control'] ,'placeholder'=>'Tên đường dẫn']) !!}
                        @error('slug')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        {!! Form::label('slogan', 'Tiêu đề:', ['class'=>['card__label--name','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::text('slogan', $sloganBySlug->slogan, ['class'=>['card__name', 'name__type', 'form-control'] ,'placeholder'=>'Tiêu đề']) !!}
                        @error('slogan')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    {!! Form::submit("Cập nhật", ["class"=>["btn-update", "card__btn--service","btn", "btn-danger" ,"mt-[12px]", "p-[12px]", "rounded", "text-white"], "type"=>"submit"]) !!}
                </div>
            </div>
        </div>
    {!! Form::close() !!}
</div>
@include("admin.layout.tiny")
@endsection