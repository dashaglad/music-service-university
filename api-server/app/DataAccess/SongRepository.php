<?php

declare(strict_types=1);

namespace App\DataAccess;

use App\Models\Song;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class SongRepository
{
    public function getById(int $songId): ?Song
    {
        return Song::query()->where('id', '=', $songId)->first();
    }

    /**
     * @return Collection<int, Song>
     */
    public function getSongsByAlbum(int $albumId): Collection
    {
        return Song::query()->where('album_id', '=', $albumId)->get();
    }

    public function create(int $albumId, string $title, int $duration, string $filePath): Song
    {
        $song = new Song();
        $song->album_id = $albumId;
        $song->title = $title;
        $song->duration = $duration;
        $song->path = $filePath;

        $song->save();

        return $song;
    }

    public function delete(int $songId): void
    {
        DB::table('song_user')->where('song_id', '=', $songId)->delete();

        Song::query()->where('id', '=', $songId)->delete();
    }

    /**
     * @param int $userId
     * @return Collection<int, Song>
     */
    public function getFavoriteSongs(int $userId, int $count = null): Collection
    {
        $songs = Song::query()
            ->join('song_user', 'songs.id', '=', 'song_user.song_id')
            ->select('songs.*')
            ->where('user_id', $userId);

        return $count !== null
            ? $songs->take($count)->get()
            : $songs->get();
    }

    public function likeSong(int $userId, int $songId): void
    {
        DB::table('song_user')->insert(['user_id' => $userId, 'song_id' => $songId]);
    }

    public function unlikeSong(int $userId, int $songId): void
    {
        DB::table('song_user')->where('song_id', '=', $songId)->where('user_id', '=', $userId)->delete();
    }

    public function checkLikeByUser(int $userId, int $songId): bool
    {
        return DB::table('song_user')
            ->where('song_id', '=', $songId)
            ->where('user_id', '=', $userId)
            ->where('deleted_at', '=', null)
            ->exists();
    }
}
