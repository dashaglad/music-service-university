import {Component, Input} from '@angular/core';
import {AlbumCard} from "../../../models/album";

@Component({
  selector: 'app-albums',
  templateUrl: './albums.component.html',
  styleUrls: ['./albums.component.scss']
})
export class AlbumsComponent {
    @Input() albums: AlbumCard[] = [];
}
