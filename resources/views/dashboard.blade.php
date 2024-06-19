<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">

                @guest
                    <p class="my-6 text-center text-gray-300">Please <a href="{{ route('login') }}"
                            class="text-blue-500">login</a> or
                        <a href="{{ route('register') }}" class="text-blue-500">register</a>
                        to get started.
                @endguest

                @auth
                <div class="container p-4 mx-auto">
                    <h1 class="mb-4 text-2xl font-bold">Welcome, {{ auth()->user()->name }}!</h1>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                        <!-- User Information -->
                        <div class="p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                            <h2 class="mb-2 text-xl font-semibold">Your Information</h2>
                            <p>Email: {{ auth()->user()->email }}</p>
                            <p>User Type: {{ auth()->user()->usertype }}</p>
                            <p>Created At: {{ auth()->user()->created_at }}</p>
                        </div>

                        <!-- Recent Activity -->
                        <div class="p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                            <h2 class="mb-2 text-xl font-semibold">Recent Activity</h2>
                            <!-- Example of recent posts, you can replace with actual data -->
                            @foreach(auth()->user()->posts->take(5) as $post)
                                <p><a href="{{ route('posts.show', $post) }}" class="text-blue-500">{{ $post->title }}</a> - {{ $post->created_at->diffForHumans() }}</p>
                            @endforeach
                        </div>

                        <!-- Quick Links -->
                        <div class="p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                            <h2 class="mb-2 text-xl font-semibold">Quick Links</h2>
                            <ul>
                                <li><a href="{{ route('posts.create') }}" class="text-blue-500">Create New Post</a></li>
                                <li><a href="{{ route('posts.index') }}" class="text-blue-500">Browse Posts</a></li>
                                <li><a href="{{ route('profile.edit') }}" class="text-blue-500">View Profile</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endauth

            </div>
        </div>
    </div>
</x-app-layout>
