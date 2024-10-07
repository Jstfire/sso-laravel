<form wire:submit.prevent="login">
    <input type="hidden" name="client_id" wire:model="client_id">
    <input type="hidden" name="redirect_uri" wire:model="redirect_uri">

    <div class="mb-4">
        <label class="block text-gray-700">Email</label>
        <input type="email" wire:model="email" required class="w-full px-3 py-2 border rounded">
        @error('email')
            <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-6">
        <label class="block text-gray-700">Password</label>
        <input type="password" wire:model="password" required class="w-full px-3 py-2 border rounded">
        @error('password')
            <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded">Login</button>
</form>
