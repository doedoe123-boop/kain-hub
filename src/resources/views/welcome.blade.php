<x-layouts.app>
    <div class="text-center py-16">
        <h1 class="text-4xl font-bold mb-4">Multi-Restaurant Marketplace</h1>
        <p class="text-lg text-gray-600 mb-8">Browse restaurants, order food, and enjoy delivery.</p>

        @guest
            <div class="space-x-4">
                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-500 font-medium">Sign in</a>
                <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition">Get Started</a>
            </div>
        @endguest

        @auth
            <p class="text-gray-500">Welcome back, {{ auth()->user()->name }}!</p>
        @endauth
    </div>
</x-layouts.app>
