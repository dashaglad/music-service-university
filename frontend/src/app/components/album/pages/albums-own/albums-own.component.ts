import { Component } from '@angular/core';
import {AlbumCard} from "../../../../models/album";
import {AlbumService} from "../../../../services/album.service";
import {ActivatedRoute} from "@angular/router";

@Component({
  selector: 'app-albums-own',
  templateUrl: './albums-own.component.html',
  styleUrls: ['./albums-own.component.scss']
})
export class AlbumsOwnComponent {
  public albums: AlbumCard[] = [];

  constructor(private albumService: AlbumService, private route: ActivatedRoute) {
    this.albums = this.route.snapshot.data['albums'];
  }
}
