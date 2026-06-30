<!DOCTYPE html>
@php
    $rtlLocales = ['ar', 'fa', 'he', 'ur', 'ps', 'yi'];
    $direction = in_array(app()->getLocale(), $rtlLocales, true) ? 'rtl' : 'ltr';
@endphp
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ $direction }}"
    @class([
        'fi',
        'dark' => filament()->hasDarkMode() && filament()->hasDarkModeForced(),
    ])
>
    <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        @if ($favicon = filament()->getFavicon())
            <link rel="icon" href="{{ $favicon }}" />
        @endif

        @if (filled($pageDescription ?? null))
            <meta name="description" content="{{ $pageDescription }}" />
        @endif

        <title>
            {{ $pageTitle ?? __('dashboard::dashboard.pages.dashboard.title') }}
            @if (filled($pageTitle ?? null) && filled(filament()->getBrandName()))
                -
            @endif
            {{ filament()->getBrandName() }}
        </title>

        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        @filamentStyles

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{ filament()->getTheme()->getHtml() }}

        @stack('styles')
    </head>

    <body class="fi-body fi-panel-{{ filament()->getId() }}">
        <div
            class="flex h-screen flex-col bg-gradient-to-br from-gray-50 via-white to-gray-50 dark:from-gray-950 dark:via-gray-900 dark:to-gray-950"
            x-data="{
                sidebarOpen: true,
                mobileMenuOpen: false,
                themeDark: false,
                init() {
                    this.effectiveTheme();
                },
                effectiveTheme() {
                    const stored = localStorage.getItem('theme');
                    if (stored === 'dark') {
                        this.themeDark = true;
                    } else if (stored === 'light') {
                        this.themeDark = false;
                    } else {
                        this.themeDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    }
                },
                toggleTheme() {
                    this.themeDark = !this.themeDark;
                    document.documentElement.classList.toggle('dark');
                    localStorage.setItem('theme', this.themeDark ? 'dark' : 'light');
                }
            }"
        >
            {{-- Navbar --}}
            <x-dashboard::navbar :profile-summary="$profileSummary ?? null" />

            <div class="flex flex-1 overflow-hidden">
                {{-- Desktop Sidebar --}}
                <aside
                    class="sticky top-16 z-20 hidden shrink-0 flex-col bg-white/70 backdrop-blur-md transition-all duration-300 dark:bg-gray-900/70 lg:flex"
                    x-bind:class="sidebarOpen ? 'w-64' : 'w-16'"
                >
                    <nav class="flex-1 space-y-1 overflow-y-auto border-r border-gray-200/80 p-3 dark:border-gray-800/80">
                        @foreach ($navigationGroups ?? [] as $groupKey => $group)
                            @if (count($group['items']) > 0)
                                <div x-data="{ collapsed: localStorage.getItem('nav_{{ $groupKey }}') === '1' }">
                                    <button
                                        @click="collapsed = !collapsed; localStorage.setItem('nav_{{ $groupKey }}', collapsed ? '1' : '0')"
                                        x-show="sidebarOpen"
                                        x-cloak:important
                                        class="flex w-full items-center gap-2 px-2.5 py-1.5 text-xs font-semibold uppercase tracking-wider text-gray-400 transition hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300"
                                    >
                                        <span x-show="!collapsed"><x-account::icon name="chevron-down" class="h-3 w-3 transition" /></span>
                                        <span x-show="collapsed" x-cloak><x-account::icon name="chevron-right" class="h-3 w-3 transition" /></span>
                                        {{ $group['label'] }}
                                    </button>
                                    <ul x-show="!collapsed" class="mt-0.5 space-y-0.5">
                                        @foreach ($group['items'] as $item)
                                            @php
                                                $canSee = ! $item->permission || auth(config('dashboard.panel.guard', 'web'))->can($item->permission);
                                                $isActive = url()->current() === url($item->url);
                                            @endphp
                                            @if ($canSee)
                                                <li>
                                                    <a
                                                        href="{{ $item->url }}"
                                                        @class([
                                                            'group relative flex items-center gap-3 px-2.5 py-2 text-sm font-medium transition-all duration-150',
                                                            'bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 shadow-sm dark:from-blue-950/50 dark:to-indigo-950/50 dark:text-blue-300' => $isActive,
                                                            'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' => ! $isActive,
                                                        ])
                                                        x-bind:class="sidebarOpen ? 'justify-start' : 'justify-center'"
                                                        title="{{ $item->label }}"
                                                    >
                                                        @if ($isActive)
                                                            <span class="absolute left-0 top-1/2 h-5 w-0.5 -translate-y-1/2 bg-blue-500" x-show="sidebarOpen" x-cloak:important></span>
                                                        @endif
                                                        <x-account::icon
                                                            :name="$item->icon"
                                                            @class([
                                                                'h-5 w-5 shrink-0 transition-colors',
                                                                'text-blue-600 dark:text-blue-400' => $isActive,
                                                                'text-gray-400 group-hover:text-gray-600 dark:text-gray-500 dark:group-hover:text-gray-300' => ! $isActive,
                                                            ])
                                                        />
                                                        <span x-show="sidebarOpen" x-cloak:important class="truncate">{{ $item->label }}</span>
                                                        @php
                                                            $badgeValue = $item->badgeCallback ? app()->call($item->badgeCallback) : $item->badge;
                                                        @endphp
                                                        @if ($badgeValue)
                                                            <span
                                                                x-show="sidebarOpen"
                                                                x-cloak:important
                                                                class="ml-auto inline-flex items-center rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-700 dark:bg-blue-900 dark:text-blue-300"
                                                            >
                                                                {{ $badgeValue }}
                                                            </span>
                                                        @endif
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endforeach
                    </nav>

                    <div class="border-t border-gray-200/80 px-3 dark:border-gray-800/80">
                        @php
                            $sidebarUrl = route('filament.dashboard.home');
                        @endphp
                        <a
                            href="{{ $sidebarUrl }}"
                            class="flex items-center gap-2 px-2.5 text-xs font-medium text-gray-500 transition hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                            style="padding-top: 12px; padding-bottom: 12px;"
                            x-bind:class="sidebarOpen ? 'justify-start' : 'justify-center'"
                            x-show="sidebarOpen"
                            x-cloak:important
                        >
                            <x-account::icon name="arrow-right" class="h-3.5 w-3.5" />
                            @if (str_starts_with(request()->path(), 'account'))
                                {{ __('account::ui.back_to_hub') }}
                            @else
                                {{ __('dashboard::dashboard.nav.dashboard') }}
                            @endif
                        </a>
                    </div>
                </aside>

                {{-- Mobile Sidebar --}}
                <div
                    x-show="mobileMenuOpen"
                    x-cloak:important
                    @click="mobileMenuOpen = false"
                    class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm lg:hidden"
                ></div>
                <aside
                    x-show="mobileMenuOpen"
                    x-cloak:important
                    class="fixed inset-y-0 left-0 z-50 flex h-full w-64 flex-col border-r border-gray-200 bg-white shadow-xl dark:border-gray-800 dark:bg-gray-900 lg:hidden"
                >
                    <div class="flex h-16 items-center justify-between border-b border-gray-200 px-4 dark:border-gray-800">
                        <span class="flex items-center gap-2.5">
                            <div class="flex h-8 w-8 items-center justify-center bg-gradient-to-br from-blue-500 via-indigo-500 to-purple-600">
                                <x-account::icon name="grid" class="h-4 w-4 text-white" />
                            </div>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ config('dashboard.brand.name', 'Dashboard') }}</span>
                        </span>
                        <button type="button" @click="mobileMenuOpen = false" aria-label="{{ __('dashboard::dashboard.nav.close_menu') }}" class="p-1.5 text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800">
                            <x-account::icon name="x" class="h-5 w-5" />
                        </button>
                    </div>
                    <nav class="flex-1 space-y-1 overflow-y-auto p-3">
                        @foreach ($navigationGroups ?? [] as $groupKey => $group)
                            @if (count($group['items']) > 0)
                                <div x-data="{ collapsed: localStorage.getItem('nav_mobile_{{ $groupKey }}') === '1' }">
                                    <button
                                        @click="collapsed = !collapsed; localStorage.setItem('nav_mobile_{{ $groupKey }}', collapsed ? '1' : '0')"
                                        class="flex w-full items-center gap-2 px-2.5 py-1.5 text-xs font-semibold uppercase tracking-wider text-gray-400 transition hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300"
                                    >
                                        <span x-show="!collapsed"><x-account::icon name="chevron-down" class="h-3 w-3 transition" /></span>
                                        <span x-show="collapsed" x-cloak><x-account::icon name="chevron-right" class="h-3 w-3 transition" /></span>
                                        {{ $group['label'] }}
                                    </button>
                                    <ul x-show="!collapsed" class="mt-0.5 space-y-0.5">
                                        @foreach ($group['items'] as $item)
                                            @php
                                                $canSee = ! $item->permission || auth(config('dashboard.panel.guard', 'web'))->can($item->permission);
                                            @endphp
                                            @if ($canSee)
                                                <li>
                                                    <a
                                                        href="{{ $item->url }}"
                                                        @click="mobileMenuOpen = false"
                                                        @class([
                                                            'flex items-center gap-3 px-2.5 py-2 text-sm font-medium transition-colors',
                                                            'bg-blue-50 text-blue-700 dark:bg-blue-950/50 dark:text-blue-300' => url()->current() === url($item->url),
                                                            'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' => url()->current() !== url($item->url),
                                                        ])
                                                    >
                                                        <x-account::icon :name="$item->icon" class="h-5 w-5" />
                                                        {{ $item->label }}
                                                        @php
                                                            $badgeValue = $item->badgeCallback ? app()->call($item->badgeCallback) : $item->badge;
                                                        @endphp
                                                        @if ($badgeValue)
                                                            <span class="ml-auto inline-flex items-center rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-700 dark:bg-blue-900 dark:text-blue-300">
                                                                {{ $badgeValue }}
                                                            </span>
                                                        @endif
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endforeach
                    </nav>
                </aside>

                {{-- Main Content --}}
                <main class="flex flex-1 flex-col overflow-y-auto">
                    <div class="flex-1 mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
                        {{ $slot }}
                    </div>

                    @includeIf('dashboard::components.bottom-bar')
                </main>
            </div>
        </div>

        @livewire(Filament\Livewire\Notifications::class)

        @filamentScripts(withCore: true)

        @stack('scripts')
    </body>
</html>
