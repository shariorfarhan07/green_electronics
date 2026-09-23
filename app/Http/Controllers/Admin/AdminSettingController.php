<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminSettingController extends Controller
{
    const ORDERS_DISABLED_KEY = 'orders_disabled';

    public function edit()
    {
        return Inertia::render('Admin/Settings', [
            'ordersDisabled' => Setting::bool(self::ORDERS_DISABLED_KEY),
        ]);
    }

    public function update(Request $request)
    {
        Setting::set(self::ORDERS_DISABLED_KEY, $request->boolean('orders_disabled') ? '1' : '0');

        return redirect()->route('admin.settings.edit')->withsuccess('Settings saved.');
    }
}
