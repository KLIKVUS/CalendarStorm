@props([
    'type' => 'text',
    'name' => false,
    'label',
    'id',
    'model',
    'placeholder' => '',
    'required' => false,
    'validate' => true,
])

<div>
    <label
        class="{{ $required ? "after:ml-0.5 after:text-red-500 after:content-['*']" : '' }} mb-1 block text-sm font-medium"
        for="{{ $id }}"
    >
        {{ $label }}
    </label>

    <input
        class="w-full appearance-none rounded-lg border-2 border-gray-300 bg-gray-50 px-4 py-2 leading-tight hover:border-blue-500 focus:border-blue-500 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:placeholder-gray-400"
        id="{{ $id }}"
        type="{{ $type }}"
        {{ $attributes }}
        placeholder="{{ $placeholder }}"
        x-model="{{ $model }}"
        @if ($required) required @endif
        @if ($name) name="{{ $name }}" @endif
        @if ($validate) x-validate.{{ $type }} @endif
    />

    {{ $slot }}
</div>
