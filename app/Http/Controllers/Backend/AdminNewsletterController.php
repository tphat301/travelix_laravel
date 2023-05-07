<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;

class AdminNewsletterController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'newsletter']);
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
            $newsletters = Newsletter::onlyTrashed()->where("fullname", "LIKE", "%{$keyword}%")->paginate(10);
        } else {
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $newsletters = Newsletter::where(['status' => 'active'])->where("fullname", "LIKE", "%{$keyword}%")->paginate(10);
        }
        $countNewsletterActive = Newsletter::where(['status' => 'active'])->count();
        $countNewsletterTrash = Newsletter::onlyTrashed()->count();
        $countNewsletter = [$countNewsletterActive, $countNewsletterTrash];
        return view("admin.newsletter.index", compact("newsletters", "countNewsletter", "act"));
    }


    public function create()
    {
        return view('admin.newsletter.create');
    }


    public function delete($id)
    {
        $newsletterById = Newsletter::find($id);
        $newsletterById->update(['status' => 'trash']);
        $newsletterById->delete();
        return redirect('admin/newsletter/index')->with('success', 'Xóa dữ liệu thành công');
    }
}
