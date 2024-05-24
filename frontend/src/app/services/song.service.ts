import {Injectable} from '@angular/core';
import {Observable} from "rxjs";
import {Song} from "../models/song";
import {HttpClient} from "@angular/common/http";

@Injectable({
  providedIn: 'root'
})
export class SongService {
  constructor(private http: HttpClient) {
  }

  public createSong(albumId: number, formData: FormData): Observable<any> {
    return this.http.post<any>(`api/albums/${albumId}/songs/create`, formData);
  }

  public getFavoriteUserSongs(count: Number | null = null): Observable<Song[]> {
    let url = `/api/songs/favorite` + ((count !== null) ? `?songsCount=${count}` : '');
    return this.http.get<Song[]>(url);
  }

  public likeSong(songId: number): Observable<any> {
    return this.http.post<any>(`api/songs/${songId}/like`, {});
  }

  public unlikeSong(songId: number): Observable<any> {
    return this.http.post<any>(`api/songs/${songId}/unlike`, {});
  }

}
