<?php

namespace App\Http\Controllers\Api;

use App\ApiModels\SongModel;
use App\DataAccess\SongRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Song\UploadSongRequestForm;
use App\Mappers\SongMapper;
use App\Models\Song;
use App\Services\AudioService;
use Illuminate\Http\JsonResponse;

class SongController extends Controller
{

    public function __construct(
        private readonly SongRepository $songRepository,
        private readonly AudioService $audioService,
        private readonly SongMapper $songMapper
    ) {
    }

    public function createSong(UploadSongRequestForm $request, $albumId): JsonResponse
    {
        $data = $request->body();

        $filePath = $this->audioService->saveAudio($albumId, $data->file);

        $song = $this->songRepository->create($albumId, $data->title, 0, $filePath);

        return $this->successResponse($this->songMapper->mapSong($song));
    }

    public function deleteSong(int $albumId, int $songId): JsonResponse
    {
        $this->audioService->deleteAudio($albumId, $songId);
        $this->songRepository->delete($songId);
        return $this->successResponse($songId);
    }

    public function getFavoriteSongs(): JsonResponse
    {
        $count = request()->input('songsCount');
        $count = ((string)(int)$count === $count) ? (int)$count : null;

        $userId = $this->getCurrentUserId();

        $albums = $this->songRepository->getFavoriteSongs($userId, $count);

        $albumsCardModels = $albums->map(
            fn(Song $album): SongModel => $this->songMapper->mapSong($album)
        );

        return $this->successResponse($albumsCardModels);
    }

    public function likeSong(int $songId): JsonResponse
    {
        $userId = $this->getCurrentUserId();

        $this->songRepository->likeSong($userId, $songId);

        return $this->successResponse();
    }

    public function unlikeSong(int $songId): JsonResponse
    {
        $userId = $this->getCurrentUserId();

        $this->songRepository->unlikeSong($userId, $songId);

        return $this->successResponse();
    }


}
