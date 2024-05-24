import {Injectable} from "@angular/core";
import {BehaviorSubject, Observable} from "rxjs";
import {User} from "../models/user";

@Injectable({
  providedIn: 'root'
})
export class AuthState {

  private userInfo: BehaviorSubject<User | null> = new BehaviorSubject<User | null>(null);

  private _isLoading: boolean = true;

  public setUserInfo(user: User | null): void {
    this._isLoading = false;
    this.userInfo.next(user);
  }

  public getUserInfo(): Observable<User | null> {
    return this.userInfo;
  }

  public get isLoading(): boolean {
    return this._isLoading;
  }
}
