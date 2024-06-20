<x-app-layout>
    <div class="container p-4 mx-auto">
        <h1 class="mb-4 text-2xl font-bold">Start New Conversation</h1>

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

        <form action="{{ route('messages.storeConversation') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="recipient_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Recipient</label>
                <select name="recipient_id" id="recipient_id" class="block px-3 py-2 mt-1 w-full rounded-md border-gray-300 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('recipient_id')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <x-secondary-button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-lg">Start Conversation</x-secondary-button>
            </div>
        </form>
    </div>
</x-app-layout>
