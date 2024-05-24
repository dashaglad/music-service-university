<?php

declare(strict_types=1);

namespace App\Services;

use App\DataAccess\UserRepository;
use App\Models\Permissions\PermissionCode;
use App\Models\Permissions\UserRole;
use Illuminate\Support\Collection;

class PermissionService
{
    private static array $rolePermissions = [
        UserRole::RegularUser->value => [
            PermissionCode::AccessMusicCollection,
            PermissionCode::ManageOwnLibrary,
        ],
        UserRole::Artist->value => [
            PermissionCode::AccessMusicCollection,
            PermissionCode::ManageOwnLibrary,
            PermissionCode::ManageOwnAlbums
        ],
    ];

    public function __construct(private readonly UserRepository $userRepository) {
    }

    /**
     * @return Collection<int, PermissionCode>
     */
    public function getPermissionsForRole(UserRole $role): Collection
    {
        return new Collection(self::$rolePermissions[$role->value]);
    }

    public function hasAccess(int $userId, PermissionCode $code): bool
    {
        $userRoles = $this->userRepository->getUserRoles($userId);

        foreach ($userRoles as $role) {
            if (in_array($code, self::$rolePermissions[$role->value], true)) {
                return true;
            }
        }

        return false;
    }
}
