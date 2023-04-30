@include("partials.css")
@include("partials.js")
<table class="table__mail">
    <tbody>
        <tr>
            <td>
                <h1 class="table__mail--titleMain">
                    Chào {{$fullname}}. Đơn hàng của bạn đã đặt thành công!</h1>
                <p class="table__mail--subTitle">
                    Chúng tôi đang chuẩn bị hàng để bàn giao cho đơn vị vận chuyển hàng
                </p>
                <h3 class="table__mail--time">
                    MÃ ĐƠN HÀNG: {{$code}}<br>Ngày đặt: {{$time}} 
                </h3>
            </td>
        </tr>
        <tr>
        </tr>
        <tr>
            <td class="table__mail--bxTbl">
                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                    <thead>
                        <tr>
                            <th class="table__mail--thDev" width="50%" align="left">
                                Thông tin khách hàng</th>
                            <th class="table__mail--thDev" width="50%" align="left">
                                Địa chỉ giao hàng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="mail__fullname" valign="top">
                                <span>Họ và tên: {{$fullname}}</span><br>
                                <a>Email: {{$email}}</a><br> Số điện thoại: {{$phone}}
                            </td>
                            <td class="mail__address" valign="top"> {{$address}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table class="tbl__bill">
                    <thead class="tbl__bill--thead">
                        <tr>
                            <th class="table__mail--thTitle">STT</th>
                            <th class="table__mail--thTitle">Tên sản phẩm</th>
                            <th class="table__mail--thTitle">Giá</th>
                            <th class="table__mail--thTitle">Số lượng</th>
                            <th class="table__mail--thTitle">Thành tiền</th>
                        </tr>
                    </thead>
                    
                    @if (Cart::total() > 0)
                        <tbody class="mail__tbody">
                                @php
                                    $count = 0;
                                @endphp
                                @foreach (Cart::content() as $k => $v)    
                                    @php
                                        $count++;
                                    @endphp
                                    <tr>
                                        <td>{{ $count }}</td>
                                        <td><span>{{ $v->name }}</span></td>
                                        <td><span>{{ number_format($v->price, 0,",", ".") }}VND</span></td>
                                        <td><span>{{ $v->qty }}</span></td>
                                        <td><span>{{ number_format($v->subtotal, 0,",", ".") }}VND</span></td>
                                    </tr>
                                @endforeach
                        </tbody>
                    @endif
                </table>
                <span style="color:red">{{ number_format(Cart::total(), 0,",", ".") }}VND</span>
            </td>
        </tr>
        <tr>
            <td>
                <br>
                <p class="mail__alert">Quý khách vui lòng giữ lại hóa đơn (nếu có) để trao đổi hoặc khiếu nại khi cần thiết.</p>
                <p class="mail__infomation">Liên hệ Hotline: <strong>0987.654.321</strong>(8-21h cả T7,CN).</p>
            </td>
        </tr>
        <tr>
            <td>
                <br>
                <p class="mail__thanks">
                    <span>Travelix</span> cảm ơn quý khách đã đặt dịch vụ, chúng tôi sẽ không ngừng nổ lực để phục vụ quý khách tốt hơn!<br>
                </p>
            </td>
        </tr>
    </tbody>
</table>
