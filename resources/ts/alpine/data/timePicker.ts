import flatpickr from "flatpickr";
import type { Instance } from "flatpickr/dist/types/instance";
import { Russian } from "flatpickr/dist/l10n/ru.js";
import { format, set } from "date-fns";

export default class TimePicker {
    public inputId: string;
    public inputDate: string = "";
    public defaultDate: string;
    public picker: Instance | null = null;

    constructor(defaultDate: string, inputId: string) {
        this.defaultDate = defaultDate;
        this.inputId = inputId;
    }

    public init() {
        const input: HTMLElement | null = document.getElementById(this.inputId);

        if (!input)
            throw new Error("Для работы TimePicker нужно ID поля ввода");

        this.inputDate = format(this.defaultDate, "HH:mm");
        this.picker = flatpickr(input, {
            locale: Russian,
            enableTime: true,
            noCalendar: true,
            altFormat: "y-m-d H:i:S",
            dateFormat: "H:i",
            time_24hr: true,
            defaultDate: this.inputDate,
        });

        (this as any).$watch("inputDate", (value: string) => {
            const time = value.split(':');
            const newDefaultDate = set(this.defaultDate, {
                hours: Number(time[0]),
                minutes: Number(time[1]),
            })

            this.defaultDate = format(newDefaultDate, "yyyy-MM-dd HH:mm:ss")
        });
    }
}
