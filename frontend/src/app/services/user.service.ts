import { Injectable } from '@angular/core';
import {User} from "../models/user";
import {Artist} from "../models/artist";
import {Observable} from "rxjs";
import {HttpClient} from "@angular/common/http";

@Injectable({
  providedIn: 'root'
})
export class UserService {

  constructor(private http: HttpClient) { }

  public getCurrentUser(): Observable<User> {
    return this.http.get<User>('api/users/current');
  }
}
