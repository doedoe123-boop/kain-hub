<x-layouts.guest>
    <div class="max-w-lg mx-auto bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-8 sm:p-10 shadow-lg dark:shadow-none text-center animate-scale-in">
        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-2xl bg-emerald-100 dark:bg-emerald-900/30 mb-6">
            <x-heroicon-o-check-circle class="h-8 w-8 text-emerald-600 dark:text-emerald-400" />
        </div>

        <h2 class="text-2xl font-bold text-slate-800 dark:text-white mb-2">Application Submitted!</h2>

        <p class="text-sm text-slate-500 dark:text-slate-400 mb-8 leading-relaxed">
            Thank you for registering as a store owner. Our team will review your documents and verify your information.
        </p>

        <div class="bg-sky-50 dark:bg-sky-900/20 rounded-xl p-6 mb-8 text-left border border-sky-100 dark:border-sky-800">
            <h3 class="text-sm font-semibold text-sky-800 dark:text-sky-300 mb-3 flex items-center gap-2">
                <x-heroicon-o-information-circle class="w-4 h-4" />
                What happens next?
            </h3>
            <ol class="text-sm text-sky-700 dark:text-sky-300 space-y-2.5 list-decimal list-inside leading-relaxed">
                <li>We review your documents (3–5 business days)</li>
                <li>You'll receive an email with your approval status</li>
                <li>Once approved, you'll get your store login link</li>
                <li>Start adding products and managing your store!</li>
            </ol>
        </div>

        <a href="{{ route('home') }}"
            class="inline-flex items-center px-5 py-2.5 text-sm font-semibold text-sky-700 dark:text-sky-300 bg-sky-50 dark:bg-sky-900/20 rounded-xl hover:bg-sky-100 dark:hover:bg-sky-900/40 border border-sky-200 dark:border-sky-700 transition-colors duration-200">
            <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" />
            Back to homepage
        </a>
    </div>
</x-layouts.guest>
