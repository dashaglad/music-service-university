import {Component, OnInit} from '@angular/core';
import {AuthService} from "./services/auth.service";
import {UserService} from "./services/user.service";
import {User} from "./models/user";
import {AuthState} from "./services/auth.state";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit{
  public isLoggedIn: boolean = false;
  public isArtist: boolean = false;
  public currentUser: User | null = null;

  constructor(private authService: AuthService, private userService: UserService, private authState: AuthState) {
    this.authState.getUserInfo().subscribe(userInfo => {
      if (userInfo !== null) {
        this.currentUser = userInfo;
        this.isLoggedIn = true;
        this.isArtist = (userInfo.artist !== null);
      } else {
        this.isLoggedIn = false;
        this.isArtist = false;
      }
    })
  }

  public ngOnInit(): void {
    this.userService.getCurrentUser().subscribe(
      userInfo => this.authState.setUserInfo(userInfo),
      error => {
        if (error.status === 401) {
          this.authState.setUserInfo(null);
        }
      }
    )
  }
}
