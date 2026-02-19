<x-layouts.guest>
    <div class="text-center">
        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-6">
            <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <h2 class="text-2xl font-bold text-gray-900 mb-2">Application Submitted!</h2>

        <p class="text-gray-600 mb-6">
            Thank you for registering as a store owner. Our team will review your documents and verify your information.
        </p>

        <div class="bg-indigo-50 rounded-lg p-4 mb-6">
            <h3 class="text-sm font-semibold text-indigo-800 mb-2">What happens next?</h3>
            <ol class="text-sm text-indigo-700 space-y-1 text-left list-decimal list-inside">
                <li>We review your documents (3–5 business days)</li>
                <li>You'll receive an email with your approval status</li>
                <li>Once approved, you'll get your store login link</li>
                <li>Start adding products and managing your store!</li>
            </ol>
        </div>

        <a href="{{ route('home') }}" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-500 font-medium">
            &larr; Back to homepage
        </a>
    </div>
</x-layouts.guest>
