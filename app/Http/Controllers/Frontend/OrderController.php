<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Gloudemans\Shoppingcart\Facades\Cart;

class OrderController extends Controller
{

    public function coupon(Request $request)
    {
        if ($request->input('code')) {
            $code = $request->input('code');
            session(['coupon' => Coupon::where('code', $code)->where('type', 'coupon')->first()]);
        }
        return redirect("/order/index");
    }

    public function index(Request $request)
    {
        $orders = Cart::content();
        return view("order.index", compact('orders'));
    }

    public function create($id)
    {
        $serviceById = Service::find($id);
        Cart::add(
            ['id' => $serviceById->id, 'name' => $serviceById->name, 'qty' => 1, 'price' => $serviceById->price, 'options' => ['photo' => $serviceById->photo, 'brand' => $serviceById->brand, 'code' => $serviceById->code]]
        );
        return redirect('/order/index');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                "fullname" => ["required", "string", "max:255"],
                "email" => ["required", 'email'],
                "address" => ["required", "string"],
                "phone" => ["required"],
                "choose_checkout" => ["required"]
            ],
            [
                'required' => ':attribute không được để trống',
                'string' => ':attribute phải ở dạng chuỗi ký tự',
                'max' => ':attribute chỉ cho phép nhập vào tối đa là :max ký tự',
                'email' => ':attribute nhập vào phải đúng định dạng @gmail.com'
            ],
            [
                'fullname' => 'Tên dịch vụ',
                'email' => 'Email',
                'phone' => 'Số điện thoại',
                'address' => 'Địa chỉ',
                'choose_checkout' => 'Chọn hình thức thanh toán'
            ]
        );

        $code = "#T" . Str::upper(Str::random(3));

        $request->session()->put(
            [
                'fullname' => $request->fullname,
                'code' => $code,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'total' => Cart::total(),
                'note' => $request->note,
                'status' => 'Đặt hàng thành công'
            ]
        );

        $data = array(
            'fullname' => $request->fullname,
            'code' => $code,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'note' => $request->note,
            'time' => Carbon::now()->format('d/m/Y m:h:s')
        );

        Mail::to($request->email)->send(new SendMail($data));

        $cartContent = Cart::content();
        $order = new Order;
        $order->fullname = $request->fullname;
        $order->status = 'active';
        $order->code = $code;
        $order->phone = $request->phone;
        $order->email = $request->email;
        $order->address = $request->address;
        $order->total = Cart::total();
        $order->notes = $request->note;
        $order->options = $cartContent;
        $order->save();
        return redirect('/order/feedback')->with('success', 'Thanh toán thành công');
    }

    public function feedback(Request $request)
    {
        $fullname = $request->session()->get('fullname');
        $email = $request->session()->get('email');
        $phone = $request->session()->get('phone');
        $address = $request->session()->get('address');
        $note = $request->session()->get('note');
        return view("order.feedback", compact('fullname', 'email', 'phone', 'address', 'note'));
    }

    public function update(Request $request)
    {
        $dataCarts = $request->input('qty');
        foreach ($dataCarts as $rowId => $qty) {
            Cart::update($rowId, $qty);
        }
        return redirect("/order/index")->with("success", "Cập nhật giỏ hàng thành công");
    }

    public function update_ajax(Request $request)
    {
        $qty = $request->get('qty');
        $price = $request->get('price');
        $rowId = $request->get('rowId');
        $subTotal = $price * $qty;
        Cart::update($rowId, $qty);
        $data = array(
            'subTotal' => number_format($subTotal, 0, ",", ".") . "VND",
            'total' => number_format(Cart::total(), 0, ",", ".") . "VND",
        );
        echo  json_encode($data);
    }

    public function destroy()
    {
        Cart::destroy();
        return redirect("/order/index")->with('success', 'Xóa giỏ hàng thành công');
    }


    public function remove($rowId)
    {
        if ($rowId) {
            Cart::remove($rowId);
        }
    }

    public function reset(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }
}
