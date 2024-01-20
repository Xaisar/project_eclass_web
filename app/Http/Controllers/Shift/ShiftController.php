<?php

namespace App\Http\Controllers\Shift;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ShiftRequest;
use App\Models\Shift;
use Vinkla\Hashids\Facades\Hashids;
use DataTables;

class ShiftController extends Controller
{
    
    public function index()
    {
        $data = [
            'title' => 'Data Shift',
            'mods' => 'shift',
        ];

        return view($this->defaultLayout, $data);
    }

    public function getData()
    {
        return DataTables::of(Shift::query())->make();
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Data Shift',
            'mods' => 'shift',
            'action' => route('shift.store')
        ];

        return view($this->defaultLayout('shift.form'), $data);
    }

    public function store(ShiftRequest $request)
    {
        try {
            Shift::create($request->only(['name', 'start_entry', 'start_time_entry', 'last_time_entry', 'start_exit', 'start_time_exit', 'last_time_exit']));

            return response()->json([
                'message' => 'Data telah ditambahkan'
            ]);
        } catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ], 500);
        }
    }

    public function edit(Shift $shift)
    {
        $data = [
            'title' => 'Edit Data Shift',
            'mods' => 'shift',
            'values' => $shift,
            'action' => route('shift.update', $shift->hashid)
        ];

        return view($this->defaultLayout('shift.form'), $data);
    }

    public function update(Shift $shift, ShiftRequest $request)
    {
        try {
            $shift->update($request->only(['name', 'start_entry', 'start_time_entry', 'last_time_entry', 'start_exit', 'start_time_exit', 'last_time_exit', 'status']));

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

    public function destroy(Shift $shift)
    {
        try {
            $shift->delete();

            return response()->json([
                'message' => 'Data telah dihapus'
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return response()->json([
                    'message' => 'Data tidak dapat dihapus karena sudah digunakan'
                ], 500);
            } else {
                return response()->json([
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace()
                ]);
            }
        }
    }

    public function multipleDelete(Request $request)
    {
        try {
            $id = [];
            foreach ($request->hashid as $hashid) {
                array_push($id, Hashids::decode($hashid));
            }
            Shift::destroy($id);
            return response()->json([
                'message' => 'Data telah dihapus'
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return response()->json([
                    'message' => 'Data tidak dapat dihapus karena sudah digunakan'
                ], 500);
            } else {
                return response()->json([
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace()
                ], 500);
            }
        }
    }

    public function updateStatus(Shift $shift)
    {
        try {
            $shift->update([
                'status' => !$shift->status
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
