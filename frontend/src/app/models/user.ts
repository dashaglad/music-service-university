import {Artist} from "./artist";

export interface User{
  id: number;
  email: string;
  artist: Artist | null;
}
