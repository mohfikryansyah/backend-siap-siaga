<?php

namespace App\Http\Controllers\Api\Skrining;

use App\Http\Controllers\Controller;
use App\Models\Skrining;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SkriningController extends Controller
{
    use ApiResponse;

    /**
     * Kembalikan data skrinings berdasarkan user ID
     * Jika admin kembalikan semua data
     * 
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $skrinings = Skrining::query()
            ->with('keluarga')
            // ->when(!$user->hasRole('admin'), function ($q) use ($user) {
            //     $q->where('user_id', $user->id);
            // })
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return $this->success($skrinings, 'Berhasil ambil data keluarga');
    }

    /**
     * 
     */
    public function show(Skrining $skrining): JsonResponse
    {
        return $this->success($skrining->load('keluarga'), 'Berhasil ambil data keluarga');
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'keluarga_id' => 'required|exists:keluargas,id',
            'skor' => 'required|numeric',
            'tanda_bahaya' => 'required|boolean',
        ]);

        $user = $request->user();
        
        $validatedData['user_id'] = $user->id;

        $keluarga = Skrining::create($validatedData);

        return $this->created($keluarga, 'Berhasil menambahkan data');
    }

    public function update(Request $request, Skrining $skrining): JsonResponse
    {
        $validatedData = $request->validate([
            'keluarga_id' => 'required|exists:keluargas,id',
            'skor' => 'required|numeric',
            'tanda_bahaya' => 'required|boolean',
        ]);

        $keluargaUpdate = $skrining->update($validatedData);

        return $this->created($keluargaUpdate, 'Berhasil mengubah data.');
    }
}
