<button
    type="button"
    {{ $attributes->class(['rounded-lg border-2 border-red-700 bg-red-700 px-4 py-2 font-semibold text-white shadow-sm hover:bg-red-400 disabled:pointer-events-none disabled:opacity-50']) }}
    {{ $attributes }}
>{{ __('Delete') }}</button>
