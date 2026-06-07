<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    use ApiResponse;

    public function index(Request $request): JsonResponse
    {
        $data = Monitoring::where('user_id', $request->user()->id)
            ->where('keluarga_id', $request->query('keluarga_id'))
            ->orderBy('minggu')
            ->get();

        return $this->success($data, 'Berhasil mengambil data monitoring');
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'keluarga_id' => 'required|exists:keluargas,id',
            'minggu'      => 'required|integer|min:1|max:4',
            'mood'        => 'required|integer|min:1|max:10',
            'sosial'      => 'required|integer|min:1|max:10',
            'tidur'       => 'required|integer|min:1|max:10',
            'aktivitas'   => 'required|integer|min:1|max:10',
        ]);

        $validated['user_id'] = $request->user()->id;

        $monitoring = Monitoring::updateOrCreate(
            [
                'user_id'     => $validated['user_id'],
                'keluarga_id' => $validated['keluarga_id'],
                'minggu'      => $validated['minggu'],
            ],
            $validated
        );

        return $this->created($monitoring, 'Berhasil menyimpan data monitoring');
    }
}
