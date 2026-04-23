<div
    class="inline-flex relative text-start overflow-visible"
    x-data="{ isUserAvatarOpen: false }"
>
    <button
        type="button"
        class="p-0.5 pr-1 pl-2 md:pr-0.5 md:pl-1 inline-flex shrink-0 items-center gap-x-2 text-start text-gray-800 dark:text-neutral-200 rounded-lg hover:bg-slate-100 dark:hover:bg-gray-700 focus:outline-hidden md:flex-row-reverse"
        @click="isUserAvatarOpen = !isUserAvatarOpen"
    >
        <x-tabler-user-square-rounded class="size-5" />
        {{ __('Профиль') }}
    </button>

    <!-- Account Dropdown -->
    <div
        class="z-[2] absolute left-0 md:right-0 md:left-auto top-full mt-2 w-60 transition-[opacity,margin] duration bg-white dark:bg-gray-700 border border-transparent rounded-xl shadow-xl"
        x-show="isUserAvatarOpen"
        x-transition:enter="transition-opacity duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click.away="isUserAvatarOpen = false"
    >
        <div class="py-2 px-3.5">
            <span class="font-medium text-gray-800 dark:text-neutral-200">
                {{ __('User') }}:
            </span>
            <p class="text-sm text-gray-500 dark:text-neutral-400">
                {{ Auth::user()->login }}
            </p>
        </div>

        <div class="border-t-2 border-gray-200 dark:border-slate-600">
            <x-header.link route="home.index">
                <x-tabler-user class="size-4"/>
                {{ __('Профиль') }}
            </x-header.link>

            <x-header.link route="home.index">
                <x-tabler-settings class="size-4"/>
                {{ __('Настройки') }}
            </x-header.link>

            <div class="border-t-2 border-gray-200 dark:border-slate-600">
                <form method="POST" action="{{ route('auth.logout') }}">
                    @csrf
                    <button type="submit" class="w-full p-2 text-sm text-red-600">
                        <span class="flex items-center gap-2">
                            <x-tabler-logout class="size-4"/>
                            {{ __('Выйти') }}
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <!-- End Account Dropdown -->
</div>
