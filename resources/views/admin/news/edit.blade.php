@extends('admin.index')
@section('title' , "Cập nhật tin tức")

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
    {!! Form::open(['url' => ['admin/news/store/'.$newById->id], 'class' => ['card__form'], 'files' => true]) !!}
        @csrf
        <div class="row g-4">
            <div class="col-sm-12 col-xl-6">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">Cập nhật tin tức</h6>
                    <div class="mb-3">
                        {!! Form::label('slug', 'Tên đường dẫn:', ['class'=>['card__label--slug','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::text('slug', $newById->slug, ['class'=>['card__slug', 'slug__type', 'form-control'] ,'placeholder'=>'Tên đường dẫn']) !!}
                        @error('slug')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        {!! Form::label('name', 'Tiêu đề:', ['class'=>['card__label--name','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::text('name', $newById->name, ['class'=>['card__name', 'name__type', 'form-control'] ,'placeholder'=>'Tiêu đề']) !!}
                        @error('name')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    {{-- <div class="mb-3">
                        {!! Form::label('office', 'Chức vụ:', ['class'=>['card__label--office','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::text('office', '', ['class'=>['card__office', 'office__type', 'form-control'] ,'placeholder'=>'Chức vụ']) !!}
                        @error('office')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        {!! Form::label('number', 'Chỉ số:', ['class'=>['card__label--number','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::text('number', '', ['class'=>['card__number', 'number__type', 'form-control'] ,'placeholder'=>'Chỉ số']) !!}
                        @error('number')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        {!! Form::label('slogan', 'Slogan:', ['class'=>['card__label--slogan','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::text('slogan', '', ['class'=>['card__slogan', 'slogan__type', 'form-control'] ,'placeholder'=>'Slogan']) !!}
                        @error('slogan')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        {!! Form::label('address', 'Địa chỉ:', ['class'=>['card__label--address','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::text('address', '', ['class'=>['card__address', 'address__type', 'form-control'] ,'placeholder'=>'Địa chỉ']) !!}
                        @error('address')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        {!! Form::label('view', 'Lượt xem:', ['class'=>['card__label--username','col-form-label']]); !!}
                        {!! Form::text('view', '', ['class'=>['form-control', 'card__view'] ,'placeholder'=>'Lượt xem']) !!}
                        @error('view')
                            <small class="text-red-700">{{ $message }}</small>
                        @enderror
                    </div> --}}
                    <div class="mb-3">
                        {!! Form::label('desc', 'Mô tả:', ['class'=>['card__label--desc','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::textarea('desc', $newById->desc, ['class' => ['medium_text','card__desc'], 'placeholder' => 'Mô tả sản phẩm']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('content', 'Nội dung:', ['class'=>['card__label--content','col-sm-4', 'col-form-label']]); !!}
                        {!! Form::textarea('content', $newById->content, ['class' => ['medium_text','card__content'], 'placeholder' => 'Nội dung sản phẩm']) !!}
                    </div>
                    {!! Form::submit("Cập nhật", ["class"=>["btn-create", "card__btn--service","btn", "btn-danger" ,"mt-[12px]", "p-[12px]", "rounded", "text-white"], "type"=>"submit"]) !!}
                </div>
            </div>
            <div class="col-sm-12 col-xl-6 bg-secondary">
                <div class="mb-3">
                    <h3 class="mb-2 mt-2 text-center uppercase">Danh mục</h3>
                    <div class="row">

                        <select name="parent_id1" id="category_new1" class="form-select col-md-6 col-lg-6 col-xl-6 col-6 select-cat-new category_ajax-new">
                            <option value="">Chọn danh mục cấp 1</option>
                            @foreach ($categoryNewLevel1 as $v1)
                                <option value="{{ $v1->id }}">{{ $v1->name }}</option>
                            @endforeach
                        </select>

                        <select name="parent_id2" id="category_new2" class="form-select col-md-6 col-lg-6 col-xl-6 col-6 select-cat-new">
                            <option value="">Chọn danh mục cấp 2</option>
                            @foreach ($categoryNewLevel2 as $v2)
                                <option value="{{ $v2->id }}">{{ $v2->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <h3 class="mb-2 mt-2 text-center uppercase">Hình ảnh</h3>
                    @if ($newById->photo)
                        <img src="{{ asset('public/backend/uploads/'.$newById->photo) }}" class="card__img card__img--dev">
                    @else
                        <img src="{{ asset('public/backend/img/img_error.png') }}" class="card__img card__img--dev">
                    @endif
                    {!! Form::file('photo', ['class' => ['card__file', 'form-control','bg-dark', 'mt-2']]) !!}
                </div>
                {{-- <div class="mb-3">
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
                </div> --}}
            </div>
        </div>
    {!! Form::close() !!}
</div>
@include("admin.layout.tiny")
@endsection