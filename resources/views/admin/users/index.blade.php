<x-app-layout>
    <div class="container p-4 mx-auto">
        <h1 class="mb-4 text-2xl font-bold">Manage Users</h1>

        <a href="{{ route('admin.users.create') }}"
            class="inline-flex float-right items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 uppercase bg-white rounded-md border border-gray-300 shadow-sm transition duration-150 ease-in-out dark:bg-gray-800 dark:border-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25">Create
            User</a>

        <div class="mt-5">
            <form action="{{ route('admin.users.index') }}" method="GET">
                <input type="text" name="query" placeholder="Search users" value="{{ request('query') }}"
                    class="rounded-md border-gray-300 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
            </form>
        </div>


        <table class="mt-5 min-w-full bg-white dark:bg-gray-800">
            <thead>
                <tr>
                    <th class="px-4 py-2 border-b">Name</th>
                    <th class="px-4 py-2 border-b">Email</th>
                    <th class="px-4 py-2 border-b">User Type</th>
                    <th class="px-4 py-2 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="px-4 py-2 border-b">
                            <p class="text-sm">
                                <a href="{{ route('users.show', $user) }}">{{ $user->name}}</a>
                            </p>
                        </td>
                        <td class="px-4 py-2 border-b">{{ $user->email }}</td>
                        <td class="px-4 py-2 border-b">{{ $user->usertype }}</td>
                        <td class="px-4 py-2 border-b">
                            <a href="{{ route('admin.users.edit', $user) }}"
                                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-gray-800 rounded-md border border-transparent transition duration-150 ease-in-out dark:bg-gray-200 dark:text-gray-800 hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">Edit</a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                class="inline-block">
                                @csrf
                                @method('DELETE')
                                <x-danger-button type="submit" onclick="return confirm('Are you sure?');"
                                    class="ml-2">Delete</x-danger-button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>
