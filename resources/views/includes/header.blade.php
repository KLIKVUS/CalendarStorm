<nav class="border-gray-200 bg-inherit py-5 pl-2 md:px-0"
    x-data="{ search__open: false, menu__open: false }">
    <div class="mx-auto flex flex-wrap items-stretch justify-between lg:gap-5">
        <div class="flex flex-1 items-center">
            <a class="flex items-center"
                href="{{ route('home.index') }}">
                {{-- <img class="mr-3 h-8"
                    src="https://flowbite.com/docs/images/logo.svg"
                    alt="Flowbite Logo" /> --}}
                <span class="dark:text-white self-center whitespace-nowrap text-2xl font-semibold">{{ config('app.name') }}</span>
            </a>
        </div>
        <div class="flex flex-1 justify-end lg:justify-center">
            <x-header.mobile-button @click="search__open = !search__open"
                :hint="__('Open search')">
                <x-tabler-icon size="2xl"
                    svg="search" />
            </x-header.mobile-button>
            <x-header.mobile-button @click="menu__open = !menu__open"
                :hint="__('Open main menu')">
                <x-tabler-icon size="2xl"
                    svg="menu-2" />
            </x-header.mobile-button>
            <x-header.search class="hidden lg:block" />
        </div>
        <div class="w-full items-center justify-between lg:order-1 lg:!flex lg:w-auto lg:flex-1 lg:justify-end">
            <div x-collapse
                x-show="search__open"
                @click.outside="search__open = false">
                <x-header.search class="lg:hidden" />
            </div>
            <div class="lg:!block lg:!h-auto"
                x-collapse
                x-show="menu__open"
                @click.outside="menu__open = false">
                <x-header.links-list />
            </div>
        </div>
    </div>
</nav>
