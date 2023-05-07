<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $newsletter = new Newsletter();
        $newsletter->fullname = !empty($request->input('fullname')) ? htmlspecialchars($request->input('fullname')) : null;
        $newsletter->email = !empty($request->input('email')) ? htmlspecialchars($request->input('email')) : null;
        $newsletter->phone = !empty($request->input('phone')) ? $request->input('phone') : null;
        $newsletter->address = !empty($request->input('address')) ? htmlspecialchars($request->input('address')) : null;
        $newsletter->notes = !empty($request->input('notes')) ? htmlspecialchars($request->input('notes')) : null;
        $newsletter->status = 'active';
        $newsletter->save();
        return redirect('/')->with('success', 'Đăng ký nhận tin thành công');
    }
}
