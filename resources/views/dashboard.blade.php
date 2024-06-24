<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="container p-4 mx-auto">
                @guest
                    <p class="my-6 text-center text-gray-300">Please <a href="{{ route('login') }}"
                            class="text-blue-500">login</a> or
                        <a href="{{ route('register') }}" class="text-blue-500">register</a>
                        to get started.
                    </p>
                @endguest

                @auth
                    <h1 class="mb-4 text-2xl font-bold">Welcome, {{ auth()->user()->name }}!</h1>

                    <div class="container p-4 mx-auto">
                        <!-- User Bio -->
                        <div class="p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                            <h2 class="mb-2 text-xl font-semibold">Bio</h2>
                            <p>{{ auth()->user()->bio }}</p>
                        </div>
                    </div>

                    <div class="container p-4 mx-auto">
                        <!-- User Info -->
                        <div class="p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                            <h2 class="mb-2 text-xl font-semibold">User Info</h2>
                            <p>Email: {{ auth()->user()->email }}</p>
                            <p>User Type: {{ auth()->user()->usertype }}</p>
                            <p>Created At: {{ auth()->user()->created_at }}</p>
                            @if (auth()->user()->pgp_verified_at != null)
                                <p>PGP Verified: Yes, since {{ auth()->user()->pgp_verified_at }}</p>
                            @else
                                <p>PGP Verified: No</p>
                            @endif
                        </div>
                    </div>

                    <div class="container p-4 mx-auto">
                        <!-- Recent Activity -->
                        <div class="p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                            <h2 class="mb-2 text-xl font-semibold">Recent Activity</h2>
                            <h3 class="mt-3 font-semibold">Posts</h3>
                            @foreach (auth()->user()->posts->take(5) as $post)
                                <p>
                                    <a href="{{ route('posts.show', $post) }}" class="text-blue-500">{{ $post->title }}</a>
                                    - {{ $post->created_at->diffForHumans() }}
                                </p>
                            @endforeach
                            <h3 class="mt-3 font-semibold">Comments</h3>
                            @foreach (auth()->user()->comments->take(5) as $comment)
                                <p>
                                    <a href="{{ route('posts.show', $comment) }}"
                                        class="text-blue-500">{{ $comment->body }}</a>
                                    - {{ $comment->created_at->diffForHumans() }}
                                </p>
                            @endforeach
                        </div>
                    </div>
                @endauth
            </div>
        </div>
</x-app-layout>
