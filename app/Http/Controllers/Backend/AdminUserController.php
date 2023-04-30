<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class AdminUserController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(["module_active" => "user"]);
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
            $users = User::onlyTrashed()->where("name", "LIKE", "%{$keyword}%")->paginate(10);
        } else {
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $users = User::where("name", "LIKE", "%{$keyword}%")->paginate(10);
        }
        $countUserActive = User::count();
        $countUserTrash = User::onlyTrashed()->count();
        $countUser = [$countUserActive, $countUserTrash];
        return view("admin.user.index", compact("users", "countUser", "act"));
    }

    public function edit($id)
    {
        $userById = User::find($id);
        return view("admin.user.edit", compact("userById"));
    }

    public function store(Request $request, $id)
    {
        $request->validate(
            [
                "name" => ["required", "string", "max:255"],
                'username' => ['required', 'string', 'regex:/^[a-zA-Z0-9_\.]{5,32}$/'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'password_confirmation' => ['required', 'string', 'min:8'],
            ],
            [
                'required' => ':attribute không được để trống',
                'string' => ':attribute phải ở dạng chuỗi ký tự',
                'min' => ':attribute nhập vào phải có ít nhất là :min ký tự',
                'max' => ':attribute chỉ cho phép nhập vào tối đa là :max ký tự',
                'confirmed' => 'Xác nhận mật khẩu không thành công',
            ],
            [
                'name' => 'Họ và tên',
                'username' => 'Tài khoản',
                'password' => 'Mật khẩu',
                'password_confirmation' => 'Xác nhận mật khẩu',
            ]
        );
        if ($request->has('photo')) {
            $file = $request->file('photo');
            $nameFile = $file->getClientOriginalName();
            $typeFile = $file->getClientOriginalExtension();
            $sizeFile = $file->getSize();
            $typeAllow = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
            if (!in_array(strtolower($typeFile), $typeAllow)) {
                return redirect('admin/user/create')->with('danger', 'File không đúng định dạng jpg, jpeg, .gif, png, webp');
            } else {
                if ($sizeFile > 26214400) {
                    return redirect('admin/user/create')->with('danger', 'File tải lên đã vượt quá 25MB');
                } else {
                    $file->move('public/backend/uploads', $nameFile);
                    $photo = 'public/backend/uploads/' . $nameFile;
                }
            }
        }

        User::where("id", $id)->update(
            [
                'name' => $request->name,
                'username' => $request->username,
                'photo' => $photo,
                'password' => Hash::make($request->password),
            ]
        );
        return redirect('admin/user/index')->with('success', 'Cập nhật tài khoản thành công');
    }

    public function delete($id)
    {
        $userById = User::find($id);
        $userById->update(['status' => 'trash']);
        $userById->delete();
        return redirect('admin/user/index')->with('success', 'Xóa tài khoản thành công');
    }

    public function action(Request $request)
    {
        $listCheckbox = $request->input('check__item');
        if ($listCheckbox) {
            foreach ($listCheckbox as $key => $id) {
                if (Auth::user()->id == $id) {
                    unset($listCheckbox[$key]);
                    return redirect('admin/user/index')->with('danger', 'Không thể thao tác trên chính tài khoản của bạn');
                }
            }

            if (!empty($listCheckbox)) {
                $act = $request->input('act');

                switch ($act) {
                    case 'restore':
                        User::withTrashed()->whereIn('id', $listCheckbox)->update(['status' => 'active']);
                        User::withTrashed()->whereIn('id', $listCheckbox)->restore();
                        return redirect('admin/user/index')->with('success', 'Khôi phục tài khoản thành công');
                        break;
                    case 'delete':
                        User::withTrashed()->whereIn('id', $listCheckbox)->update(['status' => 'trash']);
                        User::destroy($listCheckbox);
                        return redirect('admin/user/index')->with('success', 'Xóa tài khoản thành công');
                        break;
                    case 'force_delete':
                        User::withTrashed()->whereIn('id', $listCheckbox)->forceDelete();
                        return redirect('admin/user/index')->with('success', 'Xóa vĩnh viễn tài khoản thành công');
                        break;

                    default:
                        break;
                }
            }
        }
    }

    public function create()
    {
        return view("admin.user.create");
    }

    public function create_store(Request $request)
    {
        $request->validate(
            [
                "name" => ["required", "string", "max:255"],
                'username' => ['required', 'string', 'regex:/^[a-zA-Z0-9_\.]{5,32}$/'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ],
            [
                'required' => ':attribute không được để trống',
                'string' => ':attribute phải ở dạng chuỗi ký tự',
                'email' => ':attribute không đúng định dạng',
                'unique' => ':attribute đã tồn tại trên hệ thống',
                'min' => ':attribute nhập vào phải có ít nhất là :min ký tự',
                'max' => ':attribute chỉ cho phép nhập vào tối đa là :max ký tự',
                'confirmed' => 'Xác nhận mật khẩu không thành công',
            ],
            [
                'name' => 'Họ và tên',
                'username' => 'Tài khoản',
                'email' => 'Email',
                'password' => 'Mật khẩu',
                'password_confirmation' => 'Xác nhận mật khẩu',
            ]
        );


        if ($request->has('photo')) {
            $file = $request->photo;
            $nameFile = $file->getClientOriginalName();
            $typeFile = $file->getClientOriginalExtension();
            $sizeFile = $file->getSize();
            $typeAllow = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
            if (!in_array(strtolower($typeFile), $typeAllow)) {
                return redirect('admin/user/create')->with('danger', 'File không đúng định dạng jpg, jpeg, .gif, png, webp');
            } else {
                if ($sizeFile > 26214400) {
                    return redirect('admin/user/create')->with('danger', 'File tải lên đã vượt quá 25MB');
                } else {
                    $file->move('public/backend/uploads', $nameFile);
                    $photo = 'public/backend/uploads/' . $nameFile;
                }
            }
        }

        User::create(
            [
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'level' => 1,
                'role' => 'admin',
                'photo' => $photo,
                'author' => Auth::user()->name,
            ]
        );
        return redirect('admin/user/index')->with('success', 'Thêm thành viên thành công');
    }
}
