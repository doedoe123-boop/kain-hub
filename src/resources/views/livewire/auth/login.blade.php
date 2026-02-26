<div>
    <h2 class="text-2xl font-bold text-center text-slate-800 dark:text-white mb-1">Sign in to your account</h2>
    <p class="text-center text-sm text-slate-500 dark:text-slate-400 mb-6">Access the NegosyoHub marketplace</p>

    @if (session('status'))
        <div class="mb-4 text-sm text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 p-3.5 rounded-xl border border-emerald-200 dark:border-emerald-700 animate-scale-in">
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit="authenticate" class="space-y-5">
        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Email</label>
            <input
                wire:model="email"
                id="email"
                type="email"
                required
                autofocus
                class="block w-full rounded-xl border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white shadow-sm focus:border-sky-500 focus:ring-sky-500 px-4 py-2.5 text-sm transition-colors duration-200"
            >
            @error('email')
                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Password</label>
            <input
                wire:model="password"
                id="password"
                type="password"
                required
                class="block w-full rounded-xl border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white shadow-sm focus:border-sky-500 focus:ring-sky-500 px-4 py-2.5 text-sm transition-colors duration-200"
            >
            @error('password')
                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember Me --}}
        <div class="flex items-center">
            <input
                wire:model="remember"
                id="remember"
                type="checkbox"
                class="h-4 w-4 rounded-md border-slate-300 dark:border-slate-600 text-sky-600 focus:ring-sky-500 dark:bg-slate-700"
            >
            <label for="remember" class="ml-2.5 text-sm text-slate-600 dark:text-slate-400">Remember me</label>
        </div>

        {{-- Submit --}}
        <div>
            <button
                type="submit"
                class="w-full py-2.5 px-4 rounded-xl text-sm font-semibold text-white bg-sky-600 hover:bg-sky-700 dark:bg-sky-500 dark:hover:bg-sky-600 shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800 transition-colors duration-200"
            >
                <span wire:loading.remove wire:target="authenticate">Sign in</span>
                <span wire:loading wire:target="authenticate" class="inline-flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    Signing in...
                </span>
            </button>
        </div>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500 dark:text-slate-400">
        Don't have an account?
        <a href="{{ route('register') }}" class="text-sky-600 dark:text-sky-400 hover:text-sky-700 dark:hover:text-sky-300 font-semibold transition-colors duration-200">Register</a>
    </p>
</div>
