<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use ApiResponse;

    /**
     * Register user baru.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('mobile-app')->plainTextToken;

        return $this->created([
            'user'  => new UserResource($user),
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'Registrasi berhasil.');
    }

    /**
     * Login dan dapatkan token.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        // Cek kredensial
        if (! Auth::attempt($request->only('email', 'password'))) {
            return $this->error('Email atau password salah.', null, 401);
        }

        /** @var User $user */
        $user = Auth::user();

        // Hapus token lama (opsional: batasi 1 device)
        // $user->tokens()->delete();

        $token = $user->createToken('mobile-app')->plainTextToken;

        return $this->success([
            'user'       => new UserResource($user),
            'token'      => $token,
            'token_type' => 'Bearer',
        ], 'Login berhasil.');
    }

    /**
     * Ambil data user yang sedang login.
     */
    public function me(Request $request): JsonResponse
    {
        return $this->success(
            new UserResource($request->user()),
            'Data user berhasil diambil.'
        );
    }

    /**
     * Logout - hapus token aktif.
     */
    public function logout(Request $request): JsonResponse
    {
        // Hapus hanya token yang digunakan sekarang
        $request->user()->currentAccessToken()->delete();

        return $this->success(null, 'Logout berhasil.');
    }

    /**
     * Logout dari semua device.
     */
    public function logoutAll(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return $this->success(null, 'Logout dari semua device berhasil.');
    }
}