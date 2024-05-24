<?php

declare(strict_types=1);

namespace App\Services;

use Aws\S3\S3Client;
use Illuminate\Http\UploadedFile;

class StorageService
{
    public function storeAudio(string $albumFolderId, UploadedFile $file): string
    {
        $fileName = uniqid(more_entropy: true);
        $filePath = "{$albumFolderId}/{$fileName}.mp3";

        $this->getClient()->putObject(
            [
                'Bucket' => 'audio',
                'Key' => $filePath,
                'ACL' => 'public-read',
                'Body' => $file->getContent(),
            ]
        );

        $this->getClient()->waitUntil('ObjectExists', ['Bucket' => 'audio', 'Key' => $filePath]);

        return $filePath;
    }

    public function deleteAudio(string $filePath): void
    {
        $this->getClient()->deleteObject(
            [
                'Bucket' => 'audio',
                'Key' => $filePath
            ]
        );
    }

    private function getClient(): S3Client
    {
        return new S3Client(config('aws'));
    }
}
