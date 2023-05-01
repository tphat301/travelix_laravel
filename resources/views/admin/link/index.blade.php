@extends("admin.index")

@section("title", "Danh sách link")

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
        <h6 class="mb-4 uppercase text-center text-[24px]">Danh sách link</h6>
        <div class="items-center flex">
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Link</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Thời gian tạo</th>
                    <th scope="col">Thao tác</th>
                </tr>
            </thead>

            <tbody>
                @if ($links->total() > 0)
                    @php
                        $k = 0;
                    @endphp

                    @foreach ($links as $k => $v)    
                        @php
                            $k++;
                        @endphp
                        <tr>
                            <th scope="row">{{ $k }}</th>
                            <td><a href="{{ route('admin.link.edit', $v->id) }}">{{ $v->name }}</a></td>
                            <td>@if ($v->status == 'active')
                                <span class="text-success">Đang hoạt động</span>
                                @else
                                <span class="text-danger">Vô hiệu hóa</span>
                            @endif</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $v->created_at)->format('d-m-Y H:i:s') }}</td>
                            @if ($v->status != 'trash')
                                <td>
                                    <a href="{{ route('admin.link.edit', $v->id) }}" class="text-lime-600 m-[12px]"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="{{ route('admin.link.delete', $v->id) }}"class="text-red-700"><i class="fa-solid fa-trash pointer-events-none"></i></a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="12"><span class="text-red-600 block p-[12px]">Không có link</span></td></tr>
                @endif
            </tbody>
        </table>
    </div>
    {!! $links->links("admin.layout.pagination") !!}
</div>
@endsection