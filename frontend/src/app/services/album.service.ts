import {Injectable} from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";
import {AlbumCard} from "../models/album";
import {AlbumFull} from "../models/album";
import {AuthService} from "./auth.service";

@Injectable({
  providedIn: 'root'
})
export class AlbumService {
  constructor(private http: HttpClient, private authService: AuthService) {
  }

  public getAlbums(): Observable<AlbumCard[]> {
    return this.http.get<AlbumCard[]>(`/api/albums`);
  }

  public getAlbum(albumId: number): Observable<AlbumFull> {
    return this.http.get<AlbumFull>(`/api/albums/${albumId}`);
  }

  public createAlbum(album: { title: string, description: string }): Observable<AlbumFull> {
    return this.http.put<AlbumFull>('api/albums/create', album);
  }

  public updateAlbum(album: { title: string | null, description: string | null}, albumId: number): Observable<AlbumFull> {
    return this.http.post<AlbumFull>(`api/albums/${albumId}/edit`, album);
  }

  public likeAlbum(albumId: number): Observable<any> {
    return this.http.post<any>(`api/albums/${albumId}/like`, {});
  }

  public unlikeAlbum(albumId: number): Observable<any> {
    return this.http.post<any>(`api/albums/${albumId}/unlike`, {});
  }

  public deleteAlbum(albumId: number): Observable<any> {
    return this.http.delete(`api/albums/${albumId}/delete`);
  }

  public getPopularAlbums(count: Number | null = null): Observable<AlbumCard[]> {
    let url = `/api/albums/popular` + ((count !== null) ? `?albumsCount=${count}` : '');
    return this.http.get<AlbumCard[]>(url);
  }

  public getFavoriteUserAlbums(count: Number | null = null): Observable<AlbumCard[]> {
    let url = `/api/albums/favorite` + ((count !== null) ? `?albumsCount=${count}` : '');
    return this.http.get<AlbumCard[]>(url);
  }

  public getOwnArtistAlbums(): Observable<AlbumCard[]> {
    return this.http.get<AlbumCard[]>(`/api/albums/own`);
  }

  public getLatestAlbums(count: Number | null = null): Observable<AlbumCard[]> {
    let url = `/api/albums/latest` + ((count !== null) ? `?albumsCount=${count}` : '');
    return this.http.get<AlbumCard[]>(url);
  }

}

