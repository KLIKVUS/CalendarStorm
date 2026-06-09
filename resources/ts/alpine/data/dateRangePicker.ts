import flatpickr from "flatpickr";
import type { Instance } from "flatpickr/dist/types/instance";
import { Russian } from "flatpickr/dist/l10n/ru.js";
import { format, getHours, getMinutes, getSeconds, set } from "date-fns";
import { ru } from "date-fns/locale";

interface DefaultDates {
    beginning: string;
    ending: string;
}

export default class DateTimePicker {
    public inputId: string;
    public defaultDates: DefaultDates;
    public picker: Instance | null = null;

    constructor(defaultDates: DefaultDates, inputId: string) {
        this.defaultDates = defaultDates;
        this.inputId = inputId;
    }

    public init() {
        const input: HTMLElement | null = document.getElementById(this.inputId);

        if (!input) throw new Error("Для работы DateRange нужно ID поля ввода");

        this.picker = flatpickr(input, {
            locale: Russian,
            mode: "range",
            defaultDate: this.defaultDatesArray,
            onChange: this.onChange,
            onClose: this.onClose,
        });
    }

    private onChange = (
        selectedDates: Date[],
        _dateStr: string,
        _instance: Instance,
    ) => {
        const formatStr = "yyyy-MM-dd HH:mm:ss";
        const newBeginning = selectedDates[0] ?? this.defaultDates.beginning;
        const newEnding = selectedDates[1] ?? this.defaultDates.ending;

        this.defaultDates.beginning = format(
            set(newBeginning, {
                hours: getHours(this.defaultDates.beginning),
                minutes: getMinutes(this.defaultDates.beginning),
                seconds: getSeconds(this.defaultDates.beginning),
            }),
            formatStr,
        );
        this.defaultDates.ending = format(
            set(newEnding, {
                hours: getHours(this.defaultDates.ending),
                minutes: getMinutes(this.defaultDates.ending),
                seconds: getSeconds(this.defaultDates.ending),
            }),
            formatStr,
        );
    };

    private onClose = (
        selectedDates: Date[],
        dateStr: string,
        instance: Instance,
    ) => {
        if (selectedDates.length > 1) return;

        selectedDates = [selectedDates[0], selectedDates[0]];
        instance.setDate(selectedDates);
        this.onChange(selectedDates, dateStr, instance);
    };

    public get defaultDatesArray(): string[] {
        return [this.defaultDates.beginning, this.defaultDates.ending];
    }

    public get defaultDatesFormatted(): string {
        const formatStr = "dd.MM.yy";
        const config = {
            locale: ru,
        };
        const beginning = format(
            this.defaultDates.beginning,
            formatStr,
            config,
        );
        const ending = format(this.defaultDates.ending, formatStr, config);

        return `С ${beginning} до ${ending}`;
    }
}
