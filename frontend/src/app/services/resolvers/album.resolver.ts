import { inject } from "@angular/core";
import { ActivatedRouteSnapshot, ResolveFn, RouterStateSnapshot } from "@angular/router";
import {AlbumCard, AlbumFull} from "../../models/album";
import {AlbumService} from "../album.service";

export const albumResolver: ResolveFn<AlbumFull> =
    (route: ActivatedRouteSnapshot, state: RouterStateSnapshot) => {
        return inject(AlbumService).getAlbum(+route.paramMap.get('albumId')!);
    };

export const albumsListResolver: ResolveFn<AlbumCard[]> =
  (route: ActivatedRouteSnapshot, state: RouterStateSnapshot) => {
    return inject(AlbumService).getAlbums();
  };

export const popularAlbumsListResolver: ResolveFn<AlbumCard[]> =
  (route: ActivatedRouteSnapshot, state: RouterStateSnapshot) => {
    return inject(AlbumService).getPopularAlbums();
  };

export const favoriteAlbumsListResolver: ResolveFn<AlbumCard[]> =
  (route: ActivatedRouteSnapshot, state: RouterStateSnapshot) => {
    return inject(AlbumService).getFavoriteUserAlbums();
  };

export const ownAlbumsListResolver: ResolveFn<AlbumCard[]> =
  (route: ActivatedRouteSnapshot, state: RouterStateSnapshot) => {
    return inject(AlbumService).getOwnArtistAlbums();
  };


