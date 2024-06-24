<x-app-layout>
    <div class="px-2 py-6 mx-auto max-w-5xl">
        <div>
            <h1 class="text-3xl font-semibold">{{ $post->title }}</h1>
            <p class="text-sm">
                {{ $post->created_at->diffForHumans() }} by <a href="{{ route('users.show', $post->user) }}">{{ $post->user->name }}</a>
            </p>
        </div>

        <div class="mt-6 prose">
            {!! $post->html !!}
        </div>

        <div class="mt-12">
            <h2 id="comments" class="text-2xl font-semibold">Comments</h2>

            @auth
                <form action="{{ route('posts.comments.store', $post) }}" method="post" class="mt-3">
                    @csrf
                    <textarea name="body" id="body" cols="30" rows="5" class="block px-3 mb-3 w-full rounded-md border-gray-300 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"></textarea>
                    <x-secondary-button type="submit" class="mt-1">Add Comment</x-secondary-button>
                </form>
            @endauth

            @guest
            <p class="my-6 text-center text-gray-300">Please <a href="{{ route('login') }}" class="text-blue-500">login</a> or
                <a href="{{ route('register') }}" class="text-blue-500">register</a>
                to post a comment!
            </p>
            @endguest

            <ul class="mt-4 divide-y">
                @foreach ($comments as $comment)
                    <li class="px-2 py-4">
                        <p>{{ $comment->body }}</p>
                        <p class="text-sm">
                            {{ $comment->created_at->diffForHumans() }} by <a href="{{ route('users.show', $comment->user) }}">{{ $comment->user->name }}</a>
                        </p>

                        @can('delete', $comment)
                        <form action="{{ route('posts.comments.destroy', ['post' => $post, 'comment' => $comment]) }}" method="post" class="py-2">
                            @csrf
                            @method('DELETE')

                            <x-danger-button type="submit">Remove</x-danger-button>
                        </form>
                        @endcan
                    </li>
                @endforeach
            </ul>

            <div class="mt-2">
                {{ $comments->fragment('$comments')->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
