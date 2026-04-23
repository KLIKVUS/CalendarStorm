@props([
    'show' => 'false',
    'icon' => 'tabler-info-octagon',
    'type' => 'info',
])

@php
    $colors = [
        'success' => 'stroke-green-600',
        'error' => 'stroke-red-600',
        'info' => 'stroke-blue-600',
    ];
@endphp

<div
    {{ $attributes }}
    class="flex gap-x-4 items-center p-4 bg-white dark:bg-gray-700 rounded-xl drop-shadow-xl border-4 border-white dark:border-gray-700 hover:border-gray-50 dark:hover:border-gray-600 transition-colors"
    x-data="{
        show: {{ $show }},
        timer: null,
        closeDelay: 5000,
        closePopup() {
            this.show = false;
            this.timer = null;
        },
        setupTimer() {
            if (this.show) {
                this.timer = setTimeout(() => {
                    this.closePopup();
                }, this.closeDelay * popupsCount);
            }
        },
    }"
    x-init="async function() {
        await $nextTick();
        show = true;
        popupsCount++;
        setupTimer();
        $watch('show', () => {
            if (!this.show && !this.timer) {
                setTimeout(() => {
                    popupsCount--;
                    $el.remove();
                }, 500);
            }
        });
    }"
    @mouseenter="clearTimeout(timer)"
    @mouseleave="setupTimer()"
    x-show="show"
    x-transition:enter="transition-opacity duration-1000"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
>
    <x-icon name="{{ $icon }}" class="size-8 shrink-0 {{ $colors[$type] }}" />

    <div class="grow">
        {{ $slot }}
    </div>

    <div>
        <button
            type="button"
            class="p-2 inline-flex items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-500 dark:text-neutral-400 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-hidden focus:bg-gray-50 dark:focus:bg-neutral-700 disabled:opacity-50 disabled:pointer-events-none"
            @click="closePopup()"
        >
            <span class="sr-only">__('Dismiss')</span>
            <x-tabler-x class="size-6" />
        </button>
    </div>
</div>
