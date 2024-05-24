<?php

declare(strict_types=1);

namespace App\ApiModels;

class UserInfoModel
{
    public int $id;

    public string $email;

    public ?ArtistModel $artist;
}
