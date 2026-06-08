<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    use ApiResponse;
 
    /**
     * GET /monitoring-remaja
     * Ambil semua data monitoring milik user, dikelompokkan per anggota keluarga.
     * Query param opsional: keluarga_id, limit (default 8 minggu terakhir)
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
 
        $query = Monitoring::with('keluarga')
            ->where('user_id', $user->id)
            ->orderBy('tanggal_minggu', 'asc');
 
        // Filter per anggota keluarga
        if ($request->filled('keluarga_id')) {
            $query->where('keluarga_id', $request->keluarga_id);
        }
 
        // Ambil N minggu terakhir (default 8)
        $limit = (int) $request->get('limit', 8);
 
        // Subquery: ambil ID dari N data terbaru sesuai filter
        $latestIds = (clone $query)
            ->orderBy('tanggal_minggu', 'desc')
            ->limit($limit)
            ->pluck('id');
 
        $data = Monitoring::with('keluarga')
            ->whereIn('id', $latestIds)
            ->orderBy('tanggal_minggu', 'asc')
            ->get();
 
        return $this->success($data, 'Berhasil mengambil data monitoring');
    }
 
    /**
     * POST /monitoring-remaja
     * Tambah monitoring mingguan baru.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'keluarga_id'     => 'required|exists:keluargas,id',
            'tanggal_minggu'  => 'required|date',
            'mood'            => 'required|integer|min:1|max:5',
            'interaksi_sosial'=> 'required|integer|min:1|max:5',
            'tidur'           => 'required|numeric|min:1|max:12',
            'aktivitas'       => 'required|integer|min:1|max:5',
            'catatan'         => 'nullable|string|max:500',
        ]);
 
        $user = $request->user();
        $validated['user_id'] = $user->id;
 
        // Pastikan keluarga_id milik user ini
        $belongsToUser = $user->keluargas()->where('id', $validated['keluarga_id'])->exists();
        if (!$belongsToUser) {
            return $this->error('Anggota keluarga tidak ditemukan', 403);
        }
 
        // Cek duplikat minggu
        $exists = Monitoring::where('keluarga_id', $validated['keluarga_id'])
            ->where('tanggal_minggu', $validated['tanggal_minggu'])
            ->exists();
 
        if ($exists) {
            return $this->error('Data monitoring minggu ini sudah ada untuk anggota keluarga tersebut', 422);
        }
 
        $monitoring = Monitoring::create($validated);
        $monitoring->load('keluarga');
 
        return $this->created($monitoring, 'Berhasil menambahkan data monitoring');
    }
 
    /**
     * GET /monitoring-remaja/{id}
     * Detail satu entri monitoring.
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $monitoring = Monitoring::with('keluarga')
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);
 
        return $this->success($monitoring, 'Berhasil mengambil detail monitoring');
    }
 
    /**
     * PUT /monitoring-remaja/{id}
     * Update data monitoring.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $monitoring = Monitoring::where('user_id', $request->user()->id)->findOrFail($id);
 
        $validated = $request->validate([
            'mood'            => 'sometimes|integer|min:1|max:5',
            'interaksi_sosial'=> 'sometimes|integer|min:1|max:5',
            'tidur'           => 'sometimes|numeric|min:1|max:12',
            'aktivitas'       => 'sometimes|integer|min:1|max:5',
            'catatan'         => 'nullable|string|max:500',
        ]);
 
        $monitoring->update($validated);
        $monitoring->load('keluarga');
 
        return $this->success($monitoring, 'Berhasil memperbarui data monitoring');
    }
 
    /**
     * DELETE /monitoring-remaja/{id}
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $monitoring = Monitoring::where('user_id', $request->user()->id)->findOrFail($id);
        $monitoring->delete();
 
        return $this->success(null, 'Berhasil menghapus data monitoring');
    }
}
