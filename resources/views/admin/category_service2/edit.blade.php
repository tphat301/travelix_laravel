@extends("admin.index")

@section("title", "Cập nhật danh mục")

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
    {!! Form::open(['url' => ['admin/category_service2/store/'.$categoryServiceLevel2ById->id], 'class' => ['card__form'], 'files' => true]) !!}
        @csrf
        <div class="row g-4">
            <div class="col-sm-12 col-xl-6">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">Cập nhật danh mục cấp 2</h6>
                    <div class="mb-3">
                        {!! Form::label('slug', 'Tên đường dẫn:', ['class'=>['card__label--slug','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::text('slug', $categoryServiceLevel2ById->slug, ['class'=>['card__slug', 'slug__type', 'form-control'] ,'placeholder'=>'Tên đường dẫn']) !!}
                        @error('slug')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        {!! Form::label('name', 'Tên dịch vụ:', ['class'=>['card__label--name','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::text('name', $categoryServiceLevel2ById->name, ['class'=>['card__name', 'name__type', 'form-control'] ,'placeholder'=>'Tên dịch vụ']) !!}
                        @error('name')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        {!! Form::label('brand', 'Tên thương hiệu:', ['class'=>['card__label--brand','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::text('brand', $categoryServiceLevel2ById->brand, ['class'=>['card__brand', 'brand__type', 'form-control'] ,'placeholder'=>'Tên thương hiệu']) !!}
                        @error('brand')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    {{-- <div class="mb-3">
                        {!! Form::label('desc', 'Mô tả:', ['class'=>['card__label--desc','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::textarea('desc', $categoryServiceLevel2ById->desc, ['class' => ['medium_text','card__desc'], 'placeholder' => 'Mô tả sản phẩm']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('content', 'Nội dung:', ['class'=>['card__label--content','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::textarea('content', $categoryServiceLevel2ById->content, ['class' => ['medium_text','card__content'], 'placeholder' => 'Nội dung sản phẩm']) !!}
                    </div> --}}
                    {!! Form::submit("Cập nhật", ["class"=>["btn-update", "card__btn--service","btn", "btn-danger" ,"mt-[12px]", "p-[12px]", "rounded", "text-white"], "type"=>"submit"]) !!}
                </div>
            </div>
            <div class="col-sm-12 col-xl-6 bg-secondary">
                <div class="mb-3">
                    <h3 class="mb-2 mt-2 text-center uppercase">Danh mục</h3>
                    <div class="row">
                        <select name="parent_id" id="choose_category" class="form-select col-md-6 col-lg-6 col-xl-6 col-6 select-cat-2">
                        <option value="">Chọn danh mục cấp 1</option>
                            @foreach ($categoryServiceLevel1 as $v1)
                                <option value="{{ $v1->id }}">{{ $v1->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <h3 class="mb-2 mt-2 text-center uppercase">Hình ảnh</h3>
                    @if ($categoryServiceLevel2ById->photo)
                        <img src="{{ asset('public/backend/uploads/'.$categoryServiceLevel2ById->photo) }}" class="card__img card__img--dev">
                    @else
                        <img src="{{ asset('public/backend/img/img_error.png') }}" class="card__img card__img--dev">
                    @endif
                    {!! Form::file('photo',['class' => ['card__file', 'form-control','bg-dark', 'mt-2']]) !!}
                </div>
                {{-- <div class="mb-3">
                    <h3 class="mb-2 mt-2 text-center uppercase">Hình ảnh 2</h3>
                    @if ($categoryServiceLevel2ById->photo1)
                        <img src="{{ asset('public/backend/uploads/'.$categoryServiceLevel2ById->photo1) }}" class="card__img1 card__img--dev">
                    @else
                        <img src="{{ asset('public/backend/img/img_error.png') }}" class="card__img1 card__img--dev">
                    @endif
                    {!! Form::file('photo1', ['class' => ['card__file1', 'form-control','bg-dark', 'mt-2']]) !!}
                </div>
                <div class="mb-3">
                    <h3 class="mb-2 mt-2 text-center uppercase">Hình ảnh 3</h3>
                    @if ($categoryServiceLevel2ById->photo2)
                        <img src="{{ asset('public/backend/uploads/'.$categoryServiceLevel2ById->photo2) }}" class="card__img2 card__img--dev">
                    @else
                        <img src="{{ asset('public/backend/img/img_error.png') }}" class="card__img2 card__img--dev">
                    @endif
                    {!! Form::file('photo2', ['class' => ['card__file2', 'form-control','bg-dark', 'mt-2']]) !!}
                </div> --}}
            </div>
        </div>
    {!! Form::close() !!}
</div>
@include("admin.layout.tiny")
@endsection