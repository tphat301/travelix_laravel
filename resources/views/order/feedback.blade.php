@extends("welcome")

@section("title", "Đặt hàng thành công")

@section("content")
<div class="container bx__cart">
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
    <h3 class="text-center">Cám ơn quý khách đã đặt hàng trên hệ thống của chúng tôi</h3>
    <h3 class="text-center">Đội ngũ chăm sóc khách hàng sẽ sớm liên hệ với quý khách để xác nhận đơn hàng</h3>
    @if ($fullname || $email || $address || $phone || $note)
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Tên khách hàng</th>
                    <th scope="col">Địa chỉ</th>
                    <th scope="col">Email</th>
                    <th scope="col">Số điện thoại</th>
                    <th scope="col">Ghi chú</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><span>{{ $fullname }}</span></td>
                    <td><span>{{ $address }}</span></td>
                    <td><span>{{ $email }}</span></td>
                    <td><span>{{ $phone }}</span></td>
                    <td><span><?=$note ? $note : ''?></span></td>
                </tr>
            </tbody>
        </table>
    @endif
        <div class="customer__info">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Hình ảnh</th>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Mã sản phẩm</th>
                        <th scope="col">Thương hiệu</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @if (Cart::total() > 0)
                        @php
                            $count = 0;
                        @endphp
                        @foreach (Cart::content() as $k => $v)    
                        @php
                            $count++;
                        @endphp
                            <tr>
                                <th scope="row">{{ $count }}</th>
                                <td><img class="rounded" src="{{ asset('public/backend/uploads/'.$v->options->photo) }}" alt="{{ $v->name }}" style="width: 90px"></td>
                                <td>{{ $v->name }}</td>
                                <td>{{ $v->options->code }}</td>
                                <td>{{ $v->options->brand }}</td>
                                <td>{{ number_format($v->price, 0,",", ".") }}VND</td>
                                <td><span>{{ $v->qty }}</span></td>
                                <td><span class="subtotal-{{ $v->id }}">{{ number_format($v->subtotal, 0,",", ".") }}VND</span></td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <span class="total d-block">Tổng tiền: <strong>{{ number_format(Cart::total(), 0,",", ".") }}VND</strong></span>
        <div>Quay lại: <a href="{{ url('/order/reset') }}" class="text-primary text-decoration-none mt-2">Trang chủ</a> để tiếp tục dịch vụ</div>
</div>
@endsection