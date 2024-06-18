<x-guest-layout>
    <div class="container p-6">
        <h1 class="text-3xl font-semibold text-center text-gray-400">Welcome</h1>

        @guest
            <p class="my-6 text-center text-gray-300">Please <a href="{{ route('login') }}" class="text-blue-500">login</a> or
                <a href="{{ route('register') }}" class="text-blue-500">register</a>
                to get started.
            </p>
        @else
            <p class="my-6 text-center text-gray-300">You are logged in! Go to the <a href="{{ route('dashboard') }}"
                    class="text-blue-500">dashboard</a>.</p>
        @endguest

        {{-- <div class="mt-8 text-center text-gray-300">
            <p>Some more information about the application can go here. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div> --}}
    </div>

</x-guest-layout>
