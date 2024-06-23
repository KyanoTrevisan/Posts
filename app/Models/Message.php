<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Michelf\Markdown;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id', 'recipient_id', 'message', 'conversation_id',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    // Accessor to decrypt the message
    public function getDecryptedMessageAttribute()
    {
        try {
            $userPrivateKey = sodium_hex2bin(auth()->user()->keys->private_key);
            $messageContent = sodium_hex2bin($this->message);
            $nonce = substr($messageContent, 0, SODIUM_CRYPTO_BOX_NONCEBYTES);
            $ciphertext = substr($messageContent, SODIUM_CRYPTO_BOX_NONCEBYTES);

            $otherUserPublicKey = $this->sender_id === auth()->id() ? $this->recipient->keys->public_key : $this->sender->keys->public_key;
            $otherUserPublicKey = sodium_hex2bin($otherUserPublicKey);

            $decryptedMessage = sodium_crypto_box_open(
                $ciphertext,
                $nonce,
                sodium_crypto_box_keypair_from_secretkey_and_publickey(
                    $userPrivateKey,
                    $otherUserPublicKey
                )
            );

            if ($decryptedMessage === false) {
                throw new \Exception('Decryption failed.');
            }

            return $decryptedMessage;
        } catch (\Exception $e) {
            return 'Unable to decrypt message.';
        }
    }

    // Attribute to format the message with Markdown
    public function formattedMessage(): Attribute
    {
        return Attribute::get(fn () => str($this->decrypted_message)->markdown());
    }
}
