import Alpine from "alpinejs";
import collapse from "@alpinejs/collapse";
import persist from "@alpinejs/persist";
import intersect from "@alpinejs/intersect";
import validate from "@colinaut/alpinejs-plugin-simple-validate";

import localUserSettings from "./data/localUserSettings";
import CalendarInterface from "./data/calendar/index";
import dragScroll from "./data/dragScroll";
import DateTimePicker from "./data/dateRangePicker";
import TimePicker from "./data/timePicker";

import { createBreakpointsStore } from "./store/breakpoints";
import popup from "./store/popup";

window.Alpine = Alpine;

Alpine.plugin(collapse);
Alpine.plugin(persist);
Alpine.plugin(intersect);
Alpine.plugin(validate);

// Локальные настройки пользователя (хранятся только на стороне клиента)
Alpine.data("localUserSettings", localUserSettings);
// Функции основного календаря
const globalCalendarInterface = new CalendarInterface();
Alpine.data("GlobalCalendar", () => globalCalendarInterface);
// Функции для скрола при помощи драга
Alpine.data("dragScroll", dragScroll);
// Селектор даты и времени
Alpine.data(
    "dateRangePicker",
    (
        defaultDates: {
            beginning: string;
            ending: string;
        },
        inputId: string,
    ) => new DateTimePicker(defaultDates, inputId),
);
Alpine.data(
    "timePicker",
    (
        defaultDate: string,
        inputId: string,
    ) => new TimePicker(defaultDate, inputId),
);

// Хранилище для точек перелома
Alpine.store("breakpoints", createBreakpointsStore());

Alpine.store("popups", popup);

Alpine.start();

export default Alpine;
