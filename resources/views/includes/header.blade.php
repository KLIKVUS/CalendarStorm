<!-- ========== HEADER ========== -->
<header
    class="max-w-[85rem] mx-auto bg-gray-50 dark:bg-gray-800 border-b-4 border-gray-400 dark:border-gray-900 flex flex-wrap md:justify-start md:flex-nowrap z-50 w-full md:mt-5 md:rounded-t-lg transition-[background-color,margin] duration-200 ease-in"
    x-data="{
        isMenuOpen: false,
        isSearchOpen: false,
    }"
>
    <nav class="relative max-w-[85rem] w-full flex flex-col mx-auto px-4 sm:px-6 lg:px-8 py-2 md:space-y-2">
        <!-- Logo / Collapse Buttons -->
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <a class="font-semibold text-xl text-gray-800 dark:text-neutral-200 focus:outline-hidden focus:opacity-80" href="{{ route('home.index') }}" aria-label="{{ config('app.name') }}">{{ config('app.name') }}</a>
            <!-- End Logo -->

            <!-- Collapse Buttons -->
            <div class="flex justify-end items-center">
                <x-header.theme-switcher class="hidden md:block" />

                <x-header.menu-button
                    @click="isSearchOpen = !isSearchOpen"
                    class="md:hidden"
                    :hint="__('Поиск')"
                >
                    <template x-if="isSearchOpen">
                        <x-tabler-search-off class="size-5" />
                    </template>

                    <template x-if="!isSearchOpen">
                        <x-tabler-search class="size-5" />
                    </template>
                </x-header.menu-button>

                <x-header.menu-button
                    @click="isMenuOpen = !isMenuOpen"
                    class="md:hidden"
                    :hint="__('Меню')"
                >
                    <template x-if="isMenuOpen">
                        <x-tabler-x class="size-6" />
                    </template>

                    <template x-if="!isMenuOpen">
                        <x-tabler-menu-2 class="size-6" />
                    </template>
                </x-header.menu-button>
            </div>
            <!-- End Collapse Button -->
        </div>
        <!-- End Logo / Collapse Buttons -->

        <!-- Collapses -->
        <x-header.collapse-elem :when-collapse="'isMenuOpen'">
            <div class="flex flex-col md:flex-row md:items-center gap-0.5 md:gap-1 divide-y md:divide-y-0 divide-slate-600">
                <x-header.link route="home.index">
                    <x-tabler-home-f class="size-5"/>
                    {{ __('Home') }}
                </x-header.link>

                <x-header.link route="calendar.index">
                    <x-tabler-calendar-month-f class="size-5"/>
                    {{ __('Global-календаль') }}
                </x-header.link>

                <!-- Button Group -->
                <div class="relative flex flex-wrap items-center justify-between gap-x-1.5 md:ml-auto md:ps-2.5 pt-2 md:pt-0 before:hidden md:before:block before:absolute before:top-1/2 before:-start-px before:w-px before:h-4 before:bg-gray-200 dark:before:bg-neutral-700 before:-translate-y-1/2">
                    <x-header.auth-buttons />
                    <x-header.theme-switcher class="md:hidden" />
                </div>
                <!-- End Button Group -->
            </div>
        </x-header.collapse-elem>

        <x-header.collapse-elem :when-collapse="'isSearchOpen'">
            <!-- Search -->
            <x-header.search />
            <!-- End Search -->
        </x-header.collapse-elem>
    <!-- End Collapses -->
    </nav>
</header>
<!-- ========== END HEADER ========== -->
