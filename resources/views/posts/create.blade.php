<x-app-layout>
        <div class="container p-4 mx-auto">
        <h1 class="mb-4 text-2xl font-bold">Create New Post</h1>

        <form action="{{ route('posts.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="title" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Title</label>
                <input type="text" name="title" id="title" class="block px-3 py-2 mt-1 w-full text-black rounded-md border border-gray-300 shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                @error('title')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="body" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Body</label>
                <textarea name="body" id="body" rows="10" class="block px-3 mt-1 w-full h-80 text-black rounded-md border border-gray-300 shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required></textarea>
                @error('body')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <x-primary-button type="submit" class="px-4 py-2 rounded-lg">Create Post</x-primary-button>
            </div>
        </form>

        <p>remember, you can use <a href="/posts/1">markdown</a>!</p>
    </div>
</x-app-layout>
