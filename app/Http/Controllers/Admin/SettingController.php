<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all()->groupBy('group');

        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $inputs = $request->except(['_token', '_method']);
        foreach ($inputs as $key => $value) {
            SiteSetting::set($key, $value ?? '');
        }

        return back()->with('success', 'Settings saved successfully!');
    }
}
