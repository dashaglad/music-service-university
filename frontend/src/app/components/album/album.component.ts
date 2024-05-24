import {Component} from '@angular/core';
import {AlbumService} from "../../services/album.service";
import {ActivatedRoute, Router} from "@angular/router";
import {AlbumFull} from "../../models/album";
import {User} from "../../models/user";
import {AuthState} from "../../services/auth.state";

@Component({
  selector: 'app-album',
  templateUrl: './album.component.html',
  styleUrls: ['./album.component.scss']
})

export class AlbumComponent {
  public album: AlbumFull;
  public albumId: number;

  public currentUser: User | null = null;
  public isCurrentUserOwner = false;

  constructor(private albumService: AlbumService,
              private route: ActivatedRoute,
              private router: Router,
              private authState: AuthState) {

    this.album = this.route.snapshot.data['album'];
    this.albumId = this.album.id;

    this.authState.getUserInfo().subscribe(userInfo => {
      this.currentUser = userInfo;
      this.isCurrentUserOwner = (this.album.owner.id === this.currentUser?.artist?.id);
    });

  }

  public delete(): void {
    this.albumService.deleteAlbum(this.albumId).subscribe(data => this.router.navigateByUrl('/albums/own'));
  }

  public likeOrUnlikeAlbum(): void {
    if (this.album.liked) {
      this.albumService.unlikeAlbum(this.albumId).subscribe(() => this.album.liked = false)
    } else {
      this.albumService.likeAlbum(this.albumId).subscribe(() => this.album.liked = true)
    }
  }
}
