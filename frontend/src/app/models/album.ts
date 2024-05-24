import {Artist} from "./artist";
import {Song} from "./song";

export interface Album{
  id: number;
  title: string;
  owner: Artist;

  liked: boolean;
}

export interface AlbumCard extends Album{
  likes: number;
  description: string;
  date: Date;
}

export interface AlbumFull extends AlbumCard{
  songs: Song[];
  users: number[];
}
