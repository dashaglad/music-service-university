import {Component, Input, OnInit} from '@angular/core';
import {AuthService} from "../../services/auth.service";
import {User} from "../../models/user";
import {Router} from "@angular/router";
import {UserService} from "../../services/user.service";
import {AuthState} from "../../services/auth.state";

@Component({
  selector: 'app-navigation',
  templateUrl: './navigation.component.html',
  styleUrls: ['./navigation.component.scss']
})
export class NavigationComponent{
  @Input() isLoggedIn: boolean = false;
  @Input() isArtist: boolean = false;
  @Input() currentUser: User|null = null;
}
