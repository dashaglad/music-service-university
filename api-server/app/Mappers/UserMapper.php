<?php

declare(strict_types=1);

namespace App\Mappers;

use App\ApiModels\UserInfoModel;
use App\DataAccess\ArtistRepository;
use App\Models\User;


class UserMapper
{
    public static function mapUserInfo(User $user): UserInfoModel
    {
        $model = new UserInfoModel();
        $model->id = $user->id;
        $model->email = $user->email;
        $model->artist = $user->artist_id
            ? (new ArtistMapper())->mapArtist((new ArtistRepository())->getArtistById($user->artist_id))
            : null;

        return $model;
    }
}
