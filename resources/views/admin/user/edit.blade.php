@extends("admin.index")

@section("title", "Cập nhật thành viên")

@section("content")
    <div class="container-fluid pt-4 px-4">
        {!! Form::open(['url' => ['admin/user/store/'.$userById->id], 'class' => ['card__form'], 'files' => true]) !!}
            @csrf
            @method('PUT')
            <div class="row g-4">
                <div class="col-sm-12 col-xl-6">
                    <div class="bg-secondary rounded h-100 p-4">
                        <h6 class="mb-4">Cập nhật thành viên</h6>
                        <div class="mb-3">
                            {!! Form::label('name', 'Họ và Tên:', ['class'=>['card__label--name','col-sm-2', 'col-form-label']]); !!}
                            {!! Form::text('name', $userById->name, ['class'=>['card__name', 'form-control'],'placeholder'=>'Nhập họ và tên...']) !!}
                            @error('name')
                                <small class="text-red-700">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            {!! Form::label('username', 'Tài khoản:', ['class'=>['card__label--username','col-sm-2', 'col-form-label']]); !!}
                            {!! Form::text('username', $userById->username, ['class'=>['card__username', 'form-control'] ,'placeholder'=>'Nhập tài khoản']) !!}
                            @error('username')
                                <small class="text-red-700">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            {!! Form::label('password', 'Mật khẩu cũ:', ['class'=>['card__label--password','col-sm-2', 'col-form-label']]); !!}
                            {!! Form::password('password' ,['class'=>['card__password', 'card__username', 'form-control'] ,'placeholder'=>'Nhập mật khẩu cũ...', 'type'=>'password']) !!}
                            @error('password')
                                <small class="text-red-700">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            {!! Form::label('password', 'Cập nhật mật khẩu:', ['class'=>['card__label--password','col-sm-2', 'col-form-label']]); !!}
                            {!! Form::password('password_confirmation', ['class'=>['card__password--confirmation', 'card__username', 'form-control'] ,'placeholder'=>'Cập nhật mật khẩu...']) !!}
                            @error('password_confirmation')
                                <small class="text-red-700">{{ $message }}</small>
                            @enderror
                        </div>
                        {!! Form::submit("Cập Nhật", ["class"=>["btn-update", "btn", "btn-primary", "card__btn--update", "mt-[12px]", "p-[12px]", "rounded", "text-white"], "type"=>"submit"]) !!}
                    </div>
                </div>
                <div class="col-sm-12 col-xl-6 bg-secondary">
                    @if ($userById->photo)
                        <img src="{{ asset($userById->photo) }}" class="card__img">
                    @else
                        <img src="{{ asset('public/backend/img/img_error.png') }}" class="card__img">
                    @endif
                    {!! Form::file('photo', ['class' => ['card__file', 'form-control', 'bg-dark', 'mt-2']]) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection