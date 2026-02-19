<div>
    <h2 class="text-2xl font-bold text-center mb-6">Sign in to your account</h2>

    @if (session('status'))
        <div class="mb-4 text-sm text-green-600 bg-green-50 p-3 rounded">
            {{ session('status') }}
        </div>
    @endif

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
            <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
        </div>

        {{-- Submit --}}
        <div>
            <button
                type="submit"
                class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition"
            >
                <span wire:loading.remove wire:target="authenticate">Sign in</span>
                <span wire:loading wire:target="authenticate">Signing in...</span>
            </button>
        </div>
    </form>

    <p class="mt-6 text-center text-sm text-gray-600">
        Don't have an account?
        <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-500 font-medium">Register</a>
    </p>
</div>
