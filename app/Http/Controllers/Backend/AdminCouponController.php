<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AdminCouponController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'coupon']);
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $keyword = '';
        $act = ['delete' => 'Xóa tạm thời'];
        $status = $request->input('status');
        if ($status === 'trash') {
            $act = ['restore' => 'Khôi phục', 'force_delete' => 'Xóa vĩnh viễn'];
            $coupons = Coupon::onlyTrashed()->where("code_product", "LIKE", "%{$keyword}%")->paginate(10);
        } else {
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $coupons = Coupon::where("code_product", "LIKE", "%{$keyword}%")->paginate(10);
        }
        $countCouponActive = Coupon::count();
        $countCouponTrash = Coupon::onlyTrashed()->count();
        $countCoupon = [$countCouponActive, $countCouponTrash];
        return view("admin.coupon.index", compact("coupons", "countCoupon", "act"));
    }


    public function create()
    {
        $codeByServices = Service::select('code')->get();
        return view("admin.coupon.create", compact('codeByServices'));
    }


    public function store(Request $request, $id = '')
    {
        if ($id == "") {
            // VALIDATION DATA
            $request->validate(
                [
                    "code" => ["required", "max:255"],
                    "code_product" => ["unique:coupons"],
                    "qty" => ["required", "regex:[0-9]"],
                    "discount" => ["required", "regex:[0-9]"],
                    "discount_form" => ["required"]
                ],
                [
                    "required" => ":attribute không được để trống",
                    "max" => ":attribute chỉ cho phép tối đa :max ký tự",
                    "unique" => ":attribute đã tồn tại",
                    "regex" => ":attribute phải ở dạng số"
                ],
                [
                    "code" => "Mã giảm giá",
                    "code_product" => "Mã dịch vụ",
                    "qty" => "Số lượng mã giảm giá",
                    "discount" => "Chỉ số mã giảm giá",
                    "discount_form" => "Hình thức giảm giá"
                ]
            );

            $coupon = new Coupon;
            $coupon->code = $request->code;
            $coupon->code_product = $request->code_product;
            $coupon->discount = $request->discount_form;
            $coupon->options = $request->discount;
            $coupon->status = 'active';
            $coupon->type = 'coupon';
            $coupon->qty = $request->qty;
            $coupon->save();
            return redirect('admin/coupon/create')->with('success', 'Thêm dữ liệu thành công');
        }

        if ($id) {
            Coupon::find($id)->update(
                [
                    "code" => $request->code,
                    "code_product" => $request->code_product,
                    "discount" => $request->discount_form,
                    "options" => $request->discount,
                    "qty" => $request->qty,
                ]
            );
            return redirect('admin/coupon/edit/' . $id)->with('success', 'Thêm dữ liệu thành công');
        }
    }


    public function edit($id)
    {
        $couponById = Coupon::find($id);
        $codeByServices = Service::select('code')->get();
        return view("admin.coupon.edit", compact("couponById", "codeByServices"));
    }


    public function action(Request $request)
    {
        $listCheckbox = $request->input('check__item');
        if ($listCheckbox) {

            if (!empty($listCheckbox)) {
                $act = $request->input('act');

                switch ($act) {
                    case 'restore':
                        Coupon::withTrashed()->whereIn('id', $listCheckbox)->update(['status' => 'active']);
                        Coupon::withTrashed()->whereIn('id', $listCheckbox)->restore();
                        return redirect('admin/service/index')->with('success', 'Khôi phục dịch vụ thành công');
                        break;


                    case 'delete':
                        Coupon::withTrashed()->whereIn('id', $listCheckbox)->update(['status' => 'trash']);
                        Coupon::destroy($listCheckbox);
                        return redirect('admin/service/index')->with('success', 'Xóa dịch vụ thành công');
                        break;


                    case 'force_delete':
                        Coupon::withTrashed()->whereIn('id', $listCheckbox)->forceDelete();
                        return redirect('admin/service/index')->with('success', 'Xóa vĩnh viễn dịch vụ thành công');
                        break;

                    default:
                        break;
                }
            }
        }
    }
}
