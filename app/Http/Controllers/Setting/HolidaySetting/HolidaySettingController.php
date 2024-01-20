<?php

namespace App\Http\Controllers\Setting\HolidaySetting;

use App\Http\Controllers\Controller;
use App\Models\HolidaySetting;
use Exception;
use Illuminate\Http\Request;

class HolidaySettingController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Pengaturan Hari Libur',
            'mods' => 'holiday_setting',
            'holidaySetting' => HolidaySetting::all()
        ];

        return view($this->defaultLayout('setting.holiday_setting.index'), $data);
    }

    public function update(HolidaySetting $holidaySetting, Request $request)
    {
        try {
            if (isset($request->range_1)) {
                $range1 = explode(' to ', $request->range_1);
            }
            if (isset($request->range_2)) {
                $range2 = explode(' to ', $request->range_2);
            }
            $holidaySetting->update([
                'day_1' => $request->day_1,
                'day_2' => $request->day_2,
                'date_1' => $request->date_1,
                'date_2' => $request->date_2,
                'date_3' => $request->date_3,
                'start_range_1' => isset($range1) && isset($range1[0]) ? $range1[0] : null,
                'end_range_1' => isset($range1) && isset($range1[1]) ? $range1[1] : null,
                'start_range_2' => isset($range2) && isset($range2[0]) ? $range2[0] : null,
                'end_range_2' => isset($range2) && isset($range2[1]) ? $range2[1] : null,
            ]);

            return response()->json([
                'message' => 'Data telah diupdate'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ]);
        }
    }

    public function reset(HolidaySetting $holidaySetting)
    {
        try {
            $holidaySetting->update([
                'day_1' => 'Sunday',
                'day_2' => null,
                'date_1' => null,
                'date_2' => null,
                'date_3' => null,
                'start_range_1' => null,
                'end_range_1' => null,
                'start_range_2' => null,
                'end_range_2' => null,
            ]);

            return response()->json([
                'message' => 'Data telah diupdate'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ]);
        }
    }
}
