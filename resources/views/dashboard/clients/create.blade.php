<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create OAuth Client') }}
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
                <form method="POST" action="{{ route('dashboard.clients.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700">Client Name</label>
                        <input type="text" name="name" required class="w-full px-3 py-2 border rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Redirect URI</label>
                        <input type="url" name="redirect_uri" required class="w-full px-3 py-2 border rounded">
                    </div>

                    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded">Create Client</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
