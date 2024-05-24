<?php

namespace App\Http\Controllers\Api;

use App\DataAccess\UserRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequestForm;
use App\Mappers\UserMapper;
use App\Services\AuthService;
use AWS\CRT\HTTP\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class RegisterController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly AuthService $authService
    ) {
    }

    public function register(RegisterRequestForm $request): JsonResponse
    {
        $data = $request->body();

        if ($this->userRepository->isUserExistsByEmail($data->email)){
            return response()->json('User already exists', 400);
        }

        $this->userRepository->createUser($data->email, $data->password);

        $user = $this->userRepository->getByEmail($data->email);
        $authToken = $this->authService->authorizeUser($data->email, $data->password);

        $userInfo = UserMapper::mapUserInfo($user);

        return response()->json($userInfo)->cookie(cookie('auth-token', $authToken, 1440));
    }
}
