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
    class="flex items-center gap-x-4 rounded-xl border-4 border-white bg-white p-4 drop-shadow-xl transition-colors hover:border-gray-50 dark:border-gray-700 dark:bg-gray-700 dark:hover:border-gray-600"
    {{ $attributes }}
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
    x-show.transition="show"
    x-transition:enter="transition-opacity duration-1000"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
>
    <x-icon
        class="{{ $colors[$type] }} size-8 shrink-0"
        name="{{ $icon }}"
    />

    <div class="grow">
        {{ $slot }}
    </div>

    <div>
        <button
            class="focus:outline-hidden inline-flex items-center gap-x-2 rounded-full border border-transparent p-2 text-sm font-semibold text-gray-500 hover:bg-gray-50 focus:bg-gray-50 disabled:pointer-events-none disabled:opacity-50 dark:text-neutral-400 dark:hover:bg-gray-600 dark:focus:bg-neutral-700"
            type="button"
            @click="closePopup()"
        >
            <span class="sr-only">__('Dismiss')</span>
            <x-tabler-x class="size-6" />
        </button>
    </div>
</div>
