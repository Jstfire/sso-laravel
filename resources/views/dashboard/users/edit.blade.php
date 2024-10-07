<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-4 text-red-600">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white p-6 rounded shadow-md">
                <form method="POST" action="{{ route('dashboard.users.update', $user->id) }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700">Name</label>
                        <input type="text" value="{{ $user->name }}" disabled
                            class="w-full px-3 py-2 border rounded bg-gray-100">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Email</label>
                        <input type="email" value="{{ $user->email }}" disabled
                            class="w-full px-3 py-2 border rounded bg-gray-100">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Role</label>
                        <select name="role" class="w-full px-3 py-2 border rounded">
                            <option value="user" {{ $user->authorization->role == 'user' ? 'selected' : '' }}>User
                            </option>
                            <option value="developer" {{ $user->authorization->role == 'developer' ? 'selected' : '' }}>
                                Developer</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded">Update</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>