<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

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
                @if (auth()->user()->posts)
                    @foreach (auth()->user()->posts()->take(5)->get() as $post)
                        <p><a href="{{ route('posts.show', $post) }}" class="text-blue-500">{{ $post->title }}</a> -
                            {{ $post->created_at->diffForHumans() }}</p>
                    @endforeach
                @else
                    <p>No recent activity.</p>
                @endif
            </div>

            <!-- System Overview -->
            <div class="p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                <h2 class="mb-2 text-xl font-semibold">System Overview</h2>
                <p>Users: {{ \App\Models\User::count() }}</p>
                <p>Posts: {{ \App\Models\Post::count() }}</p>
                <p>Comments: {{ \App\Models\Comment::count() }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
