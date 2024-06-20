<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    // Display all messages for the authenticated user
    public function index()
    {
        $messages = Message::where('sender_id', Auth::id())
                            ->orWhere('recipient_id', Auth::id())
                            ->get();

        return view('messages.index', compact('messages'));
    }

    // Show form for creating a new message
    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('messages.create', compact('users'));
    }

    // Store a new message
    public function store(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $recipient = User::findOrFail($request->recipient_id);
        $sender = Auth::user();

        if (!$recipient->keys || !$sender->keys) {
            Log::error('Either sender or recipient does not have encryption keys.');
            return redirect()->back()->with('error', 'Either sender or recipient does not have encryption keys.');
        }

        try {
            $recipientPublicKey = sodium_hex2bin($recipient->keys->public_key);
            $senderPrivateKey = sodium_hex2bin($sender->keys->private_key);

            $nonce = random_bytes(SODIUM_CRYPTO_BOX_NONCEBYTES);
            $ciphertext = sodium_crypto_box(
                $request->message,
                $nonce,
                sodium_crypto_box_keypair_from_secretkey_and_publickey(
                    $senderPrivateKey,
                    $recipientPublicKey
                )
            );

            $encryptedMessage = sodium_bin2hex($nonce . $ciphertext);

            Log::info('Sender Private Key: ' . $sender->keys->private_key);
            Log::info('Recipient Public Key: ' . $recipient->keys->public_key);
            Log::info('Encrypted Message: ' . $encryptedMessage);

            Message::create([
                'sender_id' => $sender->id,
                'recipient_id' => $request->recipient_id,
                'message' => $encryptedMessage,
            ]);

            return redirect()->route('messages.index')->with('success', 'Message sent successfully.');
        } catch (\Exception $e) {
            Log::error('Encryption error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to encrypt and send the message.');
        }
    }

    // Display a specific message
    public function show(Message $message)
    {
        $user = Auth::user();

        if (!$user->keys) {
            Log::error('User does not have encryption keys.');
            return redirect()->route('messages.index')->with('error', 'You do not have encryption keys.');
        }

        try {
            $userPrivateKey = sodium_hex2bin($user->keys->private_key);
            $messageContent = sodium_hex2bin($message->message);
            $nonce = substr($messageContent, 0, SODIUM_CRYPTO_BOX_NONCEBYTES);
            $ciphertext = substr($messageContent, SODIUM_CRYPTO_BOX_NONCEBYTES);

            Log::info('User Private Key: ' . $user->keys->private_key);
            Log::info('Message Content: ' . $message->message);
            Log::info('Nonce: ' . sodium_bin2hex($nonce));
            Log::info('Ciphertext: ' . sodium_bin2hex($ciphertext));

            $senderPublicKey = $user->id === $message->recipient_id ?
                               sodium_hex2bin($message->sender->keys->public_key) :
                               sodium_hex2bin($message->recipient->keys->public_key);

            Log::info('Sender Public Key: ' . sodium_bin2hex($senderPublicKey));

            $decryptedMessage = sodium_crypto_box_open(
                $ciphertext,
                $nonce,
                sodium_crypto_box_keypair_from_secretkey_and_publickey(
                    $userPrivateKey,
                    $senderPublicKey
                )
            );

            if ($decryptedMessage === false) {
                throw new \Exception('Decryption failed.');
            }

            Log::info('Decrypted Message: ' . $decryptedMessage);

            return view('messages.show', compact('message', 'decryptedMessage'));

        } catch (\Exception $e) {
            Log::error('Failed to decrypt message: ' . $e->getMessage());
            return redirect()->route('messages.index')->with('error', 'Unable to decrypt message.');
        }
    }
}
