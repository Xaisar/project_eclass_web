<?php

namespace App\Http\Controllers\EPresence;

use App\Http\Controllers\Controller;
use App\Models\PresenceToken;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EPresenceController extends Controller
{
    public function index()
    {

        $data = [
            'title' => 'E-Presensi'
        ];

        return view('e-presence.index', $data);
    }

    public function getPresenceQr(Request $request)
    {
        if ($request->code == getSetting('presence_entry_code')) {
            return response()->json([
                'qrs' => $this->generatePresenceQR()
            ]);
        } else {
            return response()->json([
                'message' => 'Gagal melakukan verifikasi terhadap kode masuk ! Kode masuk salah'
            ], 500);
        }
    }

    public function refreshToken(Request $request)
    {
        if ($request->code == getSetting('presence_entry_code')) {

            PresenceToken::all()->each(function($token) {
                $token->token = Str::random(16);
                $token->save();
            });

            return response()->json([
                'message' => 'Berhasil mengupdate token QR'
            ]);

        } else {
            return response()->json([
                'message' => 'Gagal melakukan verifikasi terhadap kode masuk ! Kode masuk salah'
            ], 500);
        }
    }

    private function generatePresenceQR()
    {
        $presenceTokenA = PresenceToken::where('type', 'a')->first();
        $presenceTokenB = PresenceToken::where('type', 'b')->first();

        return [
            'a' => base64_encode(QrCode::format('png')->size(250)->generate('a|' . date('d-m-Y') . '|' . $presenceTokenA->token)),
            'b' => base64_encode(QrCode::format('png')->size(250)->generate('b|' . date('d-m-Y') . '|' . $presenceTokenB->token))
        ];
    }
}
