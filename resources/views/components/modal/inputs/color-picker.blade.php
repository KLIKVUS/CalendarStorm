@props(['label', 'name' => false, 'id', 'model'])

<div>
    <p class="block text-sm font-medium text-gray-500">
        {{ $label }}
    </p>

    <div class="relative flex items-center justify-center">
        <label
            class="absolute truncate text-sm font-medium"
            for="{{ $id }}"
        >
            Нажмите для изменения цвета ивента
        </label>

        <input
            class="block h-10 w-full cursor-pointer rounded-lg bg-inherit"
            id="{{ $id }}"
            type="color"
            @if ($name) name="{{ $name }}" @endif
            x-model="{{ $model }}"
        />
    </div>

    {{ $slot }}
</div>
