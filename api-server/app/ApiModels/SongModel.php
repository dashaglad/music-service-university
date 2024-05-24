<?php

declare(strict_types=1);

namespace App\ApiModels;

class SongModel
{
    public int $id;

    public string $title;
    
    public ?string $url;

    public bool $liked;
}
