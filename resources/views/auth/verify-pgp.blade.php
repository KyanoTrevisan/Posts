<x-guest-layout class="w-100">
    <form method="POST" action="{{ route('verify-pgp') }}">
        @csrf

        <div>
            <x-input-label for="encrypted_message">{{ __('Encrypted Message') }}</x-input-label>
            <textarea id="encrypted_message"
                class="block px-3 mt-1 w-full h-80 rounded-md border-gray-300 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                rows="5" readonly>{{ $encryptedMessage }}</textarea>
        </div>

        <div class="my-3">
            <x-input-label for="decrypted_message">{{ __('Decrypted Message') }}</x-input-label>
            <input id="decrypted_message" type="text"
                class="block px-3 py-2 mt-1 w-full rounded-md border-gray-300 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 @error('decrypted_message') is-invalid @enderror"
                name="decrypted_message" required autofocus>

            @error('decrypted_message')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div>
            <x-primary-button type="submit" class="btn btn-primary">
                {{ __('Verify') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
