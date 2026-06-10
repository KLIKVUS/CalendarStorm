import Alpine from "alpinejs";

import LoaderService, { LoaderServiceClass } from "./services/LoaderService";
import CalendarService from "./services/CalendarService";
import EventService from "./services/EventService";
import ScrollService from "./services/ScrollService";

import type { CalendarConfig } from "./types";
import { DAY_NAMES } from "./constants";

export default class CalendarComponent implements Alpine.AlpineComponent<CalendarComponent> {
    private config: CalendarConfig;

    public dayNames: string[] = DAY_NAMES;

    public loaderService: LoaderServiceClass;
    public scrollService: ScrollService;
    public eventService: EventService;
    public calendarService: CalendarService;

    constructor(config: CalendarConfig = {}) {
        this.config = config;
        this.loaderService = LoaderService;
        this.scrollService = new ScrollService();
        this.eventService = new EventService({
            events: this.config.events,
            config: config,
        });
        this.calendarService = new CalendarService();
    }

    // --- Инициализация  ---
    public init(): void {
        this.loaderService.addTask({ name: "CalendarInit" });

        Alpine.nextTick(async () => {
            await this.eventService.init();

            const calendarData = this.calendarService.data;
            const selectedDate = new Date(
                calendarData.selectedYear,
                calendarData.selectedMonth,
            );
            const selectedMonthId =
                this.calendarService.monthsService.monthGenerator.GetMonthId(
                    selectedDate,
                );
            await this.scrollService.scrollToMonth(selectedMonthId);

            this.loaderService.removeTask("CalendarInit");
        });
    }
    // --- ### ---

    // --- Магические свойства, добавляемые Alpine.js ---
    // $el!: HTMLElement;
    // $refs!: { calendar: HTMLElement };
    // $nextTick!: (callback: () => void) => Promise<void>;
    // --- ### ---
}
