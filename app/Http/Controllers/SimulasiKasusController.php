<?php

namespace App\Http\Controllers;

use App\Models\SimulasiKasus;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
// use Illuminate\Http\Request;

class SimulasiKasusController extends Controller
{
    use ApiResponse;

    public function index(): JsonResponse
    {
        $data = SimulasiKasus::orderBy('urutan')->get();
        return $this->success($data, 'Berhasil mengambil data simulasi kasus');
    }
}
