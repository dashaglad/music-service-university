<?php

namespace App\ApiModels\RequestModels\Album;

use Illuminate\Database\Eloquent\Model;

class UpdateAlbumRequestModel extends Model
{
    public ?string $title;
    public ?string $description;
}
