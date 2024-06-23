<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    // Display all conversations for the authenticated user
    public function index()
    {
        $user = Auth::user();
        $conversations = Conversation::where('user1_id', $user->id)
            ->orWhere('user2_id', $user->id)
            ->get();

        return view('messages.index', compact('conversations'));
    }

    // Show conversation between the authenticated user and another user
    public function showConversation($id)
    {
        $user = Auth::user();
        $conversation = Conversation::findOrFail($id);

        if ($conversation->user1_id !== $user->id && $conversation->user2_id !== $user->id) {
            return redirect()->route('messages.index')->with('error', 'Unauthorized access to conversation.');
        }

        // Fetch messages in descending order
        $messages = $conversation->messages()->orderBy('created_at', 'desc')->get();

        return view('messages.conversation', compact('conversation', 'messages'));
    }

    // Show form to start a new conversation
    public function createConversation()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('messages.create', compact('users'));
    }

    // Handle form submission to start a new conversation
    public function storeConversation(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
        ]);

        $sender = Auth::user();
        $recipient = User::findOrFail($request->recipient_id);

        // Check if a conversation already exists
        $conversation = Conversation::where(function ($query) use ($sender, $recipient) {
            $query->where('user1_id', $sender->id)->where('user2_id', $recipient->id);
        })->orWhere(function ($query) use ($sender, $recipient) {
            $query->where('user1_id', $recipient->id)->where('user2_id', $sender->id);
        })->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'user1_id' => $sender->id,
                'user2_id' => $recipient->id,
            ]);
        }

        return redirect()->route('messages.showConversation', $conversation->id);
    }

    // Store a new message in a conversation
    public function store(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'message' => 'required|string',
        ]);

        $conversation = Conversation::findOrFail($request->conversation_id);
        $sender = Auth::user();
        $recipient = $conversation->user1_id === $sender->id ? $conversation->user2 : $conversation->user1;

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
                'recipient_id' => $recipient->id,
                'message' => $encryptedMessage,
                'conversation_id' => $conversation->id,
            ]);

            return redirect()->route('messages.showConversation', $conversation->id)->with('success', 'Message sent successfully.');
        } catch (\Exception $e) {
            Log::error('Encryption error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to encrypt and send the message.');
        }
    }
}
