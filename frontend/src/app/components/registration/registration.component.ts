import { Component } from '@angular/core';
import {AuthService} from "../../services/auth.service";
import {Router} from "@angular/router";
import {FormControl, FormGroup, Validators} from "@angular/forms";
import {AuthState} from "../../services/auth.state";

@Component({
  selector: 'app-registration',
  templateUrl: './registration.component.html',
  styleUrls: ['./registration.component.scss']
})
export class RegistrationComponent {
  public form: FormGroup;

  constructor(
    private authService: AuthService,
    private router: Router,
    private authState: AuthState
  ) {
    this.form = new FormGroup({
      email: new FormControl(null, [Validators.required, Validators.email]),
      password: new FormControl(null, [Validators.required])
    });
  }

  public get emailControl() {
    return this.form.get('email');
  }

  public get passwordControl() {
    return this.form.get('password');
  }

  public submit(): void {
    if (this.form.valid) {
      this.authService.register(this.form.value).subscribe(authInfo => {
        this.authState.setUserInfo(authInfo);
        this.router.navigateByUrl('/');
      });
    }
  }
}
