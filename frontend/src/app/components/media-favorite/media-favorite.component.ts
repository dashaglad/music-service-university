import { Component } from '@angular/core';
import {AlbumCard} from "../../models/album";
import {Song} from "../../models/song";
import {AlbumService} from "../../services/album.service";
import {ActivatedRoute} from "@angular/router";
import {SongService} from "../../services/song.service";

@Component({
  selector: 'app-media-favorite',
  templateUrl: './media-favorite.component.html',
  styleUrls: ['./media-favorite.component.scss']
})
export class MediaFavoriteComponent {
  songsCount: number = 5;

  public albums: AlbumCard[] = [];

  public songs: Song[] = [];

  constructor(private albumService: AlbumService, private songService: SongService, private route: ActivatedRoute) {
    this.albums = this.route.snapshot.data['albums'];
    // this.songs= this.route.snapshot.data['songs'];

    songService.getFavoriteUserSongs(this.songsCount).subscribe(
      songs => this.songs = songs
    )

  }
}
