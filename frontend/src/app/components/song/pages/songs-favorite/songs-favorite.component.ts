import { Component } from '@angular/core';
import {Song} from "../../../../models/song";
import {AlbumService} from "../../../../services/album.service";
import {ActivatedRoute, Router} from "@angular/router";

@Component({
  selector: 'app-songs-favorite',
  templateUrl: './songs-favorite.component.html',
  styleUrls: ['./songs-favorite.component.scss']
})
export class SongsFavoriteComponent {
  public songs: Song[] = [];

  constructor(private albumService: AlbumService,
              private route: ActivatedRoute) {

    this.songs = this.route.snapshot.data['songs'];
  }
}
