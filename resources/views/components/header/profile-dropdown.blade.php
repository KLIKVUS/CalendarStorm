<div
    class="relative inline-flex overflow-visible text-start"
    x-data="{ isUserAvatarOpen: false }"
>
    <button
        class="focus:outline-hidden inline-flex shrink-0 items-center gap-x-2 rounded-lg p-0.5 pl-2 pr-1 text-start text-gray-800 hover:bg-slate-100 hover:text-gray-500 md:flex-row-reverse md:pl-1 md:pr-0.5 dark:text-neutral-200 dark:hover:bg-gray-700"
        type="button"
        @click="isUserAvatarOpen = !isUserAvatarOpen"
    >
        <x-tabler-user-square-rounded class="size-5" />
        {{ __('Профиль') }}
    </button>

    <!-- Account Dropdown -->
    <div
        class="duration absolute left-0 top-full z-[2] mt-2 w-60 rounded-xl border border-transparent bg-white shadow-xl transition-[opacity,margin] md:left-auto md:right-0 dark:bg-gray-700"
        x-show="isUserAvatarOpen"
        x-transition:enter="transition-opacity duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click.away="isUserAvatarOpen = false"
    >
        <div class="px-3.5 py-2">
            <p class="text-sm text-gray-500 dark:text-neutral-400">
                {{ __('User') }}:
            </p>
            <span class="font-medium text-gray-800 dark:text-neutral-200">
                {{ Auth::user()->login }}#{{ Auth::user()->id }}
            </span>
        </div>

        <div class="border-t-2 border-gray-200 dark:border-slate-600">
            <x-header.link
                route="profile.index"
                :routeParams="['id' => Auth::user()->id]"
            >
                <x-tabler-user class="size-4" />
                {{ __('Профиль') }}
            </x-header.link>

            <x-header.link route="home.index">
                <x-tabler-settings class="size-4" />
                {{ __('Настройки') }}
            </x-header.link>

            <div class="border-t-2 border-gray-200 dark:border-slate-600">
                <form
                    method="POST"
                    action="{{ route('auth.logout') }}"
                >
                    @csrf
                    <button
                        class="w-full p-2 text-sm text-red-600"
                        type="submit"
                    >
                        <span class="flex items-center gap-2">
                            <x-tabler-logout class="size-4" />
                            {{ __('Выйти') }}
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <!-- End Account Dropdown -->
</div>
