@php
    $groups = $navigationGroups ?? [];
    $allItems = collect($groups)->flatMap(fn ($g) => $g['items'] ?? []);
@endphp

<div class="space-y-6">
    {{-- Welcome Hero --}}
    <x-account::page-header
        :title="__('dashboard::dashboard.welcome_back', ['name' => $profileSummary['name'] ?? 'User'])"
        :subtitle="__('dashboard::dashboard.pages.dashboard.description')"
        color="indigo"
    >
        <x-slot:icon>
            <x-account::icon name="grid" class="h-5 w-5" />
        </x-slot:icon>
    </x-account::page-header>

    {{-- Main Content Grid --}}
    <div class="grid gap-6 lg:grid-cols-3">
        {{-- Left Column: Quick Links + Widgets --}}
        <div class="lg:col-span-2 space-y-6">
            @php
                $visibleItems = $allItems->filter(fn ($item) => ! $item->permission || auth(config('dashboard.panel.guard', 'web'))->can($item->permission));
            @endphp
            @if ($visibleItems->isNotEmpty())
                <div class="border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="w-1 h-4 bg-indigo-400"></span>
                            <h2 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                {{ __('dashboard::dashboard.sections.quick_access') }}
                            </h2>
                        </div>
                        <div class="space-y-0.5">
                            @foreach ($visibleItems as $item)
                                <a
                                    href="{{ $item->url }}"
                                    class="flex items-center gap-3 px-3 py-3 border-l-2 border-transparent hover:border-indigo-300 dark:hover:border-indigo-700 hover:bg-indigo-50/60 dark:hover:bg-indigo-900/10 transition"
                                >
                                    <span class="flex-shrink-0 w-8 h-8 bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center">
                                        <x-account::icon :name="$item->icon" class="h-4 w-4 text-indigo-500" />
                                    </span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $item->label }}</span>
                                    @php
                                        $badgeValue = $item->badgeCallback ? app()->call($item->badgeCallback) : $item->badge;
                                    @endphp
                                    @if ($badgeValue)
                                        <span class="ml-auto inline-flex items-center rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-700 dark:bg-blue-900 dark:text-blue-300">
                                            {{ $badgeValue }}
                                        </span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Widgets --}}
            @if (filled($widgets ?? null))
                @foreach ($widgets as $widget)
                    @livewire($widget)
                @endforeach
            @endif
        </div>

        {{-- Right Column --}}
        <div class="space-y-6">
            @if (empty($visibleItems) && empty($widgets))
                <div class="border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900">
                    <div class="p-4 sm:p-6">
                        <x-account::empty-state
                            title="{{ __('dashboard::dashboard.empty.title') }}"
                            description="{{ __('dashboard::dashboard.empty.description') }}"
                            icon="grid"
                        />
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
