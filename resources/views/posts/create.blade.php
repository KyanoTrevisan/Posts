<x-app-layout>
        <div class="container p-4 mx-auto">
        <h1 class="mb-4 text-2xl font-bold">Create New Post</h1>

        <form action="{{ route('posts.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="title" class="block px-3 py-2 mt-1 w-full rounded-md border-gray-300 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">Title</label>
                <input type="text" name="title" id="title" class="block px-3 py-2 mt-1 w-full rounded-md border-gray-300 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" required>
                @error('title')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="body" class="block text-lg font-medium text-gray-700 dark:text-gray-300">Body</label>
                <textarea name="body" id="body" rows="10" class="block px-3 mt-1 w-full h-80 rounded-md border-gray-300 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" required></textarea>
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
