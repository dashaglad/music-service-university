import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {LoginComponent} from "./components/login/login.component";
import {RegistrationComponent} from "./components/registration/registration.component";
import {AlbumComponent} from "./components/album/album.component";
import {HomeComponent} from "./components/home/home.component";
import {AlbumsAllComponent} from "./components/album/pages/albums-all/albums-all.component";
import {AlbumsOwnComponent} from "./components/album/pages/albums-own/albums-own.component";
import {AlbumCreateComponent} from "./components/album/pages/album-create/album-create.component";
import {AlbumEditComponent} from "./components/album/pages/album-edit/album-edit.component";
import {
  albumResolver,
  albumsListResolver, favoriteAlbumsListResolver,
  ownAlbumsListResolver
} from "./services/resolvers/album.resolver";
import {SongCreateComponent} from "./components/song/pages/song-create/song-create.component";
import {authGuard} from "./services/auth.guard";
import {favoriteSongsListResolver} from "./services/resolvers/song.resolver";
import {SongsFavoriteComponent} from "./components/song/pages/songs-favorite/songs-favorite.component";
import {MediaFavoriteComponent} from "./components/media-favorite/media-favorite.component";


const routes: Routes = [
  {
    path: '',
    component: HomeComponent,
    canActivate: [authGuard]
  },
  {path: 'login', component: LoginComponent},
  {path: 'register', component: RegistrationComponent},
  {
    path: 'albums',
    component: AlbumsAllComponent,
    canActivate: [authGuard],
    resolve: {albums: albumsListResolver}
  },
  {
    path: 'albums/own',
    component: AlbumsOwnComponent,
    canActivate: [authGuard],
    resolve: {albums: ownAlbumsListResolver}
  },
  {
    path: 'albums/create',
    component: AlbumCreateComponent,
    canActivate: [authGuard]
  },
  {
    path: 'albums/:albumId',
    component: AlbumComponent,
    canActivate: [authGuard],
    resolve: {album: albumResolver}
  },
  {
    path: 'albums/:albumId/edit',
    component: AlbumEditComponent,
    canActivate: [authGuard],
    resolve: {album: albumResolver}
  },
  {
    path: 'albums/:albumId/songs/create',
    component: SongCreateComponent,
    canActivate: [authGuard]
  },
  {
    path: 'songs/favorite',
    component: SongsFavoriteComponent,
    canActivate: [authGuard],
    resolve: {songs: favoriteSongsListResolver}
  },
  {
    path: 'media-favorite',
    component: MediaFavoriteComponent,
    canActivate: [authGuard],
    resolve: {albums: favoriteAlbumsListResolver}
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule {
}
