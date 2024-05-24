<?php

declare(strict_types=1);

namespace App\DataAccess;

use App\Models\Permissions\UserRole;
use App\Models\User;
use App\Utils\EnumBitmapEncoder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    public function getById(int $userId): ?User
    {
        return User::query()->where('id', '=', $userId)->first();
    }

    public function getByEmail(string $email): ?User
    {
        return User::query()->where('email', '=', $email)->first();
    }

    /**
     * @param int $albumId
     * @return Collection<int, User>
     */
    public function getUsersByAlbum(int $albumId): Collection
    {
        return User::query()
            ->join('album_user', 'users.id', '=', 'album_user.user_id')
            ->select('users.*')
            ->where('album_id', $albumId)->get();
    }

    public function createUser(string $email, string $password): void
    {
        DB::table('users')->insert([
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 1
        ]);
    }

    public function isUserExistsByEmail(string $email): bool
    {
        return User::query()->where('email', '=', $email)->exists();
    }

    public function isUserExists(int $id): bool
    {
        return User::query()->where('id', '=', $id)->exists();
    }

    public function getUserRoles(int $id): Collection
    {
        $user = User::find($id);

        if ($user === null) {
            return new Collection();
        }

        return EnumBitmapEncoder::decode(UserRole::cases(), $user->roles)
            ->map(fn(int $role): UserRole => UserRole::from($role));
    }

    public function delete(int $id): void
    {
        User::query()->where('id', '=', $id)->delete();
    }
}
