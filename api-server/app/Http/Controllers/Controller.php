<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getCurrentUserId(): ?int
    {
        return request()->attributes->get('authInfo')?->userId;
    }

    protected function getCurrentArtistId(): ?int
    {
        return request()->attributes->get('authInfo')?->artistId;
    }

    public function successResponse(mixed $data = null): JsonResponse
    {
        return response()->json($data);
    }

    public function failResponse(string $message): JsonResponse
    {
        return response()->json($message, 400);
    }
}
