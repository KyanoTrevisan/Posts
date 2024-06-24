<x-app-layout>
    <x-slot name="header">
        <form action="{{ route('messages.storeConversation') }}" method="POST">
            @csrf
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __($user->name . "'s profile") }}
            <input
                class="block px-3 py-2 mt-1 w-full rounded-md border-gray-300 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                type="hidden" name="recipient_id" value="{{ $user->id }}">
            <x-primary-button type="sumbit" class="float-right">Start Conversation</x-primary-button>
        </form>
    </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="container p-4 mx-auto">
                <!-- User Bio -->
                <div class="p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                    <h2 class="mb-2 text-xl font-semibold">Bio</h2>
                    <p>{{ $user->bio }}</p>
                </div>
            </div>

            <div class="container p-4 mx-auto">
                <!-- User Posts -->
                <div class="p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                    <h2 class="mb-2 text-xl font-semibold">Posts</h2>
                    @foreach ($posts as $post)
                        <div>
                            <p>
                                <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                                - {{ $post->created_at->format('M d, Y') }}
                            </p>
                        </div>
                    @endforeach
                    {{ $posts->links() }}
                </div>
            </div>

            <div class="container p-4 mx-auto">
                <!-- User Comments -->
                <div class="p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                    <h2 class="mb-2 text-xl font-semibold">Comments</h2>
                    @foreach ($comments as $comment)
                        <div>
                            <p>
                                {{ $comment->body }} - {{ $comment->created_at->format('M d, Y') }} -
                                <a href="{{ route('posts.show', $comment->post) }}">View Post</a>
                            </p>
                        </div>
                    @endforeach
                    {{ $comments->links() }}
                </div>
            </div>

            <div class="container p-4 mx-auto">
                <div>
                    <!-- PGP Public Key -->
                    <div class="p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                        <h2 class="mb-2 text-xl font-semibold">PGP Public Key</h2>
                        @if ($user->pgp_public_key)
                            <small>Verified {{ $user->pgp_verified_at }}</small>
                            <p class="py-3">
                                <pre>
{{ $user->pgp_public_key }}
                                </pre>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
