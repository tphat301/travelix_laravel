@extends("admin.index")

@section("title", "Chi tiết đơn hàng")

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
    <h3>Chi tiết đơn hàng</h3>
    <table class="table table-hover tbl__customer--order">
        <thead>
            <tr>
                <th scope="col">Tên khách hàng</th>
                <th scope="col">Số điện thoại</th>
                <th scope="col">Email</th>
                <th scope="col">Địa chỉ</th>
                <th scope="col">Mã đơn hàng</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Ghi chú</th>
                <th scope="col">Tổng giá trị đơn hàng</th>
            </tr>
        </thead>

        <tbody>
            @if ($orderByIdConvert)
                <tr class="">
                    <td><span>{{ $orderByIdConvert['fullname'] }}</span></td>
                    <td><span>{{ $orderByIdConvert['phone'] }}</span></td>
                    <td><span>{{ $orderByIdConvert['email'] }}</span></td>
                    <td><span>{{ $orderByIdConvert['address'] }}</span></td>
                    <td><span>{{ $orderByIdConvert['code'] }}</span></td>
                    <td><span>{{ $orderByIdConvert['status'] }}</span></td>
                    <td><span>@if ($orderByIdConvert['notes']) $orderByIdConvert['notes'] @endif</span></td>
                    <td><span class="text-danger">{{ number_format($orderByIdConvert['total'], 0, ",", ".") }} VND</span></td>
                </tr>
            @else
                <tr><td colspan="12"><span class="text-red-600 block p-[12px]">Không có dịch vụ</span></td></tr>
            @endif
        </tbody>
    </table>

    <table class="table table-hover tbl__order">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên mặt hàng</th>
                <th scope="col">Mã số</th>
                <th scope="col">Hình ảnh</th>
                <th scope="col">Số lượng</th>
                <th scope="col">Thương hiệu</th>
                <th scope="col">Giá tiền</th>
            </tr>
        </thead>

        <tbody>
            @if (count($orderByOptionsConvert))
            @php
                $count = 0;
                unset($v)
            @endphp
            @foreach ($orderByOptionsConvert as $k => $v)
                @php
                    $count++;
                @endphp
                <tr>
                    <th scope="row">{{ $count }}</th>
                    <td><span>{{ $v['name'] }}</span></td>
                    <td><span>{{ $v['options']['code'] }}</span></td>
                    <td><img class="thumbs rounded" src="{{ asset($v['options']['photo']) }}" alt=""></td>
                    <td><span>{{ $v['qty'] }}</span></td>
                    <td><span>{{ $v['options']['brand'] }}</span></td>
                    <td><span>{{ number_format($v['price'], 0, ",", ".") }} VND</span></td>
                </tr>
            @endforeach
            @else
                <tr><td colspan="12"><span class="text-red-600 block p-[12px]">Không có dịch vụ</span></td></tr>
            @endif
        </tbody>
    </table>
    <a href="{{ url('admin/order/index') }}">Quay lại</a>
</div>
@endsection