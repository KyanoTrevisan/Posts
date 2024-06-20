<x-app-layout>
    <div class="container p-4 mx-auto">
        <h1 class="mb-4 text-2xl font-bold">Messages</h1>
        <p>
            These messages are E2E encrypted, meaning only the sender and receiver can read your messages!
            Here is what your message looks like in our database:
            <code>9f882840058d643b4abdef7c3eb1185213ffda1a664d0d4ae71b999157701f98e73420767ac1085a4c7f2aa6ebb14d0566</code>
        </p>

        <p class="py-5">
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

        <a href="{{ route('messages.create') }}"
            class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 uppercase bg-white rounded-md border border-gray-300 shadow-sm transition duration-150 ease-in-out dark:bg-gray-800 dark:border-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25">Send
            New Message</a>

        <div class="mb-4">
            <ul>
                @foreach ($messages as $msg)
                    <li>
                        <p class="py-5">
                            <a href="{{ route('messages.show', $msg->id) }}">
                                From: {{ $msg->sender->name }} - To: {{ $msg->recipient->name }}
                            </a>
                        </p>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>
