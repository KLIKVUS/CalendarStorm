import Alpine from "alpinejs";
import collapse from "@alpinejs/collapse";
import persist from "@alpinejs/persist";
import intersect from "@alpinejs/intersect";

import localUserSettings from "./data/localUserSettings";
import CalendarInterface from "./data/calendar/index";
import dragScroll from "./data/dragScroll";

import { createBreakpointsStore } from "./store/breakpoints";

window.Alpine = Alpine;

Alpine.plugin(collapse);
Alpine.plugin(persist);
Alpine.plugin(intersect);

// Локальные настройки пользователя (хранятся только на стороне клиента)
Alpine.data("localUserSettings", localUserSettings);
// Функции основного календаря
const globalCalendarInterface = new CalendarInterface();
Alpine.data("GlobalCalendar", () => globalCalendarInterface);
// Функции для скрола при помощи драга
Alpine.data("dragScroll", dragScroll);

// Хранилище для точек перелома
Alpine.store("breakpoints", createBreakpointsStore());

Alpine.start();

export default Alpine;
