<x-app-layout>
    <div class="container p-4 mx-auto">
        <h1 class="mb-4 text-2xl font-bold">Conversations</h1>
        <div class="mb-4">
            <p>
                Welcome to the conversation area! Here, you can send and receive messages that are fully end-to-end encrypted (E2E). This means that only you and the person you're messaging can read the contents of your messages. Not even the administrators of this service can decrypt and read your messages.
                Although the contents of your messages are secure, we can still see who you are messaging and how many messages are being sent. This metadata helps us ensure the smooth operation of the messaging service.

                For example, here is what a message looks like in our database: <code>9f882840058d643b4abdef7c3eb1185213ffda1a664d0d4ae71b999157701f98e73420767ac1085a4c7f2aa6ebb14d0566</code>
            </p>
            <p>Of course, it never hurts to be extra cautious and encrypt all messages locally with PGP - dont trust anyone!</p>
        </div>

        <p class="py-2">
            <!-- Flash messages -->
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </p>

        <div class="mb-2">
            <a href="{{ route('messages.createConversation') }}"
                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 uppercase bg-white rounded-md border border-gray-300 shadow-sm transition duration-150 ease-in-out dark:bg-gray-800 dark:border-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25">Start
                New Conversation</a>
        </div>

        <div class="mb-4">
            <ul>
                @foreach ($conversations as $conversation)
                    <li>
                        <p class="py-2">
                            <a href="{{ route('messages.showConversation', $conversation->id) }}">
                                Conversation with
                                {{ $conversation->user1_id === Auth::id() ? $conversation->user2->name : $conversation->user1->name }}
                            </a>
                        </p>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>
