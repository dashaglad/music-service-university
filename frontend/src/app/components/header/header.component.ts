import {Component, Input} from '@angular/core';
import {AuthService} from "../../services/auth.service";
import {Router} from "@angular/router";
import {User} from "../../models/user";
import {AuthState} from "../../services/auth.state";
import {UserService} from "../../services/user.service";

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})
export class HeaderComponent {
  @Input() isLoggedIn: boolean = false;
  @Input() isArtist: boolean = false;
  @Input() currentUser: User | null = null;


  constructor(private router: Router,
              private authService: AuthService,
              private authState: AuthState) {
  }

  public logout(): void {
    this.authService.logout().subscribe(data => {
      this.authState.setUserInfo(null);
      this.router.navigateByUrl('/login');
    });
  }
}
