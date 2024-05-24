<?php

declare(strict_types=1);

namespace App\ApiModels\Album;

use App\ApiModels\SongModel;

class AlbumFullModel extends AlbumModel
{
    /** @var SongModel[] */
    public array $songs;

    /** @var int[] */
    public array $users;
    public int $songsCount;
}
