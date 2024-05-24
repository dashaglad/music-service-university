<?php

namespace App\DataAccess;

use App\Models\Album;
use App\Models\Genre;
use App\Models\Song;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AlbumRepository
{
    public function getById(int $albumId): ?Album
    {
        return Album::query()->where('id', '=', $albumId)->first();
    }

    /**
     * @return Collection<int, Album>
     */
    public function getAlbums(): Collection
    {
        return Album::query()->get();
    }

    /**
     * @param int $userId
     * @return Collection<int, Album>
     */
    public function getFavoriteAlbums(int $userId, int $count = null): Collection
    {
        $albums = Album::query()
            ->join('album_user', 'albums.id', '=', 'album_user.album_id')
            ->select('albums.*')
            ->where('user_id', $userId);

        return $count !== null
            ? $albums->take($count)->get()
            : $albums->get();
    }

    /**
     * @param int $artistId
     * @return Collection<int, Album>
     */
    public function getAlbumsByArtist(int $artistId): Collection
    {
        return Album::query()->where('artist_id', $artistId)->get();
    }

    public function create(int $artistId, string $title, string $description): Album
    {
        $album = new Album();

        $album->title = $title;
        $album->date = Carbon::today();
        $album->folder_id = uniqid(more_entropy: true);
        $album->artist_id = $artistId;
        $album->genre_id = Genre::all()->random()->id;
        $album->description = $description;
        $album->save();

        return $album;
    }

    public function delete(int $albumId): void
    {
        DB::table('album_user')->where('album_id', '=', $albumId)->delete();
        $songsIds = Song::query()->where('album_id', '=', $albumId)->pluck('id')->toArray();
        foreach ($songsIds as $songId) DB::table('song_user')->where('song_id', '=', $songId)->delete();
        Song::query()->where('album_id','=', $albumId)->delete();

        Album::query()->where('id', '=', $albumId)->delete();
    }

    public function update(int $albumId, ?string $title, ?string $description): Album
    {
        $album = Album::find($albumId);
        $album->title = $title ?: $album->title;
        $album->description = $description ?: $album->description;
        $album->save();

        return $album;
    }

    /**
     * @return Collection<int, Album>
     */
    public function getAlbumsOrderByDescLikes(int $count = null): Collection
    {
        $albums = Album::query()->leftJoin('album_user', 'albums.id', '=', 'album_user.album_id')
            ->select('albums.*')
            ->selectRaw('COUNT(IF(album_user.user_id is null, null, 1)) as likes_count')
            ->groupBy('albums.id')
            ->orderByDesc('likes_count')
            ->orderBy('id');

        return $count !== null
            ? $albums->take($count)->get()
            : $albums->get();
    }

    public function likeAlbum(int $userId, int $albumId): void
    {
        DB::table('album_user')->insert(['user_id' => $userId, 'album_id' => $albumId]);
    }

    public function unlikeAlbum(int $userId, int $albumId): void
    {
        DB::table('album_user')->where('album_id', '=', $albumId)->where('user_id', '=', $userId)->delete();
    }

    public function checkLikeByUser(int $userId, int $albumId): bool
    {
        return DB::table('album_user')
            ->where('album_id', '=', $albumId)
            ->where('user_id', '=', $userId)
            ->where('deleted_at', '=', null)
            ->exists();
    }

    public function getLatestAlbums(int $count = null): Collection
    {
        return $count !== null
            ? Album::query()->orderByDesc('created_at')->take($count)->get()
            : Album::query()->orderByDesc('created_at')->get();
    }
}
