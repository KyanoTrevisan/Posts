<x-app-layout>
    <div class="px-2 py-6 mx-auto max-w-5xl">
        <ul class="divide-y">
            @foreach ($posts as $post)
            <li class="px-2 py-4">
                <a href="{{ route('posts.show', $post) }}" class="block text-xl font-semibold text-gray-300">{{ $post->title }}</a>
                <span class="text-sm text-gray-500">
                    {{ $post->created_at->diffForHumans() }} by {{ $post->user->name }}
                </span>
            </li>
            @endforeach
        </ul>

        <div>
            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>
