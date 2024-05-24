<?php

namespace App\Http\Middleware;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckOwnership
{
    public function __construct()
    {
    }

    public function handle(Request $request, \Closure $next)
    {
        $artistId = $request->attributes->get('authInfo')->artistId;
        $albumId = request()->route('albumId');
        $album = Album::query()->where('id', '=', $albumId)->first();

        return ($album->artist_id === $artistId)
            ? $next($request)
            : response(status: 403);
    }
}
