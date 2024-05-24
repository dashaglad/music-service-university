<?php

declare(strict_types=1);

namespace App\Mappers;

use App\ApiModels\SongModel;
use App\DataAccess\SongRepository;
use App\Models\Song;

class SongMapper
{
    public function mapSong(Song $song): SongModel
    {
        $userId = request()->attributes->get('authInfo')?->userId;

        $songRepository = new SongRepository();

        $model = new SongModel();
        $model->id = $song->id;
        $model->title = $song->title;
        $model->url = config('app.prefix_static') . 'audio/' . $song->path;

        $model->liked = $userId && $songRepository->checkLikeByUser($userId, $song->id);

        return $model;
    }
}
