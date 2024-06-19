<x-app-layout>
    <div class="px-2 py-6 mx-auto max-w-5xl">
        <ul class="divide-y">
            @auth
                @can('create', App\Models\Post::class)
                    <a href="{{ route('posts.create') }}"
                        class="inline-flex items-center px-4 py-2 mb-4 text-xs font-semibold tracking-widest text-white uppercase bg-gray-800 rounded-md border border-transparent transition duration-150 ease-in-out dark:bg-gray-200 dark:text-gray-800 hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">Create
                        Post</a>
                @endcan
            @endauth
            @foreach ($posts as $post)
                <li class="px-2 py-4">
                    <a href="{{ route('posts.show', $post) }}" class="block text-xl font-semibold">{{ $post->title }}</a>
                    <span class="text-sm">
                        {{ $post->created_at->diffForHumans() }} by {{ $post->user->name }}
                    </span>
                    <div class="flex mt-2">
                        @can('update', $post)
                            <form action="{{ route('posts.edit', $post) }}" method="#">
                                @csrf
                                <x-primary-button type="submit" class="mr-3">Edit</x-primary-button>
                            </form>
                        @endcan
                        @can('delete', $post)
                            <form action="{{ route('posts.destroy', $post) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this post?');">
                                @csrf
                                @method('DELETE')
                                <x-danger-button type="submit" class="mr-3">Delete</x-danger-button>
                            </form>
                        @endcan
                    </div>
                </li>
            @endforeach
        </ul>

        <div>
            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>
