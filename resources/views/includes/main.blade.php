<!-- ========== MAIN CONTENT ========== -->
<main class="transition-[background-color,margin] duration-200 ease-in">
    <x-popups.popups-container>
        {{-- Сообщения об успехе (вход/регистрация) --}}
        @if (session()->has('success'))
            <x-popups.base-popup type="success" icon="tabler-circle-check">
                <p class="text-sm text-gray-800 dark:text-neutral-200">{{ session('success') }}</p>
            </x-popups.base-popup>
        @endif
    </x-popups.popups-container>

    <div class="max-w-[85rem] mx-auto p-4 sm:p-6 lg:p-8 bg-gray-50 dark:bg-gray-800 md:rounded-b-lg">
        {{-- Основной контент страницы --}}
        @yield('content')
    </div>
</main>
<!-- ========== END MAIN CONTENT ========== -->
