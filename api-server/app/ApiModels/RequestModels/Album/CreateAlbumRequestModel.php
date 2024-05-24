<?php

namespace App\ApiModels\RequestModels\Album;

use Illuminate\Database\Eloquent\Model;

class CreateAlbumRequestModel extends Model
{
    public string $title;
    public string $description;
}
