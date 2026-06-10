@props(['label', 'id', 'defaultDate', 'required' => false])

<div
    class="relative"
    {{ $attributes }}
    x-data="timePicker({{ $defaultDate }}, '{{ $id }}')"
    x-modelable="defaultDate"
>
    <label
        class="{{ $required ? "after:ml-0.5 after:text-red-500 after:content-['*']" : '' }} mb-1 block text-sm font-medium"
        for="{{ $id }}"
    >
        {{ $label }}
    </label>

    <input
        class="w-full appearance-none rounded-lg border-2 border-gray-300 bg-gray-50 px-4 py-2 leading-tight hover:border-blue-500 focus:border-blue-500 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:placeholder-gray-400"
        id="{{ $id }}"
        type="text"
        x-model="inputDate"
        {{ $attributes }}
    >
</div>
