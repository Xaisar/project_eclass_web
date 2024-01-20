<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use File;

class SettingController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Pengaturan',
            'mods' => 'setting',
        ];
        $settings = Setting::all();
        $settingsGrouped = [];

        foreach ($settings as $setting) $settingsGrouped[$setting->groups][] = $setting;
        $data['settingsGrouped'] = $settingsGrouped;

        return view($this->defaultLayout, $data);
    }

    public function edit(Setting $setting)
    {
        $data = [
            'title' => 'Edit Setting',
            'mod'   => 'setting',
            'settings' =>$setting,
            'action' => route('settings.update', ['setting' => hashId($setting->id)])
        ];
        return view($this->defaultLayout('setting.form'), $data);
    }

    public function update(SettingRequest $request, Setting $setting)
    {
        try {
             $path = 'assets/images/';
                $fileName = $setting->value;
                if ($request->file('value') != null) {
                    if ($fileName != 'logo.png' || $fileName != 'favicon.png') {
                        File::delete($path . $fileName);
                    }
                    $fileName = $request->file('value')->getClientOriginalName();
                    $request->file('value')->move(public_path($path), $fileName);
                }
           $setting->update([
                'value' => $setting->groups == 'Image' ? $fileName : $request->value,
                'updated_at' => Carbon::now()
           ]);
            return response()->json([
                'message' => 'Data telah diupdate'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ]);
        }
    }

    public function updateStatus(Setting $setting)
    {
        try {
            $setting->update([
                'value' => $setting->value == 'Y' ? 'N' : 'Y'
            ]);
            return response()->json([
                'message' => 'Data telah diupdate'
            ]);
        } catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ]);
        }
    }
}
