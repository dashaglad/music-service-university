import {Component} from '@angular/core';
import {AlbumCard} from "../../models/album";
import {AlbumService} from "../../services/album.service";
import {ActivatedRoute} from "@angular/router";

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent {
  public albumsCount: Number = 5;

  public popularAlbums: AlbumCard[] = [];
  public latestAlbums: AlbumCard[] = [];

  constructor(private albumService: AlbumService, private route: ActivatedRoute) {
    // this.albums = this.route.snapshot.data['albums'];

    albumService.getPopularAlbums(this.albumsCount).subscribe(
      albums => this.popularAlbums = albums
    )

    albumService.getLatestAlbums(this.albumsCount).subscribe(
      albums => this.latestAlbums = albums
    )
  }
}
