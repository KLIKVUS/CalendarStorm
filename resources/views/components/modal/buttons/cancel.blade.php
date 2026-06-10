<button
    type="button"
    {{ $attributes->class(['rounded-lg border-2 border-gray-300 bg-gray-300 px-4 py-2 font-semibold text-gray-700 shadow-sm hover:bg-gray-100']) }}
    {{ $attributes }}
    @click="$store.modal.CloseModal()"
>{{ __('Close') }}</button>
