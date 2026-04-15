<?php

namespace App\Http\Controllers\Api\ProgressMateri;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProgressMateri;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class ProgressMateriController extends Controller
{
    use ApiResponse;

    /**
     * Ambil semua progress milik user
     */
    public function index(Request $request): JsonResponse
    {
        $progress = ProgressMateri::where('user_id', $request->user()->id)
            ->get(['materi_id', 'is_completed']);

        return $this->success(['progress_materi' => $progress], 'Berhasil ambil data progress');
    }

    public function complete(Request $request)
    {
        $request->validate([
            'materi_id' => 'required|string',
        ]);

        $progress = ProgressMateri::updateOrCreate(
            [
                'user_id'   => $request->user()->id,
            ],
            [
                'materi_id'    => $request->materi_id,
                'is_completed' => true,
            ]
        );

        return $this->created(['data' => $progress]);
    }
}
