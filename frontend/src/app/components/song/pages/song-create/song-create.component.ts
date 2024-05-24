import {Component} from '@angular/core';
import {FormControl, FormGroup, Validators} from "@angular/forms";
import {ActivatedRoute} from "@angular/router";
import {SongService} from "../../../../services/song.service";

@Component({
  selector: 'app-song-create',
  templateUrl: './song-create.component.html',
  styleUrls: ['./song-create.component.scss']
})
export class SongCreateComponent{
  public form: FormGroup;

  public albumId: number;

  constructor(private route: ActivatedRoute,private songService: SongService) {
    this.form = new FormGroup({
      title: new FormControl('', [Validators.required]),
      file: new FormControl('', [Validators.required]),
      fileSource: new FormControl('', [Validators.required])
    });

    this.albumId = parseInt(route.snapshot.params['albumId']);
  }

  public onFileChange(event: Event) {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files.length) {
      const file: File = (target.files as FileList)[0];
      this.form.patchValue({
        fileSource: file
      });
    }
  }

  public get titleControl() {
    return this.form.get('title');
  }

  public get fileControl() {
    return this.form.get('file');
  }

  public submit(): void {
    if (this.form.valid) {
      const formData = new FormData();
      formData.append('title', this.form.get('title')?.value);
      formData.append('file', this.form.get('fileSource')?.value);
      this.songService.createSong(this.albumId, formData).subscribe(() => {
        console.log('success');
      })
    }
  }
}
