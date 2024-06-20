<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            Conversation with
                                {{ $conversation->user1_id === Auth::id() ? $conversation->user2->name : $conversation->user1->name }}
        </h2>
    </x-slot>

    <div class="container p-4 mx-auto mt-10">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <meta http-equiv="refresh" content="30"> <!-- This will reload the page every 30 seconds -->

        <div class="overflow-y-scroll p-4 mb-4 h-96 rounded border border-gray-300" style="scroll-margin-bottom: 100px;">
            <ul>
                @foreach ($messages as $msg)
                    <li class="mb-2">
                        <strong>{{ $msg->sender->name }}:</strong>
                        <div>{!! $msg->formatted_message !!}</div>
                    </li>
                @endforeach
            </ul>
        </div>

        <form action="{{ route('messages.store') }}" method="POST">
            @csrf
            <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">

            <div class="mb-4">
                <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
                <textarea name="message" id="message" rows="4"
                    class="block px-3 mt-1 w-full rounded-md border-gray-300 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                    required></textarea>
                @error('message')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
                <small>
                    ps: you can add images using
                    ![Sample Image](https://via.placeholder.com/150 "Optional title")
                </small>
            </div>

            <div class="mb-4">
                <x-primary-button type="submit">Send Message</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
