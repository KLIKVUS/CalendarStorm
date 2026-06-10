<x-modal.wrappers.bg show="['CreateCalendar', 'UpdateCalendar'].includes($store.modal.activeModal)">
    <x-modal.wrappers.content>
        <x-modal.for-calendar.create />
        <x-modal.for-calendar.update />
    </x-modal.wrappers.content>
</x-modal.wrappers.bg>
