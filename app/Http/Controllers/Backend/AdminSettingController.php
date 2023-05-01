<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(["module_active" => "setting"]);
            return $next($request);
        });
    }

    public function index()
    {
        $id = Setting::first()->id;
        return redirect('admin/setting/edit/' . $id);
    }


    public function create()
    {
        if (Setting::first()) {
            $id = Setting::first()->id;
            return redirect('admin/setting/edit/' . $id);
        } else {
            return view('admin.setting.create');
        }
    }
    public function edit($id)
    {
        Setting::find($id)->name !== null ? $name = Setting::find($id)->name : $name = '';
        Setting::find($id)->copyright !== null ? $copyright = Setting::find($id)->copyright : $copyright = '';
        Setting::find($id)->address !== null ? $address = Setting::find($id)->address : $address = '';
        json_decode(Setting::find($id)->options, true)['map'] !== null ? $map = json_decode(Setting::find($id)->options, true)['map'] : $map = '';
        json_decode(Setting::find($id)->options, true)['zalo'] !== null ? $zalo = json_decode(Setting::find($id)->options, true)['zalo'] : $zalo = '';
        json_decode(Setting::find($id)->options, true)['call'] !== null ? $call = json_decode(Setting::find($id)->options, true)['call'] : $call = '';
        json_decode(Setting::find($id)->options, true)['messager'] !== null ? $messager = json_decode(Setting::find($id)->options, true)['messager'] : $messager = '';
        json_decode(Setting::find($id)->options, true)['hotline'] !== null ? $hotline = json_decode(Setting::find($id)->options, true)['hotline'] : $hotline = '';
        json_decode(Setting::find($id)->options, true)['fanpage'] !== null ? $fanpage = json_decode(Setting::find($id)->options, true)['fanpage'] : $fanpage = '';
        json_decode(Setting::find($id)->options, true)['worktime'] !== null ? $worktime = json_decode(Setting::find($id)->options, true)['worktime'] : $worktime = '';

        return view('admin.setting.edit', compact('name', 'copyright', 'address', 'map', 'zalo', 'call', 'messager', 'worktime', 'hotline', 'fanpage', 'id'));
    }


    public function store(Request $request, $id = '')
    {
        if (empty($id)) {

            $options = json_encode($request->except('name', 'copyright', 'address'), true);
            $name = $request->name;
            $address = $request->address;
            $copyright = $request->copyright;

            $settings = new Setting;
            $settings->name = trim($name);
            $settings->address = trim($address);
            $settings->copyright = $copyright;
            $settings->options = $options;
            $settings->save();
            return redirect('admin/setting/index');
        }
    }
}
