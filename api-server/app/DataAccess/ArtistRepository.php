<?php

declare(strict_types=1);

namespace App\DataAccess;

use App\Models\Album;
use App\Models\Artist;
use Illuminate\Support\Collection;

class ArtistRepository
{
    /**
     * @param int $artistId
     * @return Artist|null
     */
    public function getArtistById(int $artistId): ?Artist
    {
        return Artist::query()->where('id', '=', $artistId)->first();
    }

    /**
     * @param int $albumId
     * @return Artist|null
     */
    public function getAlbumOwner(int $albumId): ?Artist
    {
        $album = Album::query()->where('id', '=', $albumId)->first();

        return Artist::query()->where('id', '=', $album->artist_id)->first();
    }

    /**
     * @param int $albumId
     * @return Collection<int, Artist>
     */
    public function getArtistsByAlbum(int $albumId): Collection
    {
        $album = Album::query()->where('id', '=', $albumId)->first();

        $owner = Artist::query()->where('id', '=', $album->artist_id);

        // todo: other artists
        $artists = $owner;

        return $artists->get();
    }
}
