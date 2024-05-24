<?php

declare(strict_types=1);

namespace App\Models\Auth;

class AuthInfo
{
    public int $userId;
    public string $userEmail;

    /** @var string[] */
    public array $permissions;

    public ?int $artistId;
    public ?string $artistName;
}
