<?php

namespace App\Http\Controllers\Api;

use App\DataAccess\UserRepository;
use App\Http\Controllers\Controller;
use App\Mappers\UserMapper;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function getCurrentUser(): JsonResponse
    {
        $currUserId = $this->getCurrentUserId();

        return $currUserId !== null
            ? $this->successResponse(UserMapper::mapUserInfo($this->userRepository->getById($currUserId)))
            : $this->failResponse('No current User');
    }
}
