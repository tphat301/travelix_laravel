@if (count($services))
    <div class="loads">
        @foreach ($services as $k => $v)
            @if ($k >= 0 && $k < 6)
                <div class="load intro_item">
                    <div class="intro_item_overlay"></div>
                    <div class="intro_item_background" style="background-image:url({{ asset('public/backend/uploads/'.$v->photo) }})"></div>
                    <div class="intro_item_content d-flex flex-column align-items-center justify-content-center">
                        <div class="intro_date">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $v->created_at)->format('d/m/Y H:i:s') }}</div>
                        <div class="button intro_button"><div class="button_bcg"></div><a href="{{ url('/order/create/'.$v->id) }}">Đăng ký dịch vụ<span></span><span></span><span></span></a></div>
                        <div class="intro_center text-center">
                            <h1 class="name_service text-split">{{ $v->name }}</h1>
                            <div class="intro_price">Giá: {{ number_format($v->price, 0,",",".") }}VND</div>
                            <div class="rating rating_4">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endif
@if (count($services) > 6)
    <div class="button btn-custom-dev"><div class="button_bcg"></div><a href="dich-vu">Xem thêm<span></span><span></span><span></span></a></div>
@endif



