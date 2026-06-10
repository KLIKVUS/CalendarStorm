<template x-if="$store.modal.activeModal == 'CreateEvent'">
    <form
        id="eventCreateForm"
        x-show="$store.modal.activeModal == 'CreateEvent'"
        x-transition.opacity
        x-data="{
            formData: $store.modal.modalsData['EventModal.CreateEvent'],
            send: async function() {
                this.sending = true;
                const payload = Object.fromEntries(
                    new FormData(this.$el),
                );
                payload.color = this.isColorPickerOpened ? payload.color : '#61616180';
                const res = await eventService.eventController.Create(this.formData.calendarId, payload);
                if (res.success) {
                    eventService.init();
                    $store.modal.CloseModal();
                } else {
                    this.errors = res.errors;
                }
                $store.popups.show(res.success ? 'success' : 'error', res.message);
                this.sending = false;
            },
            sending: false,
            isColorPickerOpened: false,
            errors: {},
        }"
        x-validate
        @submit.prevent="$validate.submit && !sending && send()"
    >
        <h2 class="mb-6 border-b-4 border-inherit pb-2 text-2xl font-bold text-inherit">
            {{ __('Создание ивента') }}
        </h2>

        <div class="space-y-4">
            <x-modal.inputs.text-input
                id="event-name"
                name="name"
                label="Название ивента"
                model="formData.name"
                placeholder="Крутое название ивента"
                required
            >
                <x-modal.inputs.validation-error text="Название ивента обязательно" />
                <x-modal.inputs.validation-error for="name" />
            </x-modal.inputs.text-input>

            <x-modal.inputs.date-range-picker
                id="event-date-range"
                label="Продолжительность ивента"
                defaultDates="formData"
                required
            />

            <div class="flex justify-between">
                <x-modal.inputs.time-picker
                    id="event-beginning-time"
                    label="Время начала ивента"
                    defaultDate="formData.beginning"
                    x-model="formData.beginning"
                    required
                />
                <input
                    name="beginning"
                    type="hidden"
                    x-model="formData.beginning"
                >
                <x-modal.inputs.time-picker
                    id="event-ending-time"
                    label="Время окончания ивента"
                    defaultDate="formData.ending"
                    x-model="formData.ending"
                    required
                />
                <input
                    name="ending"
                    type="hidden"
                    x-model="formData.ending"
                >
            </div>

            <x-modal.inputs.text-input
                id="event-link"
                name="link"
                type="website"
                label="Ссылка на ивент"
                model="formData.link"
                placeholder="https://event.com"
            >
                <x-modal.inputs.validation-error text="Неправильно задана ссылка на ивент" />
                <x-modal.inputs.validation-error for="link" />
            </x-modal.inputs.text-input>

            <x-modal.inputs.textarea
                id="event-description"
                name="description"
                label="Описание ивента"
                model="formData.description"
            >
                <x-modal.inputs.validation-error for="description" />
            </x-modal.inputs.textarea>

            <div x-data="{ isColorPickerOpened: false }">
                <x-modal.inputs.toggle
                    id="event-color-enabled"
                    label="Задать цвет фона ивента"
                    model="isColorPickerOpened"
                />

                <div
                    x-show="isColorPickerOpened"
                    x-init="isColorPickerOpened = !!formData.color"
                    x-collapse
                >
                    <x-modal.inputs.color-picker
                        id="event-color"
                        name="color"
                        label="Пример отображения ивента:"
                        model="formData.color"
                    >
                        <x-modal.inputs.validation-error for="color" />
                    </x-modal.inputs.color-picker>
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-between gap-4">
            <x-modal.buttons.cancel class="basis-1/3" />
            <x-modal.buttons.send-form
                class="basis-1/3"
                ::disabled="!$validate.isComplete('eventCreateForm') || sending"
            />
        </div>
    </form>
</template>
