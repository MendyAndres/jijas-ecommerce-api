<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Services\AuthenticationService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    private AuthenticationService $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $authToken = $this->authenticationService->UserRegister($request);
        return response()->json(['authToken' => $authToken]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $authToken = $this->authenticationService->login($request);
        return response()->json(['authToken' => $authToken]);
    }

    public function logout(): JsonResponse
    {
        auth()->user()->token()->revoke();
        return response()->json(['message' => 'Logged out successfully!']);
    }
}
