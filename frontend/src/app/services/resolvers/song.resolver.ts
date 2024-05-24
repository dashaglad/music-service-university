import { inject } from "@angular/core";
import { ActivatedRouteSnapshot, ResolveFn, RouterStateSnapshot } from "@angular/router";
import {Song} from "../../models/song";
import {SongService} from "../song.service";

export const favoriteSongsListResolver: ResolveFn<Song[]> =
  (route: ActivatedRouteSnapshot, state: RouterStateSnapshot) => {
    return inject(SongService).getFavoriteUserSongs();
  };



