<?php

declare(strict_types=1);

namespace App\ApiModels\Album;

use App\ApiModels\ArtistModel;
use Carbon\Carbon;

class AlbumModel
{
    public int $id;

    public string $title;
    public ArtistModel $owner;
    public int $likes;

    public string $description;
    public Carbon $date;

    public bool $liked;
}
