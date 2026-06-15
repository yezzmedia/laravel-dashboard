@php
    $groups = $navigationGroups ?? [];
    $allItems = collect($groups)->flatMap(fn ($g) => $g['items'] ?? []);
@endphp

<div class="space-y-6">
    {{-- Welcome header --}}
    <div class="rounded-xl border border-gray-200/80 bg-white/50 p-6 backdrop-blur-sm dark:border-gray-800/80 dark:bg-gray-900/50 sm:p-8">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white sm:text-3xl">
            {{ __('dashboard::dashboard.welcome_back', ['name' => $profileSummary['name'] ?? 'User']) }}
        </h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            {{ __('dashboard::dashboard.pages.dashboard.description') }}
        </p>
    </div>

    {{-- Quick links --}}
    @php
        $visibleItems = $allItems->filter(fn ($item) => ! $item->permission || auth(config('dashboard.panel.guard', 'web'))->can($item->permission));
    @endphp
    @if ($visibleItems->isNotEmpty())
        <div>
            <h2 class="mb-3 text-sm font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">
                {{ __('dashboard::dashboard.sections.quick_access') }}
            </h2>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($visibleItems as $item)
                    <a
                        href="{{ $item->url }}"
                        class="group rounded-xl border border-gray-200/80 bg-white/50 p-4 shadow-sm transition-all hover:border-blue-200 hover:shadow-md dark:border-gray-800/80 dark:bg-gray-900/50 dark:hover:border-blue-800"
                    >
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-blue-50 to-indigo-50 text-blue-600 transition group-hover:from-blue-100 group-hover:to-indigo-100 dark:from-blue-950/50 dark:to-indigo-950/50 dark:text-blue-400">
                                <x-filament::icon :icon="$item->icon" class="h-5 w-5" />
                            </div>
                            <div class="min-w-0">
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $item->label }}
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Widgets --}}
    @if (filled($widgets ?? null))
        <div>
            <h2 class="mb-3 text-sm font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">
                {{ __('dashboard::dashboard.sections.insights') }}
            </h2>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($widgets as $widget)
                    @livewire($widget)
                @endforeach
            </div>
        </div>
    @endif
</div>
