<template x-if="$store.modal.activeModal == 'UpdateCalendar'">
    <form
        id="calendarUpdateForm"
        x-show="$store.modal.activeModal == 'UpdateCalendar'"
        x-transition.opacity
        x-data="{
            formData: $store.modal.modalsData['CalendarModal']['UpdateCalendar'],
            send: async function() {
                this.sending = true;
                const payload = Object.fromEntries(
                    new FormData(this.$el),
                );
                const res = await $store.axios.put(`/calendars/${this.formData.id}`, payload);
                if (res.success) {
                    window.location.reload()
                } else {
                    this.errors = res.errors;
                }
                $store.popups.show(res.success ? 'success' : 'error', res.message);
                this.sending = false;
            },
            sending: false,
            errors: {},
        }"
        x-validate
        @submit.prevent="$validate.submit && !sending && send()"
    >
        <h2 class="mb-6 border-b-4 border-inherit pb-2 text-2xl font-bold text-inherit">
            {{ __('Создание календаря') }}
        </h2>

        <div class="space-y-4">
            <x-modal.inputs.text-input
                id="calendar-name"
                name="name"
                label="Название календаря"
                model="formData.name"
                placeholder="Крутое название ивента"
                required
            >
                <x-modal.inputs.validation-error text="Название календаря обязательно" />
                <x-modal.inputs.validation-error for="name" />
            </x-modal.inputs.text-input>
        </div>

        <div class="mt-8 flex justify-between gap-4">
            <x-modal.buttons.cancel class="basis-1/3" />
            <x-modal.buttons.send-form
                class="basis-1/3"
                ::disabled="!$validate.isComplete('calendarUpdateForm') || sending"
            />
        </div>
    </form>
</template>
