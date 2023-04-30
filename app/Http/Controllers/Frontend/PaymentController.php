<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Vnpay;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
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
        $order->bank = 'NCB';
        $order->phone = $request->phone;
        $order->email = $request->email;
        $order->status = 'active';
        $order->total = Cart::total();
        $order->options = Cart::content();
        $order->address = $request->address;
        $order->notes = $request->notes;
        $order->save();

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost/travelix_laravel/order/vnpay/checkout";
        $vnp_TmnCode = "XR4CCPHZ"; //Mã website tại VNPAY 
        $vnp_HashSecret = "MYXEQWIKMSDJEHUSJGEMPVSFHWINKPJF"; //Chuỗi bí mật

        $vnp_TxnRef = $code; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = $request->fullname;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = Cart::total() * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        //Add Params of 2.0.1 Version
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url
        );
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
    }

    public function checkout(Request $request)
    {
        $cartContent = Cart::content();
        $order = new Vnpay;
        $order->fullname = $request->vnp_OrderInfo;
        $order->code = $request->vnp_TxnRef;
        $order->bank = $request->vnp_BankCode;
        $order->status = 'active';
        $order->total = $request->vnp_Amount;
        $order->options = $cartContent;
        $order->save();
        return redirect('/order/feedback')->with('success', 'Thanh toán thành công');
    }
}
