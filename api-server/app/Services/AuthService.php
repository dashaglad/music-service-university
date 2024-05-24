<?php

declare(strict_types=1);

namespace App\Services;

use App\DataAccess\ArtistRepository;
use App\DataAccess\UserRepository;
use App\Models\Auth\AuthInfo;
use App\Models\Permissions\UserRole;
use App\Utils\EnumBitmapEncoder;
use App\Utils\RedisConnection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly ArtistRepository $artistRepository,
        private readonly PermissionService $permissionService
    ) {
    }

    public function authorizeUser(string $email, string $password): ?string
    {
        $user = $this->userRepository->getByEmail($email);

        if ($user === null) {
            return null;
        }

        if (!Hash::check($password, $user->password)) {
            return null;
        }

        $authInfo = new AuthInfo();
        $authInfo->userId = $user->id;
        $authInfo->artistId = $user->artist_id;
        $authInfo->userEmail = $email;
        $authInfo->artistName = ($user->artist_id)
            ? $this->artistRepository->getArtistById($user->artist_id)->name
            : null;

        $authInfo->permissions = EnumBitmapEncoder::decode(UserRole::cases(), $user->role)
            ->map(fn(int $role): Collection => $this->permissionService->getPermissionsForRole(UserRole::from($role)))
            ->flatten()
            ->toArray();

        return $this->saveAuthInfo($authInfo);
    }

    public function getAuthInfo(string $token): ?AuthInfo
    {
        $tokenData = Crypt::decrypt($token);

        if (!isset($tokenData->userId, $tokenData->expiresAt) || Carbon::now()->gte($tokenData->expiresAt)) {
            return null;
        }

        $authInfoJson = RedisConnection::appCache()->get("auth-tokens:{$tokenData->userId}");

        return $authInfoJson !== null
            ? (new \JsonMapper())->map(json_decode($authInfoJson), new AuthInfo())
            : null;
    }

    public function saveAuthInfo(AuthInfo $authInfo): string
    {
        $now = Carbon::now();
        $expiresAt = Carbon::now()->addDay();

        RedisConnection::appCache()->set(
            "auth-tokens:{$authInfo->userId}",
            json_encode($authInfo),
            'EX',
            $expiresAt->diffInSeconds($now)
        );

        $tokenData = (object)[
            'userId' => $authInfo->userId,
            'expiresAt' => $expiresAt,
            'salt' => $this->randomSalt()
        ];

        return Crypt::encrypt($tokenData);
    }

    public function deleteAuthInfo(string $token): void
    {
        $userId = (int)Crypt::decrypt($token)->userId;

        RedisConnection::appCache()->del("auth-tokens:{$userId}");
    }

    private function randomSalt(): string
    {
        return substr(str_shuffle(MD5(microtime())), 0, 10);
    }
}
