<template x-if="$store.modal.activeModal == 'ReadEvent'">
    <div
        x-show="$store.modal.activeModal == 'ReadEvent'"
        x-transition.opacity
        x-data="{
            formData: $store.modal.modalsData['EventModal.ReadEvent'],
            deletingEvent: false,
            deleteEvent: async function() {
                this.deletingEvent = true;
                const res = await eventService.eventController.Delete(this.formData.id);
                if (res.success) {
                    eventService.init();
                    $store.modal.CloseModal();
                }
                $store.popups.show(res.success ? 'success' : 'error', res.message);
                this.deletingEvent = false;
            },
        }"
    >
        <h2 class="mb-6 border-b-4 border-inherit pb-2 text-2xl font-bold text-inherit">
            {{ __('Просмотр ивента') }}
        </h2>

        <div class="space-y-4">
            <x-modal.inputs.text-input
                id="event-name"
                name="name"
                label="Название ивента"
                model="formData.name"
                placeholder="Крутое название ивента"
                required
                disabled
                :validate=false
            />

            <x-modal.inputs.date-range-picker
                id="event-date-range"
                label="Продолжительность ивента"
                defaultDates="formData"
                required
                disabled
            />

            <div class="flex justify-between">
                <x-modal.inputs.time-picker
                    id="event-beginning-time"
                    label="Время начала ивента"
                    defaultDate="formData.beginning"
                    x-model="formData.beginning"
                    required
                    disabled
                />
                <x-modal.inputs.time-picker
                    id="event-ending-time"
                    label="Время окончания ивента"
                    defaultDate="formData.ending"
                    x-model="formData.ending"
                    required
                    disabled
                />
            </div>

            <x-modal.inputs.text-input
                id="event-link"
                name="link"
                type="website"
                label="Ссылка на ивент"
                model="formData.link"
                placeholder="https://event.com"
                disabled
                :validate=false
            />

            <x-modal.inputs.textarea
                id="event-description"
                name="description"
                label="Описание ивента"
                model="formData.description"
                disabled
            />
        </div>

        <div class="mt-8 flex flex-wrap justify-between gap-4">
            <template
                x-if="formData.rights_of_the_current_user.is_user_can_update"
                hidden
            >
                <x-modal.buttons.trigger
                    class="basis-1/3"
                    text="Изменить"
                    @click="$store.modal.SetModalData('EventModal.UpdateEvent', formData); $store.modal.OpenModal('UpdateEvent');"
                />
            </template>
            <template
                x-if="formData.rights_of_the_current_user.is_user_can_delete"
                hidden
            >
                <x-modal.buttons.delete
                    class="basis-1/3"
                    @click="deleteEvent()"
                    ::disabled="deletingEvent"
                />
            </template>
            <x-modal.buttons.cancel class="w-full" />
        </div>
    </div>
</template>
