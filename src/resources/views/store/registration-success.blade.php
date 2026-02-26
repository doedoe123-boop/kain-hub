<x-layouts.guest>
    <div class="max-w-lg mx-auto bg-white rounded-xl border border-gray-200 p-8 sm:p-10 shadow-sm text-center">
        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-6">
            <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <h2 class="text-2xl font-bold text-gray-900 mb-2">Application Submitted!</h2>

        <p class="text-gray-600 mb-8">
            Thank you for registering as a store owner. Our team will review your documents and verify your information.
        </p>

        <div class="bg-indigo-50 rounded-xl p-6 mb-8 text-left">
            <h3 class="text-sm font-semibold text-indigo-800 mb-3">What happens next?</h3>
            <ol class="text-sm text-indigo-700 space-y-2 list-decimal list-inside">
                <li>We review your documents (3–5 business days)</li>
                <li>You'll receive an email with your approval status</li>
                <li>Once approved, you'll get your store login link</li>
                <li>Start adding products and managing your store!</li>
            </ol>
        </div>

        <a href="{{ route('home') }}"
            class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Back to homepage
        </a>
    </div>
</x-layouts.guest>
