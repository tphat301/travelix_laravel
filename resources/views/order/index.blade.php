@extends("welcome")

@section("title", "Danh sách giỏ hàng")

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
    <h3 class="cart__title">Giỏ hàng</h3>
    <form action="{{ url('/order/update') }}" method="POST">
        @csrf
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
                    <th scope="col">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @if (Cart::total() > 0)
                    @php
                        $count = 0;
                    @endphp
                    @foreach ($orders as $k => $v)    
                    @php
                        $count++;
                    @endphp
                        <tr class="cart__main-{{ $v->rowId }}">
                            <th scope="row">{{ $count }}</th>
                            <td><img class="rounded" src="{{ asset($v->options->photo) }}" alt="{{ $v->name }}" style="width: 90px"></td>
                            <td>{{ $v->name }}</td>
                            <td>{{ $v->options->code }}</td>
                            <td>{{ $v->options->brand }}</td>
                            <td>@if (session('coupon') && $v->options->code === session('coupon')->code_product)
                                {{ number_format(($v->price)*(session('coupon')->options/100), 0,",", ".") }}VND
                            @else
                                {{ number_format($v->price, 0,",", ".") }}VND
                            @endif</td>
                            <td><input type="number" class="qty__cart qty-{{ $v->id }}" data-price="{{ $v->price }}" rowId="{{ $v->rowId }}" data-id="{{ $v->id }}" name="qty[{{ $v->rowId }}]" min="1" value="{{ $v->qty }}"></td>
                            <td><span class="subtotal-{{ $v->id }}">{{ number_format($v->subtotal, 0,",", ".") }}VND</span></td>
    
                            <td>
                                <span class="remove__cart" data-qty="{{ $v->qty }}" data-rowid="{{ $v->rowId }}" style="cursor: pointer">Xóa</span>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="12"><span class="text-danger">Không có sản phẩm trong giỏ</span></td></tr>
                @endif
            </tbody>
        </table>
        <tr id="total__cart">Tổng tiền:<span class="total d-block">{{ number_format(Cart::total(), 0,",", ".") }}VND</span></tr>
        <input type="submit" name="btn-cart" class="mt-3" value="Cập Nhật">
    </form>

    <form action="{{ url('/order/coupon') }}" class="mt-3 row" method="POST">
    @csrf
        <div class="form-group mb-0 col-10">
            <input type="text" class="form-control " name="code" placeholder="Nhập mã giảm giá">
        </div>
        <input type="submit" class="btn btn-primary btn-coupon col-2" value="GỬI" disabled>
    </form>

    <form action="{{ url('/order/checkout/store') }}" class="form__checkout mt-4" method="POST">
        @csrf
        <div class="form-group">
            <select name="choose_checkout"  class="form-select mb-2" id="select__checkout">
                <option value="" selected>Chọn hình thức thanh toán</option>
                <option value="vnpay">Thanh toán Vnpay</option>
                <option value="momo">Thanh toán Momo</option>
                <option value="normal">Thanh toán Bình Thường</option>
            </select>
        </div>
        <div class="form-group">
            <input type="text" name="fullname" class="form-control mb-2" placeholder="Họ và Tên">
            @error('fullname')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            <input type="text" name="email" class="form-control mb-2" placeholder="Email">
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <input type="text" name="phone" class="form-control mb-2" placeholder="Số điện thoại">
            @error('phone')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            <textarea name="address" id="" class="form-control mb-2" placeholder="Địa chỉ"></textarea>
            @error('address')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            <textarea name="notes" id="" class="form-control" placeholder="Ghi chú"></textarea>
        </div>

        <input type="submit" class="btn-checkout btn btn-primary mt-2 mb-2" name="btn-checkout" value="Đặt Hàng" disabled><br>
        <div>Quay lại: <a href="{{ url('/') }}" class="text-primary text-decoration-none">Trang chủ</a></div>
    </form>
</div>
@endsection