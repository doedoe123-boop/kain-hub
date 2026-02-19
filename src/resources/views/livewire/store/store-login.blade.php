<div>
    <h2 class="text-2xl font-bold text-center mb-2">Store Owner Login</h2>
    <p class="text-center text-sm text-gray-500 mb-6">Sign in to manage your store</p>

    <form wire:submit="authenticate" class="space-y-4">
        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input
                wire:model="email"
                id="email"
                type="email"
                required
                autofocus
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2 border"
            >
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input
                wire:model="password"
                id="password"
                type="password"
                required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-2 border"
            >
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember Me --}}
        <div class="flex items-center">
            <input
                wire:model="remember"
                id="remember"
                type="checkbox"
                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
            >
            <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
        </div>

        {{-- Submit --}}
        <button type="submit"
            class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50"
            wire:loading.attr="disabled">
            <span wire:loading.remove>Sign In</span>
            <span wire:loading>Signing in...</span>
        </button>
    </form>
</div>
