import {Component} from '@angular/core';
import {FormGroup, FormControl, Validators} from "@angular/forms";
import {Router} from "@angular/router";
import {AlbumService} from "../../../../services/album.service";

@Component({
  selector: 'app-album-create',
  templateUrl: './album-create.component.html',
  styleUrls: ['./album-create.component.scss']
})
export class AlbumCreateComponent {
  public form: FormGroup;

  constructor(
    private albumService: AlbumService,
    private router: Router
  ) {
    this.form = new FormGroup({
      title: new FormControl(null, [Validators.required]),
      description: new FormControl(null, [Validators.required])
    });
  }

  public get titleControl() {
    return this.form.get('title');
  }

  public get descriptionControl() {
    return this.form.get('description');
  }

  public submit(): void {
    if (this.form.valid) {
      this.albumService.createAlbum(this.form.value).subscribe(album => {
        this.router.navigateByUrl('/albums/' + album.id);
      });
    }
  }
}
