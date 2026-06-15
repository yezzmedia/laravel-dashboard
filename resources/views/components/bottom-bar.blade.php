<div class="border-t border-gray-200/80 bg-white/80 backdrop-blur-md dark:border-gray-800/80 dark:bg-gray-900/80">
    <div class="mx-auto flex max-w-7xl flex-col items-center gap-2 px-4 py-3 sm:flex-row sm:justify-between sm:px-6">
        <div class="flex items-center gap-4 text-xs">
            @foreach (config('dashboard.legal.left', []) as $link)
                <a href="{{ $link['url'] }}" class="text-gray-400 transition hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300">
                    {{ $link['label'] }}
                </a>
                @if (! $loop->last)
                    <span class="text-gray-300 dark:text-gray-600">|</span>
                @endif
            @endforeach
        </div>

        <div class="flex items-center gap-4 text-xs">
            @foreach (config('dashboard.legal.right', []) as $link)
                <a href="{{ $link['url'] }}" class="text-gray-400 transition hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300">
                    {{ $link['label'] }}
                </a>
                @if (! $loop->last)
                    <span class="text-gray-300 dark:text-gray-600">|</span>
                @endif
            @endforeach
            <span class="text-gray-300 dark:text-gray-600">|</span>
            <span class="text-gray-400 dark:text-gray-500">&copy; {{ date('Y') }} {{ config('app.name', 'YezzMedia') }}</span>
        </div>
    </div>
</div>
