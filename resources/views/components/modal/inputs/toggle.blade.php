@props(['label', 'id', 'model'])

<div class="flex items-center justify-between">
    <label
        class="block text-sm font-medium"
        for="{{ $id }}"
    >
        {{ $label }}
    </label>

    <label
        class="relative inline-flex cursor-pointer items-center"
        for="{{ $id }}"
    >
        <input
            class="peer sr-only"
            id="{{ $id }}"
            type="checkbox"
            x-model="{{ $model }}"
        />

        <div
            class="peer-focus:ring-primary-200 h-6 w-11 rounded-full bg-gray-200 after:absolute after:left-0.5 after:top-0.5 after:h-5 after:w-5 after:rounded-full after:bg-gray-50 after:shadow after:transition-all after:content-[''] hover:bg-gray-100 peer-checked:bg-blue-600 peer-checked:after:translate-x-full">
        </div>
    </label>
</div>
