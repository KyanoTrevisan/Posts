<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Conversation') }}
        </h2>
    </x-slot>
    <div class="container p-4 mx-auto">

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <meta http-equiv="refresh" content="30"> <!-- This will reload the page every 30 seconds -->

        <div >
            <ul>
                @foreach($messages as $msg)
                    <li class="mb-2">
                        <strong>{{ $msg->sender->name }}:</strong> {{ $msg->decrypted_message }}
                    </li>
                @endforeach
            </ul>
        </div>

        <form action="{{ route('messages.store') }}" method="POST">
            @csrf
            <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">

            <div class="mb-4">
                <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
                <textarea name="message" id="message" rows="4" class="block px-3 mt-1 w-full rounded-md border-gray-300 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" required></textarea>
                @error('message')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <x-primary-button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-lg">Send Message</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
