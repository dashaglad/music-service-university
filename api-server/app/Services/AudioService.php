<?php

declare(strict_types=1);

namespace App\Services;

use App\DataAccess\AlbumRepository;
use App\DataAccess\SongRepository;
use Illuminate\Http\UploadedFile;
use phpDocumentor\Reflection\File;

class AudioService
{
    public function __construct(
        private readonly AlbumRepository $albumRepository,
        private readonly StorageService $storageService,
        private readonly SongRepository $songRepository
    ) {
    }

    public function saveAudio(int $albumId, UploadedFile $file): ?string
    {
        $album = $this->albumRepository->getById($albumId);

        $filePath = $this->storageService->storeAudio($album->folder_id, $file);

        return $filePath;
    }

    public function deleteAudio(int $albumId, int $songId): void
    {
        $filePath = $this->songRepository->getById($songId)->path;

        $this->storageService->deleteAudio($filePath);
    }
}
