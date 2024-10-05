import Alpine from "alpinejs";
import collapse from "@alpinejs/collapse";
import persist from "@alpinejs/persist";
import intersect from '@alpinejs/intersect';

import localUserSettings from "./alpine/data/localUserSettings";
import generalCalendar from "./alpine/data/generalCalendar";

window.Alpine = Alpine;

Alpine.plugin(collapse);
Alpine.plugin(persist);
Alpine.plugin(intersect);

// Локальные настройки пользователя (хранятся только на стороне клиента)
Alpine.data("localUserSettings", localUserSettings);
// Функции основного календаря
Alpine.data("generalCalendar", generalCalendar);

Alpine.start();
