<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Momo;
use App\Models\Order;
use Illuminate\Support\Str;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class MomoController extends Controller
{

    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    public function store(Request $request)
    {

        $request->validate(
            [
                "fullname" => ["required", "string", "max:255"],
                "email" => ["required", 'email'],
                "address" => ["required", "string"],
                "phone" => ["required"]
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
                'address' => 'Địa chỉ'
            ]
        );

        $code = "#T" . Str::upper(Str::random(3));
        $order = new Order;
        $order->fullname = $request->fullname;
        $order->code = $code;
        $order->phone = $request->phone;
        $order->bank = 'Momo';
        $order->status = 'active';
        $order->options = Cart::content();
        $order->email = $request->email;
        $order->total = Cart::total();
        $order->address = $request->address;
        $order->notes = $request->note;
        $order->save();

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $serectkey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = $request->fullname;
        $amount = Cart::total();
        $orderId = time() . "";
        $redirectUrl = "http://localhost/travelix_laravel/order/momo/checkout";
        $ipnUrl = "http://localhost/travelix_laravel/order/momo/checkout";
        $extraData = "";

        $requestId = time() . "";
        $requestType = "payWithATM";
        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $serectkey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => $request->fullname,
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = $this->execPostRequest($endpoint, json_encode($data));
        // dd($result);
        $jsonResult = json_decode($result, true);  // decode json

        //Just a example, please check more in there

        return redirect($jsonResult['payUrl']);
    }

    public function checkout(Request $request)
    {
        $order = new Momo;
        $order->fullname = $request->orderInfo;
        $order->bank = 'Momo';
        $order->status = 'active';
        $order->total = $request->amount;
        $order->options = Cart::content();
        $order->save();
        return redirect('/order/feedback')->with('success', 'Thanh toán thành công');
    }
}
