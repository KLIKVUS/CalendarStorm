<x-calendar.modal.wrappers.bg modalName="EditEvent">
    <x-calendar.modal.wrappers.content>
        <template x-if="modalService.activeModal == 'EditEvent'">
            <form
                id="eventEditForm"
                x-data="{
                    formData: modalService.modalsData['EventModal'],
                    send: async function() {
                        this.sending = true;
                        const payload = Object.fromEntries(
                            new FormData(this.$el)
                        );
                        const res = await eventService.eventController.Update(this.formData.id, payload);
                        if (res.success) {
                            eventService.init();
                            modalService.CloseModal();
                        }
                        $store.popups.show(res.success ? 'success' : 'error', res.message)
                        this.sending = false;
                    },
                    sending: false,
                }"
                x-validate
                @submit.prevent="$validate.submit && !sending && send()"
            >
                <h2 class="mb-6 border-b-4 border-inherit pb-2 text-2xl font-bold text-inherit">
                    {{ __('Редактирование ивента') }}
                </h2>

                <div class="space-y-4">
                    <x-calendar.modal.inputs.text-input
                        id="event-name"
                        name="name"
                        label="Название ивента"
                        model="formData.name"
                        placeholder="Крутое название ивента"
                        required
                    >
                        <x-calendar.modal.inputs.validation-error text="Название ивента обязательно" />
                    </x-calendar.modal.inputs.text-input>

                    <x-calendar.modal.inputs.date-range-picker
                        id="event-date-range"
                        label="Продолжительность ивента"
                        defaultDates="formData"
                        required
                    />

                    <div class="flex justify-between">
                        <x-calendar.modal.inputs.time-picker
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
                        <x-calendar.modal.inputs.time-picker
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

                    <x-calendar.modal.inputs.text-input
                        id="event-link"
                        name="link"
                        type="website"
                        label="Ссылка на ивент"
                        model="formData.link"
                        placeholder="https://event.com"
                    >
                        <x-calendar.modal.inputs.validation-error text="Неправильно задана ссылка на ивент" />
                    </x-calendar.modal.inputs.text-input>

                    <x-calendar.modal.inputs.textarea
                        id="event-description"
                        name="description"
                        label="Описание ивента"
                        model="formData.description"
                    />

                    <div x-data="{ isColorPickerOpened: false }">
                        <x-calendar.modal.inputs.toggle
                            id="event-color-enabled"
                            label="Задать цвет фона ивента"
                            model="isColorPickerOpened"
                        />

                        <div
                            x-show="isColorPickerOpened"
                            x-init="isColorPickerOpened = !!formData.color"
                            x-collapse
                        >
                            <x-calendar.modal.inputs.color-picker
                                id="event-color"
                                name="color"
                                label="Пример отображения ивента:"
                                model="formData.color"
                            />
                        </div>
                    </div>
                </div>

                <x-calendar.modal.buttons.footer-btn
                    formId='eventEditForm'
                    disabled="sending"
                />
            </form>
        </template>
    </x-calendar.modal.wrappers.content>
</x-calendar.modal.wrappers.bg>
