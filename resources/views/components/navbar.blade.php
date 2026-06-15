@props(['profileSummary' => null])

<header class="sticky top-0 z-30 flex h-16 items-center gap-4 border-b border-gray-200/80 bg-white/80 px-4 shadow-sm backdrop-blur-md dark:border-gray-800/80 dark:bg-gray-900/80 sm:px-6">
    {{-- Mobile menu button --}}
    <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" aria-label="Toggle mobile menu" class="rounded-lg p-2 text-gray-500 transition hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 lg:hidden">
        <x-filament::icon icon="heroicon-c-bars-3" class="h-5 w-5" />
    </button>

    {{-- Desktop sidebar toggle --}}
    <button type="button" @click="sidebarOpen = !sidebarOpen" aria-label="Toggle sidebar" class="hidden rounded-lg p-2 text-gray-500 transition hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 lg:block">
        <x-filament::icon icon="heroicon-c-bars-3" class="h-5 w-5" />
    </button>

    {{-- Brand --}}
    <a href="{{ route('filament.dashboard.home') }}" class="flex items-center gap-2.5">
        <div
            class="flex h-8 w-8 items-center justify-center rounded-lg shadow-sm"
            style="background: linear-gradient(135deg, #10b981, #14b8a6, #0891b2);"
        >
            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor" style="color: #ffffff;">
                <path d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2zm0 2v1.5h16V6H4zm0 3.5V18a.5.5 0 0 0 .5.5h15a.5.5 0 0 0 .5-.5V9.5H4z"/>
                <rect x="6" y="12" width="3" height="4.5" rx="0.8"/>
                <rect x="10.5" y="10.5" width="3" height="6" rx="0.8"/>
                <rect x="15" y="11.5" width="3" height="5" rx="0.8"/>
            </svg>
        </div>
        <div class="hidden flex-col leading-tight sm:flex">
            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ config('dashboard.brand.name', 'Dashboard') }}</span>
            <span class="text-xs text-gray-500 dark:text-gray-400">Control Center</span>
        </div>
    </a>

    <div class="flex-1"></div>

    {{-- Right side actions --}}
    <div class="flex items-center gap-1.5">
        {{-- Theme toggle --}}
        <button
            type="button"
            @click="toggleTheme()"
            aria-label="Toggle theme"
            class="rounded-lg p-2 text-gray-500 transition hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800"
        >
            <x-filament::icon icon="heroicon-c-sun" class="h-5 w-5 dark:hidden" />
            <x-filament::icon icon="heroicon-c-moon" class="hidden h-5 w-5 dark:block" />
        </button>

        {{-- User avatar with dropdown --}}
        @if ($profileSummary && isset($profileSummary['initials']))
            <div x-data="{
                open: false
            }" class="relative">
                <button
                    type="button"
                    @click="open = !open"
                    @click.away="open = false"
                    @keydown.escape.window="open = false"
                    class="flex items-center gap-2.5 rounded-lg py-1 pl-1.5 pr-2.5 transition hover:bg-gray-100 dark:hover:bg-gray-800"
                >
                    <div
                        class="flex h-8 w-8 items-center justify-center rounded-full font-bold shadow-sm"
                        style="background: linear-gradient(135deg, #059669, #0f766e); color: #ffffff; font-size: 0.875rem;"
                    >
                        {{ $profileSummary['initials'] }}
                    </div>
                    <div class="hidden text-right leading-tight sm:block">
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $profileSummary['name'] }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $profileSummary['email'] }}</div>
                    </div>
                    <x-filament::icon icon="heroicon-c-chevron-down" class="hidden h-4 w-4 text-gray-400 transition sm:block" x-bind:style="open ? 'transform: rotate(180deg)' : ''" />
                </button>

                <div
                    x-show="open"
                    x-cloak
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="absolute right-0 z-50 mt-2 rounded-xl border border-gray-200/80 bg-white shadow-lg dark:border-gray-800/80 dark:bg-gray-900" style="width: 14rem;"
                >
                    <div class="px-4 py-3">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Signed in as') }}</p>
                        <p class="truncate text-sm font-semibold text-gray-900 dark:text-white">{{ $profileSummary['email'] }}</p>
                    </div>

                    @php
                        $userMenuItems = app(YezzMedia\Dashboard\Navigation\DashboardUserMenuRegistry::class)->all();
                    @endphp
                    @if (count($userMenuItems) > 0)
                        <div class="border-t border-gray-100 dark:border-gray-800"></div>

                        <div class="p-1.5">
                            @foreach ($userMenuItems as $userMenuItem)
                                @php
                                    $canSee = ! $userMenuItem->permission || auth(config('dashboard.panel.guard', 'web'))->can($userMenuItem->permission);
                                @endphp
                                @if ($canSee)
                                    <a
                                        href="{{ $userMenuItem->url }}"
                                        class="flex items-center gap-2.5 rounded-lg px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800"
                                        @click="open = false"
                                    >
                                        <x-filament::icon :icon="$userMenuItem->icon" class="h-4 w-4 text-gray-400" />
                                        {{ $userMenuItem->label }}
                                    </a>
                                @endif
                            @endforeach
                        </div>

                        <div class="border-t border-gray-100 dark:border-gray-800"></div>
                    @endif

                    <div class="p-1.5">
                        <form method="POST" action="{{ route('logout') }}" x-ref="logoutForm">
                            @csrf
                            <button
                                type="submit"
                                class="flex w-full items-center gap-2.5 rounded-lg px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900"
                            >
                                <x-filament::icon icon="heroicon-c-arrow-right-end-on-rectangle" class="h-4 w-4" />
                                {{ __('Log out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</header>
