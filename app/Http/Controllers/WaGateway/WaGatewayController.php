<?php

namespace App\Http\Controllers\WaGateway;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WaGatewayController extends Controller
{
    public function index()
    {

        $waDevice = Http::asForm()->post('https://app.ruangwa.id/api/device', [
            'token' => getSetting('ruang_wa_token'),
        ]);

        // return dd($waStatus->json());

        $data = [
            'title' => 'WhatsApp Gateway',
            'mods' => 'wa_gateway',
            'waDevice' => $waDevice->json(),
            // 'action' => route('announcements.update'),
        ];

        return view($this->defaultLayout('wa_gateway.index'), $data);
    }
}
