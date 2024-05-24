<?php

namespace App\Models\Permissions;

enum PermissionCode: int
{
    case AccessMusicCollection = 1;

    case ManageOwnLibrary = 2;

    case ManageOwnAlbums = 3;
}
