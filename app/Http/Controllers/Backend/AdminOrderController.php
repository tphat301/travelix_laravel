<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'order']);
            return $next($request);
        });
    }


    public function index(Request $request)
    {
        $keyword = "";
        $status = $request->input('status');
        $act = [
            'is_handle' => 'Đang xử lý',
            'is_success' => 'Đã giao hàng',
            'delete' => 'Hủy đơn hàng'
        ];
        if ($status == 'trash') {
            $act = [
                'restore' => 'Khôi phục đơn hàng',
                'force_delete' => 'Xóa vĩnh viễn đơn hàng'
            ];
            $orders = Order::onlyTrashed()->where("fullname", "LIKE", "%{$keyword}%")->where('status', 'trash')->paginate(20);
        }
        if ($status == 'is_success') {
            $act = [];
            $orders = Order::where("fullname", "LIKE", "%{$keyword}%")->where('status', 'success')->paginate(20);
        }
        if ($status == 'is_handle') {
            $act = [
                'is_success' => 'Đã giao hàng',
                'delete' => 'Hủy đơn hàng'
            ];
            $orders = Order::where("fullname", "LIKE", "%{$keyword}%")->where('status', 'handle')->paginate(20);
        }
        if ($status == 'active') {
            $act = [
                'is_handle' => 'Đang xử lý',
                'is_success' => 'Đã giao hàng',
                'restore' => 'Khôi phục đơn hàng',
                'delete' => 'Hủy đơn hàng'
            ];
            $orders = Order::where("fullname", "LIKE", "%{$keyword}%")->where('status', 'active')->paginate(20);
        }
        if ($status == '') {
            $act = [
                'is_handle' => 'Đang xử lý',
                'is_success' => 'Đã giao hàng',
                'restore' => 'Khôi phục đơn hàng',
                'delete' => 'Hủy đơn hàng'
            ];
            $orders = Order::where("fullname", "LIKE", "%{$keyword}%")->paginate(20);
        }

        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        // $orders = Order::where("fullname", "LIKE", "%{$keyword}%")->paginate(20);

        $countOrderTrash = Order::onlyTrashed()->count();
        $countOrderSuccess = Order::where('status', 'success')->count();
        $countOrderHandle = Order::where('status', 'handle')->count();
        $countOrderActive = Order::count();
        $countOrder = [$countOrderActive, $countOrderSuccess, $countOrderHandle, $countOrderTrash];
        return view("admin.order.index", compact('orders', 'countOrder', 'act'));
    }


    public function show($id)
    {
        $orderById = Order::find($id);
        $orderByIdConvert = json_decode($orderById, true);
        $orderByOptionsConvert = json_decode($orderById->options, true);
        return view("admin.order.show", compact('orderByIdConvert', 'orderByOptionsConvert'));
    }

    public function delete($id)
    {
        $orderById = Order::find($id);
        $orderById->update(['status' => 'trash']);
        $orderById->delete();
        return redirect('admin/order/index')->with('success', 'Xóa đơn hàng thành công');
    }

    public function action(Request $request)
    {
        $listCheckbox = $request->input('check__item');
        if ($listCheckbox) {

            if (!empty($listCheckbox)) {
                $act = $request->input('act');

                switch ($act) {
                    case 'is_success':
                        Order::withTrashed()->whereIn('id', $listCheckbox)->update(['status' => 'success']);
                        return redirect('admin/order/index')->with('success', 'Đơn hàng đã bàn giao');
                        break;
                    case 'is_handle':
                        Order::withTrashed()->whereIn('id', $listCheckbox)->update(['status' => 'handle']);
                        return redirect('admin/order/index')->with('success', 'Đơn hàng đang được xử lý');
                        break;
                    case 'restore':
                        Order::withTrashed()->whereIn('id', $listCheckbox)->update(['status' => 'active']);
                        Order::withTrashed()->whereIn('id', $listCheckbox)->restore();
                        return redirect('admin/order/index')->with('success', 'Khôi phục đơn hàng thành công');
                        break;
                    case 'delete':
                        Order::withTrashed()->whereIn('id', $listCheckbox)->update(['status' => 'trash']);
                        Order::destroy($listCheckbox);
                        return redirect('admin/order/index')->with('success', 'Xóa đơn hàng thành công');
                        break;
                    case 'force_delete':
                        Order::withTrashed()->whereIn('id', $listCheckbox)->forceDelete();
                        return redirect('admin/order/index')->with('success', 'Xóa vĩnh viễn đơn hàng thành công');
                        break;

                    default:
                        break;
                }
            }
        }
    }
}
