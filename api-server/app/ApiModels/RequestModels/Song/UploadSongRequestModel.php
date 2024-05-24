<?php

namespace App\ApiModels\RequestModels\Song;

use Illuminate\Http\UploadedFile;

class UploadSongRequestModel
{
    public string $title;

    public UploadedFile $file;
}
