<?php

namespace App\Http\Controllers\Api\Keluarga;

use App\Http\Controllers\Controller;
use App\Models\Keluarga;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeluargaController extends Controller
{
    use ApiResponse;
    /**
     * GET /keluarga
     */
    public function index()
    {
        $user = Auth::user();

        $keluargas = Keluarga::query()
            // ->when(!$user->hasRole('admin'), function ($q) use ($user) {
            //     $q->where('user_id', $user->id);
            // })
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return $this->success([
            'keluarga' => $keluargas
        ], 'Berhasil ambil data keluarga');
    }

    /**
     * GET /keluarga/{id}
     */
    public function show($id)
    {
        $keluarga = Keluarga::findOrFail($id);

        return $this->success([
            'keluarga' => $keluarga
        ]);
    }

    /**
     * POST /keluarga
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama_lengkap' => 'required|string|max:255',
            'usia' => 'required|string',
            'pekerjaan' => 'required|string',
            'pendidikan_terakhir' => 'required|string',
        ]);

        $keluarga = Keluarga::create($validated);

        return $this->created(['keluarga' => $keluarga]);
    }

    /**
     * 
     * PUT /keluarga/{id}
     */
    public function update(Request $request, $id)
    {
        $keluarga = Keluarga::findOrFail($id);

        $validated = $request->validate([
            'nama_kepala_keluarga' => 'sometimes|string|max:255',
            'alamat' => 'sometimes|string',
        ]);

        $keluarga->update($validated);

        return $this->created([
            'keluarga' => $keluarga
        ]);
    }

    /**
     * DELETE /keluarga/{id}
     */
    public function destroy($id)
    {
        $keluarga = Keluarga::findOrFail($id);
        $keluarga->delete();

        return $this->success([
            'message' => 'Data keluarga berhasil dihapus'
        ]);
    }
}
