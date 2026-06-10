<div
    x-show="{{ $show }}"
    x-transition.opacity
    @click.self="{{ $show }} && $store.modal.CloseModal()"
    @keyup.escape.window="{{ $show }} && $store.modal.CloseModal()"
    {{ $attributes->class(['fixed', 'bottom-0', 'left-0', 'right-0', 'top-0', 'z-40', 'h-full', 'w-full', 'stone', 'bg-stone-900/75', 'z-[10]', 'flex', 'items-start', 'justify-center', 'py-10', 'md:px-4', 'overflow-auto']) }}
>
    {{ $slot }}
</div>
