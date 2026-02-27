@props(['url' => null, 'type' => 'unknown', 'label' => 'Document'])

@if($url)
    <div class="rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden bg-gray-50 dark:bg-gray-900">
        @if(in_array($type, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
            {{-- Image preview --}}
            <a href="{{ $url }}" target="_blank" class="block">
                <img
                    src="{{ $url }}"
                    alt="{{ $label }}"
                    class="w-full max-h-96 object-contain bg-white dark:bg-gray-800"
                    loading="lazy"
                />
            </a>
        @elseif($type === 'pdf')
            {{-- PDF embed --}}
            <iframe
                src="{{ $url }}#toolbar=0"
                class="w-full h-96 border-0"
                title="{{ $label }}"
            ></iframe>
        @else
            {{-- Fallback: icon + download link --}}
            <div class="flex flex-col items-center justify-center py-8 px-4 text-center">
                <x-heroicon-o-document class="w-12 h-12 text-gray-400 dark:text-gray-500 mb-2" />
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $label }}</p>
            </div>
        @endif

        <div class="flex items-center justify-between px-3 py-2 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
            <span class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $label }}</span>
            <a href="{{ $url }}" target="_blank" class="text-xs text-primary-600 hover:text-primary-500 font-medium flex items-center gap-1">
                <x-heroicon-m-arrow-top-right-on-square class="w-3.5 h-3.5" />
                Open
            </a>
        </div>
    </div>
@else
    <div class="flex items-center gap-2 px-3 py-4 rounded-lg border border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900">
        <x-heroicon-o-document class="w-5 h-5 text-gray-400" />
        <span class="text-sm text-gray-400 dark:text-gray-500">No document uploaded</span>
    </div>
@endif
