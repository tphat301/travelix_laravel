@extends("admin.index")

@section("title", "Slogan")

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
        <h6 class="mb-4 uppercase text-center text-[24px]">Slogan</h6>
        <div class="items-center flex">
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Tiêu đề</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Thời gian tạo</th>
                </tr>
            </thead>

            <tbody>
                @if ($slogan)
                    @php
                        $k = 0;
                    @endphp
                        <tr>
                            <td><a href="{{ route('admin.slogan.edit', $slogan->slug) }}">{{ $slogan->slogan }}</a></td>
                            <td>@if ($slogan->status == 'active')
                                <span class="text-success">Đang hoạt động</span>
                                @else
                                <span class="text-danger">Vô hiệu hóa</span>
                            @endif</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $slogan->created_at)->format('d-m-Y H:i:s') }}</td>
                        </tr>
                @else
                    <tr><td colspan="12"><span class="text-red-600 block p-[12px]">Không có dữ liệu</span></td></tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection