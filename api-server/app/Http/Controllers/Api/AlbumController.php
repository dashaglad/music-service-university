<?php

namespace App\Http\Controllers\Api;

use App\ApiModels\Album\AlbumModel;
use App\DataAccess\AlbumRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Album\CreateAlbumRequestForm;
use App\Http\Requests\Album\UpdateAlbumRequestForm;
use App\Mappers\AlbumMapper;
use App\Models\Album;
use Illuminate\Http\JsonResponse;

class AlbumController extends Controller
{
    public function __construct(
        private readonly AlbumRepository $albumRepository,
        private readonly AlbumMapper $albumMapper
    ) {
    }
    public function getAlbum(int $albumId): JsonResponse
    {
        $album = $this->albumRepository->getById($albumId);

        $albumFullModel = $this->albumMapper->mapFullAlbum($album);

        return $this->successResponse($albumFullModel);
    }

    public function getAlbums(): JsonResponse
    {
        $albums = $this->albumRepository->getAlbums();

        $albumsCardModels = $albums->map(
            fn(Album $album): AlbumModel => $this->albumMapper->mapAlbum($album)
        );

        return $this->successResponse($albumsCardModels);
    }

    public function createAlbum(CreateAlbumRequestForm $request): JsonResponse
    {
        $artistId = $this->getCurrentArtistId();

        $data = $request->body();

        $album = $this->albumRepository->create($artistId, $data->title, $data->description);

        return $this->successResponse($this->albumMapper->mapFullAlbum($album));
    }

    public function updateAlbum(UpdateAlbumRequestForm $request, int $albumId): JsonResponse
    {
        $data = $request->body();

        $album = $this->albumRepository->update($albumId, $data->title, $data->description);

        return $this->successResponse($this->albumMapper->mapFullAlbum($album));
    }

    public function deleteAlbum(int $albumId): JsonResponse
    {
        $this->albumRepository->delete($albumId);

        return $this->successResponse();
    }

    public function likeAlbum(int $albumId): JsonResponse
    {
        $userId = $this->getCurrentUserId();

        $this->albumRepository->likeAlbum($userId, $albumId);

        return $this->successResponse();
    }

    public function unlikeAlbum(int $albumId): JsonResponse
    {
        $userId = $this->getCurrentUserId();

        $this->albumRepository->unlikeAlbum($userId, $albumId);

        return $this->successResponse();
    }

    public function getPopularAlbums(): JsonResponse
    {
        $count = request()->input('albumsCount');
        $count = ((string)(int)$count === $count) ? (int)$count : null;

        $popularAlbums = $this->albumRepository->getAlbumsOrderByDescLikes($count);

        $albumsCardModels = $popularAlbums->map(
            fn(Album $album): AlbumModel => $this->albumMapper->mapAlbum($album)
        );

        return $this->successResponse($albumsCardModels);
    }

    public function getFavoriteAlbums(): JsonResponse
    {
        $count = request()->input('albumsCount');
        $count = ((string)(int)$count === $count) ? (int)$count : null;

        $userId = $this->getCurrentUserId();

        $albums = $this->albumRepository->getFavoriteAlbums($userId, $count);

        $albumsCardModels = $albums->map(
            fn(Album $album): AlbumModel => $this->albumMapper->mapAlbum($album)
        );

        return $this->successResponse($albumsCardModels);
    }

    public function getOwnAlbums(): JsonResponse
    {
        $artistId = $this->getCurrentArtistId();

        $albums = $this->albumRepository->getAlbumsByArtist($artistId);

        $albumsCardModels = $albums->map(
            fn(Album $album): AlbumModel => $this->albumMapper->mapAlbum($album)
        );

        return $this->successResponse($albumsCardModels);
    }

    public function getLatestAlbums(): JsonResponse
    {
        $count = request()->input('albumsCount');
        $count = ((string)(int)$count === $count) ? (int)$count : null;

        $albums = $this->albumRepository->getLatestAlbums($count);

        $albumsCardModels = $albums->map(
            fn(Album $album): AlbumModel => $this->albumMapper->mapAlbum($album)
        );

        return $this->successResponse($albumsCardModels);
    }

}
