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

        $sooox = User::factory()->create([
            'name' => 'sooox',
            'email' => 'sooox@cocaine.ninja',
            'usertype' => 'admin',
            'password' => bcrypt('&K$#c5uf2@!$!474C82*639J^')
        ]);

        User::factory()->create([
            'name' => 'Editor',
            'email' => 'editor@example.com',
            'usertype' => 'editor',
            'password' => bcrypt('&K$#c5uf2@!$!474C82*639J^')
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => bcrypt('&K$#c5uf2@!$!474C82*639J^')
        ]);

        $markdownContent = File::get(public_path('assets/markdown-guide.md'));

        Post::create([
            'user_id' => $sooox->id,
            'title' => 'Markdown Guide',
            'body' => $markdownContent,
        ]);

        Post::create([
            'user_id' => $sooox->id,
            'title' => 'About the dark web...',
            'body' => File::get(public_path('assets/articles/darkweb.md'))
        ]);

        Post::factory(1000)->has(Comment::factory(150))->create();
    }
}
