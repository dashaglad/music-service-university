import { Component } from '@angular/core';
import {AlbumCard} from "../../../../models/album";
import {AlbumService} from "../../../../services/album.service";
import {ActivatedRoute} from "@angular/router";

@Component({
  selector: 'app-albums-all',
  templateUrl: './albums-all.component.html',
  styleUrls: ['./albums-all.component.scss']
})
export class AlbumsAllComponent {
  public albums: AlbumCard[] = [];

  constructor(private albumService: AlbumService, private route: ActivatedRoute) {
    this.albums = this.route.snapshot.data['albums'];
  }
}
