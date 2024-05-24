<?php

declare(strict_types=1);

namespace App\Mappers;

use App\ApiModels\ArtistModel;
use App\Models\Artist;

class ArtistMapper
{
    public function mapArtist(Artist $artist): ArtistModel
    {
        $model = new ArtistModel();
        $model->id = $artist->id;
        $model->name = $artist->name;

        return $model;
    }
}
