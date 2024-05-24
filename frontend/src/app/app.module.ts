import {NgModule} from '@angular/core';
import {BrowserModule} from '@angular/platform-browser';
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {HttpClientModule} from "@angular/common/http";

import {AppRoutingModule} from './app-routing.module';
import {AppComponent} from './app.component';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';

import {LoginComponent} from './components/login/login.component';
import {AlbumComponent} from './components/album/album.component';
import {HeaderComponent} from './components/header/header.component';
import {NavigationComponent} from './components/navigation/navigation.component';
import {FooterComponent} from './components/footer/footer.component';
import {AlbumsComponent} from './components/album/albums/albums.component';
import {RegistrationComponent} from './components/registration/registration.component';
import {HomeComponent} from './components/home/home.component';
import {AlbumsAllComponent} from './components/album/pages/albums-all/albums-all.component';
import {AlbumsOwnComponent} from './components/album/pages/albums-own/albums-own.component';
import {AlbumCreateComponent} from './components/album/pages/album-create/album-create.component';
import {AlbumEditComponent} from './components/album/pages/album-edit/album-edit.component';
import {SongsComponent} from './components/song/songs/songs.component';
import {SongCreateComponent} from './components/song/pages/song-create/song-create.component';
import { SongsFavoriteComponent } from './components/song/pages/songs-favorite/songs-favorite.component';
import { MediaFavoriteComponent } from './components/media-favorite/media-favorite.component';

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    AlbumComponent,
    HeaderComponent,
    NavigationComponent,
    FooterComponent,
    AlbumsComponent,
    RegistrationComponent,
    HomeComponent,
    AlbumsAllComponent,
    AlbumsOwnComponent,
    AlbumCreateComponent,
    AlbumEditComponent,
    SongsComponent,
    SongCreateComponent,
    SongsFavoriteComponent,
    MediaFavoriteComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    FormsModule,
    ReactiveFormsModule,
    HttpClientModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule {
}
