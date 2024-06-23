<?php

namespace App\Helpers;

class PgpHelper
{
    public static function encryptMessage($pubkey, $message)
    {
        $command = escapeshellcmd("python3 " . storage_path('app/scripts/encrypt_message.py') . " " . escapeshellarg($pubkey) . " " . escapeshellarg($message));
        $output = shell_exec($command);
        return trim($output);
    }
}
