<x-app-layout>
    <div class="px-2 py-6 mx-auto max-w-5xl">
        <div>
            <h1 class="text-3xl font-semibold text-gray-300">{{ $post->title }}</h1>
            <span class="text-sm text-gray-500">
                {{ $post->created_at->diffForHumans() }} by {{ $post->user->name }}
            </span>
        </div>

        <div class="mt-6 text-gray-400 prose">
            {!! $post->html !!}
        </div>

        <div class="mt-12">
            <h2 id="comments" class="text-2xl font-semibold text-gray-400">Comments</h2>

            @auth
                <form action="{{ route('posts.comments.store', $post) }}" method="post" class="mt-3">
                    @csrf
                    <textarea name="body" id="body" cols="30" rows="5" class="w-full"></textarea>
                    <x-primary-button type="submit" class="mt-1">Add Comment</x-primary-button>
                </form>
            @endauth

            <ul class="mt-4 divide-y">
                @foreach ($comments as $comment)
                    <li class="px-2 py-4">
                        <p class="text-gray-400">{{ $comment->body }}</p>
                        <span class="text-sm text-gray-500">
                            {{ $comment->created_at->diffForHumans() }} by {{ $comment->user->name }}
                        </span>

                        @can('delete', $comment)
                        <form action="{{ route('posts.comments.destroy', ['post' => $post, 'comment' => $comment]) }}" method="post">
                            @csrf
                            @method('DELETE')

                            <x-danger-button type="submit">Delete</x-danger-button>
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
