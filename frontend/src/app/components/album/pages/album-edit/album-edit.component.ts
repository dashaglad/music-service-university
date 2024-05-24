import {Component} from '@angular/core';
import {AlbumFull} from "../../../../models/album";
import {AlbumService} from "../../../../services/album.service";
import {ActivatedRoute, Router} from "@angular/router";
import {FormControl, FormGroup} from "@angular/forms";

@Component({
  selector: 'app-album-edit',
  templateUrl: './album-edit.component.html',
  styleUrls: ['./album-edit.component.scss']
})
export class AlbumEditComponent {
  public form: FormGroup;

  public album: AlbumFull;
  public albumId: number;

  constructor(private albumService: AlbumService,
              private route: ActivatedRoute,
              private router: Router
  ) {
    this.album = this.route.snapshot.data['album'];

    console.log(this.album);
    this.albumId = this.album.id;
    console.log(this.albumId);

    this.form = new FormGroup({
      title: new FormControl(null),
      description: new FormControl(null)
    });
  }

  public submit(): void {
    if (this.form.valid) {
      this.albumService.updateAlbum(this.form.value, this.albumId).subscribe(album => {
        this.router.navigateByUrl('/albums/' + album.id + '/edit');
      });
    }
  }
}
