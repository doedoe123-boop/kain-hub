@php
    $url = $getViewData()['url'] ?? null;
    $downloadUrl = $getViewData()['downloadUrl'] ?? null;
    $type = $getViewData()['type'] ?? 'unknown';
    $label = $getViewData()['label'] ?? 'Document';
    $required = $getViewData()['required'] ?? false;
@endphp

@if($url)
    <div class="rounded-xl border border-gray-200 dark:border-white/10 overflow-hidden bg-gray-50 dark:bg-white/5">
        @if(in_array($type, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
            {{-- Image preview --}}
            <a href="{{ $downloadUrl ?? $url }}" target="_blank" class="block group">
                <img
                    src="{{ $url }}"
                    alt="{{ $label }}"
                    class="w-full max-h-[28rem] object-contain bg-white dark:bg-gray-800 transition-opacity group-hover:opacity-90"
                    loading="lazy"
                />
            </a>
        @elseif($type === 'pdf')
            {{-- PDF embed --}}
            <iframe
                src="{{ $url }}#toolbar=0&navpanes=0"
                class="w-full h-[28rem] border-0 bg-white"
                title="{{ $label }}"
                loading="lazy"
            ></iframe>
        @else
            {{-- Fallback --}}
            <div class="flex flex-col items-center justify-center py-10 px-4 text-center">
                <x-heroicon-o-document class="w-14 h-14 text-gray-300 dark:text-gray-600 mb-3" />
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $label }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Preview not available for this file type</p>
            </div>
        @endif

        <div class="flex items-center justify-between px-4 py-2.5 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-white/10">
            <div class="flex items-center gap-2 min-w-0">
                <x-heroicon-o-document-text class="w-4 h-4 text-gray-400 shrink-0" />
                <span class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $label }}</span>
                @if($required)
                    <span class="inline-flex items-center rounded-full bg-emerald-50 dark:bg-emerald-500/10 px-1.5 py-0.5 text-[10px] font-medium text-emerald-700 dark:text-emerald-400">Required</span>
                @endif
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ $url }}" target="_blank" class="text-xs text-primary-600 hover:text-primary-500 dark:text-primary-400 font-medium flex items-center gap-1 transition-colors">
                    <x-heroicon-m-eye class="w-3.5 h-3.5" />
                    View
                </a>
                @if($downloadUrl)
                    <a href="{{ $downloadUrl }}" target="_blank" class="text-xs text-primary-600 hover:text-primary-500 dark:text-primary-400 font-medium flex items-center gap-1 transition-colors">
                        <x-heroicon-m-arrow-down-tray class="w-3.5 h-3.5" />
                        Download
                    </a>
                @endif
            </div>
        </div>
    </div>
@else
    <div class="flex items-center gap-3 px-4 py-5 rounded-xl border border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-white/5">
        <x-heroicon-o-document class="w-6 h-6 text-gray-300 dark:text-gray-600" />
        <span class="text-sm text-gray-400 dark:text-gray-500">No document uploaded</span>
    </div>
@endif
