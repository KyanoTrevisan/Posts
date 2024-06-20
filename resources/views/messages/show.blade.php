<x-app-layout>
    <div class="container p-4 mx-auto">
        <h1 class="mb-4 text-2xl font-bold">View Message</h1>

        <div class="mb-4">
            <p><strong>From:</strong> {{ $message->sender->name }}</p>
            <p><strong>To:</strong> {{ $message->recipient->name }}</p>
            <p><strong>Message:</strong> {{ $decryptedMessage }}</p>
        </div>

        <a href="{{ route('messages.index') }}" class="px-4 py-2 text-white bg-blue-500 rounded-lg">Back to Messages</a>
    </div>
</x-app-layout>
