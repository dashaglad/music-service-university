import {Injectable} from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";
import {User} from "../models/user";

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  constructor(private http: HttpClient) {
  }

  public login(authInfo: { email: string, password: string }): Observable<User> {
    return this.http.post<User>('api/login', authInfo);
  }

  public register(authInfo: { email: string, password: string }): Observable<User> {
    return this.http.post<User>('api/register', authInfo);
  }

  public logout(): Observable<any> {
    return this.http.post<User>('/api/logout', {});
  }

  // public setCurrentUser(data: User): void {
  //   console.log(data);
  //   localStorage.setItem('userId', String(data.id));
  //   localStorage.setItem('userEmail', data.email);
  //   if (data.artist !== null) {
  //     localStorage.setItem('userArtistName', data?.artist.name);
  //     localStorage.setItem('userArtistId', String(data?.artist.id));
  //   }
  // }
  //
  // public getCurrentUser(): User {
  //   return <User>{
  //     id: Number(localStorage.getItem('userId')),
  //     email: String(localStorage.getItem('userEmail')),
  //     artist: localStorage.getItem('userArtistId')
  //       ? <Artist>{id: Number(localStorage.getItem('userArtistId')), name: localStorage.getItem('userArtistName')}
  //       : null
  //   }
  // }
}
