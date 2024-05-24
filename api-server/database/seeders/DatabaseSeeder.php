<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Permissions\UserRole;
use App\Models\Song;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Artist::factory(5)->create();

        $userArtist = User::factory()->create(['role' => UserRole::Artist->value, 'artist_id' => Artist::all()->random()->id]);
        $userRegular = User::factory()->create(['role' => UserRole::RegularUser->value]);

        DB::table('genres')->insert([
            ['title' => 'rock'], ['title' => 'jazz']
        ]);
        Album::factory(10)->create();
        Song::factory(30)->create();
    }
}
