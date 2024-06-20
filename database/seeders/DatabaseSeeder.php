<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Models\UserKey;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Create the admin user (assuming $sooox is the admin user)
        $sooox = User::factory()->create([
            'name' => 'sooox',
            'email' => 'sooox@cocaine.ninja',
            'password' => bcrypt('&K$#c5uf2@!$!474C82*639J^'), // or Hash::make('password')
            'usertype' => 'admin'
        ]);

        // Generate and store encryption keys for the admin user
        $adminKeyPair = sodium_crypto_box_keypair();
        $adminPublicKey = sodium_crypto_box_publickey($adminKeyPair);
        $adminPrivateKey = sodium_crypto_box_secretkey($adminKeyPair);

        UserKey::create([
            'user_id' => $sooox->id,
            'public_key' => sodium_bin2hex($adminPublicKey),
            'private_key' => sodium_bin2hex($adminPrivateKey),
        ]);

        // Create posts for the admin user
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

        // Create additional users and their encryption keys
        $users = User::factory(10)->create();

        foreach ($users as $user) {
            $keyPair = sodium_crypto_box_keypair();
            $publicKey = sodium_crypto_box_publickey($keyPair);
            $privateKey = sodium_crypto_box_secretkey($keyPair);

            UserKey::create([
                'user_id' => $user->id,
                'public_key' => sodium_bin2hex($publicKey),
                'private_key' => sodium_bin2hex($privateKey),
            ]);
        }
        // Post::factory(10)->has(Comment::factory(3))->create();
    }
}
