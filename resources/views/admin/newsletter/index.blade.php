@extends("admin.index")

@section("title", "Danh sách đăng ký")

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
    <div class="bg-secondary rounded h-100 p-4">
        <h6 class="mb-4 uppercase text-center text-[24px]">Danh sách đăng ký nhận tin</h6>
        {!! Form::open(['url' => ['admin/newsletter/action'], 'class' => ['card__body']]) !!}
            @csrf
            <div class="card__body--analytic mb-[12px]">
                <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}" class="card__body--active text-blue-600 mr-[8px]">Đang hoạt động ({{ $countNewsletter[0] }})</a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="card__body--trash text-red-600">Vô hiệu hóa ({{ $countNewsletter[1] }})</a>
            </div>
            <div class="items-center flex">
                <div class="card__body--status rounded inline-block border mr-2">
                    <select class="form-select" name="act" aria-label="Default select example">
                        <option selected>{{ __('Choose action') }}</option>
                        @foreach ($act as $k => $v)
                            <option value="{{ $k }}">{{ $v }}</option>
                        @endforeach
                    </select>
                </div>
                {!! Form::submit('Áp Dụng', ['class' => ['btn', 'btn-primary', 'text-white', ''], 'type' => 'submit','name'=>'btn-action' ,'disabled']) !!}
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th><input class="form-check-input" type="checkbox" value="" id="check__all"></th>
                        <th scope="col">STT</th>
                        <th scope="col">Họ và tên</th>
                        <th scope="col">Email</th>
                        <th scope="col">Số điện thoại</th>
                        <th scope="col">Địa chỉ</th>
                        <th scope="col">Ghi chú</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Thời gian tạo</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>

                <tbody>
                    @if ($newsletters->total() > 0)
                        @php
                            $k = 0;
                        @endphp

                        @foreach ($newsletters as $k => $v)    
                            @php
                                $k++;
                            @endphp
                            <tr>
                                <td>
                                    <input class="form-check-input check__item" type="checkbox" name="check__item[]" value="{{ $v->id }}">
                                </td>
                                <th scope="row">{{ $k }}</th>
                                <td><a href="{{ route('admin.newsletter.edit', $v->id) }}">{{ $v->fullname }}</a></td>
                                <td><span>{{ $v->email }}</span></td>
                                <td><span>{{ substr($v->phone, -10, -7) . "-" . substr($v->phone, -7, -4) . "-" . substr($v->phone, -4); }}</span></td>
                                <td><span>{{ $v->address }}</span></td>
                                <td><p>{!! htmlspecialchars($v->notes)!!}</p></td>
                                <td>@if ($v->status == 'active')
                                    <span class="text-success">Đang hoạt động</span>
                                    @else
                                    <span class="text-danger">Vô hiệu hóa</span>
                                @endif</td>
                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $v->created_at)->format('d-m-Y H:i:s') }}</td>
                                @if ($v->status != 'trash')
                                    <td>
                                        <a href="{{ route('admin.news.edit', $v->id) }}" class="text-lime-600 m-[12px]"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="" data-id="{{ $v->id }}" class="delete__newsletter text-red-700"><i class="fa-solid fa-trash pointer-events-none"></i></a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="12"><span class="text-red-600 block p-[12px]">Không có tin đăng ký nào</span></td></tr>
                    @endif
                </tbody>
            </table>
        {!! Form::close() !!}
        {!! Form::open(['name' => 'delete__form', 'class' => ['card__body']]) !!}
            @csrf
            @method('DELETE')
        {!! Form::close() !!}
        
        
        {!! $newsletters->links("admin.layout.pagination") !!}
    </div>
</div>
@endsection