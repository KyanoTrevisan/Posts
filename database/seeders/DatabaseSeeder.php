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
            'password' => bcrypt('&K$#c5uf2@!$!474C82*639J^'),
            'email_verified_at' => null,
            'usertype' => 'admin',
            'bio' => "Hi everyone, I'm sooox, the founder of this platform. I've always been passionate about free speech and the power of open communication. That's why I built this platform – to create a space where people can truly connect and share ideas freely. My background is in software development and artificial intelligence, and I've used those skills to make this platform secure and privacy-friendly. While you do need an email address to sign up, I know anonymity is important for some users. That's why we never actually use that information – feel free to use a temporary email service if you'd prefer but make sure you remember it because you do need it to log in. More importantly, all your conversations are end-to-end encrypted. This means only you and the person you're talking to can read your messages - not even I have access to the decryption keys. Your privacy is my top concern. In short, I built this platform with the core values of freedom and security in mind. It's a space designed for open and honest dialogue, but one where you're always in control of your privacy.",
            'pgp_public_key' => '-----BEGIN PGP PUBLIC KEY BLOCK-----
mDMEZlTUhhYJKwYBBAHaRw8BAQdAtx1GCLeVY4JK1iUjM6WBo1EEMeCvdIsNe+x+
Y0M5/220BXhvb29ziJMEExYKADsWIQSWo//3G3YqytjW6GFcIGswgPu2/wUCZlTU
hgIbIwULCQgHAgIiAgYVCgkICwIEFgIDAQIeBwIXgAAKCRBcIGswgPu2/15TAP9K
ckarR9l/1KIrjEbd0ZtR3SZcI2JN26OzkouPFYAuHQEAxEFE4m5GRBqRS3ZEXndD
qZPfOF8BWtrcNToinc612Aa4OARmVNSGEgorBgEEAZdVAQUBAQdAHBRY6AOzyQwm
NqIRH0sRW+LSQMnxs1e1/6StppwgeVoDAQgHiHgEGBYKACAWIQSWo//3G3YqytjW
6GFcIGswgPu2/wUCZlTUhgIbDAAKCRBcIGswgPu2/7JqAQAA8hvNbgpvHnhzskkP
XpnidXGTJhU2e9MZpiguvxLuTAEAgSaR9bIZEEMV5YysvNK5WSTpQVcGym19zKg/
tpkrewc=
=cOSH
-----END PGP PUBLIC KEY BLOCK-----',
            'pgp_verified_at' => now(),
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

        // Get all files in the 'assets/articles/' directory
        $files = File::files(public_path('assets/articles/'));

        foreach ($files as $file) {
            // Get the file name without the extension
            $title = pathinfo($file->getFilename(), PATHINFO_FILENAME);

            // Create a post for each file
            Post::create([
                'user_id' => $sooox->id,
                'title' => ucfirst(str_replace('_', ' ', $title)), // Format title
                'body' => File::get($file->getPathname())
            ]);
        }
    }
}
