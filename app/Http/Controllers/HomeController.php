<?php

namespace App\Http\Controllers;

use App\Charts\MonthlyUsersChart;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', function ($request, $next) {
            session(["module_active" => "dashboard"]);
            return $next($request);
        }]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function index(MonthlyUsersChart $chart)
    {
        // if (Auth::user()->email_verified_at == "") echo "Chưa xác thực email";
        // else echo "Đăng nhập thành công";
        // $data = ['username' => $request->username, 'password' => $request->password];
        // if (Auth::attempt($data)) return true;
        // return FALSE;
        return view('admin.layout.dashboard', ['chart' => $chart->build()]);
    }
}
