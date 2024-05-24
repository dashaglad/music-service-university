import {Component, Input} from '@angular/core';
import {Song} from "../../../models/song";
import {SongService} from "../../../services/song.service";
import {AuthState} from "../../../services/auth.state";
import {User} from "../../../models/user";

@Component({
  selector: 'app-songs',
  templateUrl: './songs.component.html',
  styleUrls: ['./songs.component.scss']
})
export class SongsComponent {
  @Input() songs: Song[] = [];

  public currentUser: User | null = null;

  constructor(private songService: SongService,
              private authState: AuthState) {
    authState.getUserInfo().subscribe(userInfo => {
      this.currentUser = userInfo;
    })
  }

  public likeOrUnlikeSong(song: Song): void{
    if (song.liked) {
      this.songService.unlikeSong(song.id).subscribe(() => song.liked = false)
    } else {
      this.songService.likeSong(song.id).subscribe(() => song.liked = true)
    }
  }
}
