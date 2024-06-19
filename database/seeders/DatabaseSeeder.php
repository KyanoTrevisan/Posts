<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'sooox',
            'email' => 'sooox@cocaine.ninja',
            'password' => bcrypt('&K$#c5uf2@!$!474C82*639J^')
        ]);

        $markdownContent = File::get(public_path('assets/markdown-guide.md'));

        Post::create([
            'user_id' => $user->id,
            'title' => 'Markdown Guide',
            'body' => $markdownContent,
        ]);
    }
}
