<?php

namespace App\Http\Controllers;

use App\InvoiceSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class InvoiceSettingController extends Controller
{
    public function index()
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('setting.edit')) {
            $role = $user->roles[0]->slug;
            $data = InvoiceSettings::first();
            return view('setting.invoice-setting', compact('user', 'role', 'data'));
        }
    }

    public function update(Request $request)
    {
        $setting = InvoiceSettings::first();
        // validate the data
        $request->validate([
            'invoice_type' => "required",
        ]);

        try {

            $update = InvoiceSettings::first();
            $update->invoice_type = $request->invoice_type;
            $update->save();

            return redirect()->back()->with('success', 'Setting updated successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'something went wrong.!');
        }
    }
}
