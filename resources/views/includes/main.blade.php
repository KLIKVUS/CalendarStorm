<!-- ========== MAIN CONTENT ========== -->
<main class="transition-[background-color,margin] duration-200 ease-in">
    <x-popups.popups-container>
        {{-- Сообщения об успехе (вход/регистрация) --}}
        @if (session()->has('success'))
            <x-popups.base-popup
                type="success"
                icon="tabler-circle-check"
            >
                <p class="text-sm text-gray-800 dark:text-neutral-200">{{ session('success') }}</p>
            </x-popups.base-popup>
        @endif

        <template
            x-for="(popup, index) in $store.popups.items"
            :key="'popup-' + index"
        >
            <span>
                <template
                    x-if="popup.type == 'success'"
                    hidden
                >
                    <x-popups.base-popup
                        type="success"
                        icon="tabler-circle-check"
                    >
                        <p
                            class="text-sm text-gray-800 dark:text-neutral-200"
                            x-text="popup.message"
                        ></p>
                    </x-popups.base-popup>
                </template>

                <template
                    x-if="popup.type == 'error'"
                    hidden
                >
                    <x-popups.base-popup
                        type="error"
                        icon="tabler-exclamation-circle"
                    >
                        <p
                            class="text-sm text-gray-800 dark:text-neutral-200"
                            x-text="popup.message"
                        ></p>
                    </x-popups.base-popup>
                </template>

                <template
                    x-if="popup.type == 'info'"
                    hidden
                >
                    <x-popups.base-popup
                        type="info"
                        icon="tabler-info-octagon"
                    >
                        <p
                            class="text-sm text-gray-800 dark:text-neutral-200"
                            x-text="popup.message"
                        ></p>
                    </x-popups.base-popup>
                </template>
            </span>
        </template>
    </x-popups.popups-container>

    <div class="mx-auto max-w-[85rem] bg-gray-50 p-4 sm:p-6 md:rounded-b-lg lg:p-8 dark:bg-gray-800">
        {{-- Основной контент страницы --}}
        @yield('content')
    </div>
</main>
<!-- ========== END MAIN CONTENT ========== -->
