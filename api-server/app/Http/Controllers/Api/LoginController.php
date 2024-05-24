<?php

namespace App\Http\Controllers\Api;

use App\DataAccess\UserRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequestForm;
use App\Mappers\UserMapper;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;


class LoginController extends Controller
{
    public function __construct(
        private readonly AuthService $authService,
        private readonly UserRepository $userRepository
    ) {
    }

    public function login(LoginRequestForm $request): JsonResponse
    {
        $data = $request->body();

        $user = $this->userRepository->getByEmail($data->email);
        $authToken = $this->authService->authorizeUser($data->email, $data->password);

        if ($authToken === null) {
            return response()->json('Email or password is incorrect', 400);
        }

        $userInfo = UserMapper::mapUserInfo($user);

        return response()->json($userInfo)->cookie(cookie('auth-token', $authToken, 1440));
    }

    public function logout(): JsonResponse
    {
        $this->authService->deleteAuthInfo(request()->cookie('auth-token'));
        
        return $this->successResponse()->withoutCookie('auth-token');
    }
}
