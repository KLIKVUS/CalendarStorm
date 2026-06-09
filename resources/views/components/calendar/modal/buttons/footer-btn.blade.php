@props(['formId', 'disabled'])

<div class="mt-8 text-right flex justify-between">
    <button
        class="mr-2 rounded-lg border-2 border-gray-300 bg-gray-300 px-4 py-2 font-semibold text-gray-700 shadow-sm hover:bg-gray-100"
        type="button"
        @click="modalService.CloseModal()"
    >{{ __('Cancel') }}</button>
    <button
        class="rounded-lg border-2 border-green-700 bg-gray-800 px-4 py-2 font-semibold text-white shadow-sm hover:bg-gray-700 disabled:opacity-50 disabled:pointer-events-none disabled:border-red-700"
        type="submit"
        :disabled="!$validate.isComplete('{{ $formId }}') || {{ $disabled }}"
    >{{ __('Send') }}</button>
</div>
