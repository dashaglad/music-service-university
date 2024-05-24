<?php

declare(strict_types=1);

namespace App\Mappers;

use App\ApiModels\Album\AlbumFullModel;
use App\ApiModels\Album\AlbumModel;
use App\ApiModels\SongModel;
use App\DataAccess\AlbumRepository;
use App\DataAccess\ArtistRepository;
use App\DataAccess\SongRepository;
use App\DataAccess\UserRepository;
use App\Models\Album;
use App\Models\Song;

class AlbumMapper
{
    public function mapAlbum(Album $album): AlbumModel
    {
        $userId = request()->attributes->get('authInfo')?->userId;

        $albumRepository = new AlbumRepository();
        $userRepository = new UserRepository();
        $artistRepository = new ArtistRepository();

        $artistMapper = new ArtistMapper();

        $model = new AlbumModel();
        $model->id = $album->id;
        $model->title = $album->title;
        $model->date = $album->created_at;
        $model->description = $album->description;
        $model->owner = $artistMapper->mapArtist($artistRepository->getAlbumOwner($album->id));

        $users = $userRepository->getUsersByAlbum($album->id);
        $model->likes = $users->count();

        $model->liked = $userId && $albumRepository->checkLikeByUser($userId, $album->id);

        return $model;
    }

    public function mapFullAlbum(Album $album): AlbumFullModel
    {
        $userId = request()->attributes->get('authInfo')?->userId;

        $albumRepository = new AlbumRepository();
        $artistRepository = new ArtistRepository();
        $songRepository = new SongRepository();
        $userRepository = new UserRepository();

        $artistMapper = new ArtistMapper();
        $songMapper = new SongMapper();

        $songs = $songRepository->getSongsByAlbum($album->id);
        $users = $userRepository->getUsersByAlbum($album->id)->pluck('id')->toArray();

        $model = new AlbumFullModel();
        $model->id = $album->id;
        $model->title = $album->title;
        $model->date = $album->created_at;
        $model->description = $album->description;
        $model->songs = $songs->map(fn(Song $song): SongModel => $songMapper->mapSong($song))->toArray();
        $model->owner = $artistMapper->mapArtist($artistRepository->getAlbumOwner($album->id));
        $model->users = $users;
        $model->songsCount = $songs->count();
        $model->likes = count($users);

        $model->liked = $userId && $albumRepository->checkLikeByUser($userId, $album->id);

        return $model;
    }
}
