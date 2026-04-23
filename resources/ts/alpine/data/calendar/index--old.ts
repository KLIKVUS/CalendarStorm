import { areIntervalsOverlapping, compareAsc, differenceInDays, format, getISODay, isMonday, isSameDay, isSameWeek, isWithinInterval } from "date-fns";
import Alpine from "alpinejs";

import type { AddMonthParams, ConvertedEventData, DayData, EventData, InitializedMonthData, MonthData, MonthInitialData, WeekData, WeeksLayersData } from "./types";
import { DAY_NAMES, MONTH_NAMES } from "./constants";

export default class Calendar implements Alpine.AlpineComponent<Calendar> {
    public dayNames: string[] = DAY_NAMES;

    // --- Состояние календаря ---
    private startDate: Date | undefined = undefined;
    private endDate: Date | undefined = undefined;

    private selectedYear: number | undefined = undefined;
    private selectedMonth: number | undefined = undefined;
    private selectedMonthName: string | undefined = undefined;

    private events: ConvertedEventData[] = [];

    // Хранит высоты слоёв событий для каждой недели
    private weeksLayersData: WeeksLayersData = {};

    // Список месяцев, отображаемых в календаре
    private calendarMonths: InitializedMonthData[] = [];

    // Флаг инициализации
    private isInitialized: boolean = false;

    // Флаг, указывающий, что скролл завершён
    private isScrolled: boolean = false;

    // Данные для восстановления позиции скролла
    private savedScrollMonthIndex: string | undefined = undefined;
    private savedCalendarScrollTop: number | undefined = undefined;

    // --- Инициализация ---
    init(): void {
        const today = new Date();
        this.loadEvents();
        this.selectMonth(today.getFullYear(), today.getMonth());
        this.initSelectedMonth();
    }

    private loadEvents(): void {
        const eventsFromDb: EventData[] = [
            { id: 1, name: "Event 1", beginning: "2025-11-01 08:00:00", ending: "2025-11-01 18:00:00" },
            { id: 2, name: "Event 2", beginning: "2025-11-01 09:00:00", ending: "2025-11-03 16:00:00" },
            { id: 3, name: "Event 3", beginning: "2025-11-04 19:00:00", ending: "2025-11-12 20:00:00" },
            { id: 4, name: "Event 4", beginning: "2025-10-31 11:30:00", ending: "2025-11-07 19:30:00" },
            { id: 5, name: "Event 5", beginning: "2025-11-02 11:30:00", ending: "2025-11-03 19:30:00" },
            { id: 6, name: "Event 6", beginning: "2025-11-03 11:30:00", ending: "2025-11-04 19:30:00" },
            { id: 7, name: "Event 7", beginning: "2025-11-08 11:30:00", ending: "2025-11-10 19:30:00" },
            { id: 8, name: "Event 8", beginning: "2025-11-13 11:30:00", ending: "2025-11-15 19:30:00" },
        ];

        eventsFromDb.sort((a, b) => compareAsc(new Date(a.beginning), new Date(b.beginning)));

        this.events = eventsFromDb.map((event) =>
            Alpine.reactive({
                data: event,
                layer: 0,
                offsetHeight: undefined,
                isHovered: false,
            })
        );
    }

    initSelectedMonth(): void {
        this.addMonth({
            addType: "init",
            year: this.selectedYear!,
            month: this.selectedMonth!,
        });
        this.isInitialized = true;
    }

    // --- Управление месяцем ---
    selectMonth(year: number, month: number): void {
        this.selectedYear = year;
        this.selectedMonth = month;
        this.selectedMonthName = MONTH_NAMES[month];
    }

    switchToCurrentMonth(): void {
        const today = new Date();
        this.resetInitialization();
        this.selectMonth(today.getFullYear(), today.getMonth());
        this.initSelectedMonth();
        this.$nextTick(() => this.scrollToMonth(`${today.getFullYear()}-${today.getMonth()}--month-index`));
    }

    switchToPreviousMonth(): void {
        const { year, month } = this.adjustMonth({ offset: -1 });
        this.switchToMonth(year, month);
    }

    switchToNextMonth(): void {
        const { year, month } = this.adjustMonth({ offset: 1 });
        this.switchToMonth(year, month);
    }

    switchToMonth(year: number, month: number): void {
        this.resetInitialization();
        this.selectMonth(year, month);
        this.initSelectedMonth();
        this.$nextTick(() => this.scrollToMonth(`${year}-${month}--month-index`));
    }

    // --- Пересечение месяцев (инфинити скролл) ---
    handleIntersectEnterMonth(monthData: InitializedMonthData, monthIndexInArray: number): void {
        if (!this.isInitialized) return;
        if (!this.isSelectedMonth(monthData.year, monthData.month)) this.selectMonth(monthData.year, monthData.month);

        const addParams: AddMonthParams[] = [];

        if (monthIndexInArray === 0) {
            const { year, month } = this.adjustMonth({ year: monthData.year, month: monthData.month, offset: -1 });
            const endDate = new Date(this.startDate!);
            endDate.setDate(endDate.getDate() - 1);
            addParams.push({ addType: "unshift", year, month, calendarEndDate: endDate });
        }

        if (monthIndexInArray === this.calendarMonths.length - 1) {
            const { year, month } = this.adjustMonth({ year: monthData.year, month: monthData.month, offset: 1 });
            const startDate = new Date(this.endDate!);
            startDate.setDate(startDate.getDate() + 1);
            addParams.push({ addType: "push", year, month, calendarStartDate: startDate });
        }

        if (addParams.length === 0) return;

        monthData.isShown = true;
        this.isScrolled = false;

        this.$nextTick(() => {
            this.saveScrollPos(monthData.index);
            addParams.forEach((param) => this.addMonth(param));
        }).then(() => {
            this.scrollToSavedScrollPos().then((success) => {
                this.isScrolled = success;
            });
        });
    }

    handleIntersectLeaveMonth(monthData: InitializedMonthData, monthIndexInArray: number): void {
        if (!this.isInitialized) return;

        const prevMonth = this.calendarMonths[monthIndexInArray - 1];
        const nextMonth = this.calendarMonths[monthIndexInArray + 1];
        const excludedIndexes: string[] = [];
        let newStartDate: Date | undefined, newEndDate: Date | undefined;

        if (prevMonth && !prevMonth.isShown) {
            excludedIndexes.push(prevMonth.index);
            newStartDate = new Date(monthData.startDate);
        }
        if (nextMonth && !nextMonth.isShown) {
            excludedIndexes.push(nextMonth.index);
            newEndDate = new Date(monthData.endDate);
        }

        if (excludedIndexes.length === 0) return;

        monthData.isShown = false;
        this.changeCalendarBounds({ newStartDate, newEndDate });
        this.calendarMonths = this.calendarMonths.filter((m) => !excludedIndexes.includes(m.index));
    }

    // --- Основные методы ---
    getEventLengthRelativeToWeekDay(weekDayDate: Date | string, event: EventData): number {
        const date = format(weekDayDate, "yyyy-MM-dd");
        const maxEventLength = 7 - getISODay(date);

        const diffToBeginning = differenceInDays(date, format(event.beginning, "yyyy-MM-dd"));
        let length = differenceInDays(format(event.ending, "yyyy-MM-dd"), format(event.beginning, "yyyy-MM-dd"));

        if (diffToBeginning > 0) length -= diffToBeginning;
        return Math.min(length, maxEventLength);
    }

    initEventHeight(event: ConvertedEventData, el: HTMLElement, weekIndex: string): void {
        Alpine.nextTick(() => {
            if (event.offsetHeight) return;

            const height = el.offsetHeight;
            event.offsetHeight = height;

            const parentStyle = window.getComputedStyle(el.parentElement!);
            const totalHeight = height + parseFloat(parentStyle.marginTop) + parseFloat(parentStyle.marginBottom);

            const layerKey = `layer${event.layer}`;
            const weekLayer = (this.weeksLayersData[weekIndex] ||= {});
            const layer = (weekLayer[layerKey] ||= { height: 0 });

            if (totalHeight > layer.height) layer.height = totalHeight;
        });
    }

    insertDivWithHeight(el: HTMLElement, initialLevelNumber: number, endLevelNumber: number, weekIndex: string): void {
        Alpine.nextTick(() => {
            if (!(el instanceof HTMLElement)) throw new Error("Invalid DOM element");
            if (initialLevelNumber >= endLevelNumber - 1 || !this.weeksLayersData[weekIndex]) return;

            const layers = this.weeksLayersData[weekIndex];
            let totalHeight = 0;

            for (let i = initialLevelNumber; i < endLevelNumber; i++) {
                const key = `layer${i}`;
                if (layers[key]) totalHeight += layers[key].height;
            }

            if (totalHeight === 0) return;

            const div = document.createElement("div");
            div.style.height = `${totalHeight}px`;
            el.parentNode?.insertBefore(div, el);
        });
    }

    // --- Приватные методы ---
    private addMonth(params: AddMonthParams): void {
        const { addType, year, month, calendarStartDate, calendarEndDate } = params;

        const initialData = this.getMonthInitialData({
            year,
            month,
            startDate: calendarStartDate,
            endDate: calendarEndDate,
        });
        const weeks = this.getMonthWeeksData(initialData.weeksCount, initialData.monthsData);

        const monthData = this.getMonthData({
            year,
            month,
            weeks,
            startDate: initialData.startDate,
            endDate: initialData.endDate,
        });

        switch (addType) {
            case "unshift":
                this.changeCalendarBounds({ newStartDate: initialData.startDate });
                this.calendarMonths.unshift(monthData);
                break;
            case "push":
                this.changeCalendarBounds({ newEndDate: initialData.endDate });
                this.calendarMonths.push(monthData);
                break;
            default:
                this.changeCalendarBounds({
                    newStartDate: initialData.startDate,
                    newEndDate: initialData.endDate,
                });
                this.calendarMonths = [monthData];
                break;
        }
    }

    private getMonthInitialData({
        year = this.selectedYear!,
        month = this.selectedMonth!,
        startDate = null,
        endDate = null,
    }: {
        year?: number;
        month?: number;
        startDate?: Date | null;
        endDate?: Date | null;
    } = {}): MonthInitialData {
        const daysInPrevMonth = new Date(year, month, 0).getDate();
        const daysInThisMonth = new Date(year, month + 1, 0).getDate();
        const firstDay = new Date(year, month, 1).getDay();
        const lastDay = new Date(year, month + 1, 0).getDay();

        const daysBefore = firstDay === 0 ? 6 : firstDay - 1;
        const daysAfter = lastDay === 0 ? 0 : 7 - lastDay;

        let computedStartDate =
            startDate ??
            (() => {
                const { year: adjYear, month: adjMonth } = this.adjustMonth({
                    year,
                    month,
                    offset: daysBefore > 0 ? -1 : 0,
                });
                return new Date(adjYear, adjMonth, daysBefore > 0 ? daysInPrevMonth - daysBefore + 1 : 1);
            })();

        let computedEndDate =
            endDate ??
            (() => {
                const { year: adjYear, month: adjMonth } = this.adjustMonth({
                    year,
                    month,
                    offset: daysAfter > 0 ? 1 : 0,
                });
                return new Date(adjYear, adjMonth, daysAfter > 0 ? daysAfter : daysInThisMonth);
            })();

        const totalDays = Math.ceil((computedEndDate.getTime() - computedStartDate.getTime()) / 86400000) + 1;
        const weeksCount = Math.ceil(totalDays / 7);

        const monthsData: MonthData[] = [];
        let current = new Date(computedStartDate);

        while (current <= computedEndDate) {
            const y = current.getFullYear();
            const m = current.getMonth();
            const startDay = current.getDate();
            const endDay = y === computedEndDate.getFullYear() && m === computedEndDate.getMonth() ? computedEndDate.getDate() : new Date(y, m + 1, 0).getDate();

            monthsData.push({ year: y, month: m, startDay, endDay });

            current.setDate(1);
            current.setMonth(current.getMonth() + 1);
        }

        return {
            weeksCount,
            monthsData,
            startDate: computedStartDate,
            endDate: computedEndDate,
        };
    }

    private getMonthData({ year, month, weeks, startDate, endDate }: { year: number; month: number; weeks: WeekData[]; startDate: Date; endDate: Date }): InitializedMonthData {
        return {
            index: `${year}-${month}--month-index`,
            year,
            month,
            startDate,
            endDate,
            weeks,
            isShown: false,
        };
    }

    private getMonthWeeksData(weeksCount: number, monthsData: MonthData[]): WeekData[] {
        const weeks: WeekData[] = [];
        let weekIndex = 0;

        for (const m of monthsData) {
            const monthStart = format(new Date(m.year, m.month, m.startDay), "yyyy-MM-dd");
            const monthEnd = format(new Date(m.year, m.month, m.endDay), "yyyy-MM-dd");

            const monthEvents: ConvertedEventData[] = this.events
                .filter((event) => {
                    const evStart = format(new Date(event.data.beginning), "yyyy-MM-dd");
                    const evEnd = format(new Date(event.data.ending), "yyyy-MM-dd");
                    return areIntervalsOverlapping({ start: monthStart, end: monthEnd }, { start: evStart, end: evEnd }, { inclusive: true });
                })
                .map((event) => ({ ...event }));

            this.assignEventLayers(monthEvents);

            let dayCounter = m.startDay;

            for (; weekIndex < weeksCount; weekIndex++) {
                if (!weeks[weekIndex]) weeks[weekIndex] = this.getWeekData(m.year, m.month, dayCounter);

                const weekDays = weeks[weekIndex].days;

                for (; dayCounter <= m.endDay; dayCounter++) {
                    if (weekDays.length === 7) break;

                    const dayDate = format(new Date(m.year, m.month, dayCounter), "yyyy-MM-dd");
                    const dayEvents = monthEvents.filter((event) => {
                        const evStart = format(new Date(event.data.beginning), "yyyy-MM-dd");
                        const evEnd = format(new Date(event.data.ending), "yyyy-MM-dd");
                        return isWithinInterval(new Date(dayDate), { start: new Date(evStart), end: new Date(evEnd) }) && (isSameDay(evStart, dayDate) || isMonday(dayDate));
                    });

                    weekDays.push(this.getDayData(m.year, m.month, dayCounter, dayEvents));
                }

                if (dayCounter > m.endDay) break;
            }
        }

        return weeks;
    }

    private assignEventLayers(events: ConvertedEventData[]): void {
        events.forEach((event1) => {
            for (let layer = 0; ; layer++) {
                const isAvailable = events.every((event2) => {
                    if (event2.data.id === event1.data.id || event2.layer === undefined || event2.layer !== layer) return true;
                    return !areIntervalsOverlapping(
                        { start: format(event1.data.beginning, "yyyy-MM-dd"), end: format(event1.data.ending, "yyyy-MM-dd") },
                        { start: format(event2.data.beginning, "yyyy-MM-dd"), end: format(event2.data.ending, "yyyy-MM-dd") },
                        { inclusive: true }
                    );
                });

                if (isAvailable) {
                    event1.layer = layer;
                    break;
                }
            }
        });
        events.sort((a, b) => a.layer - b.layer);
    }

    private getWeekData(year: number, month: number, day: number): WeekData {
        return {
            index: `${year}-${month}-${day}--week-index`,
            days: [],
        };
    }

    private getDayData(year: number, month: number, day: number, events: ConvertedEventData[]): DayData {
        const date = new Date(year, month, day);
        return {
            index: `${year}-${month}-${day}--day-index`,
            date,
            year,
            month,
            day,
            events,
        };
    }

    private adjustMonth({
        year = this.selectedYear!,
        month = this.selectedMonth!,
        offset = 0,
    }: {
        year?: number;
        month?: number;
        offset?: number;
    } = {}): { year: number; month: number } {
        const date = new Date(year, month, 1);
        date.setMonth(date.getMonth() + offset);
        return { year: date.getFullYear(), month: date.getMonth() };
    }

    private scrollToSavedScrollPos(): Promise<boolean> {
        const { savedScrollMonthIndex: index, savedCalendarScrollTop: topOffset } = this;
        if (!index || topOffset === undefined) throw new Error("Scroll data not saved");

        const monthEl = document.getElementById(index);
        if (!monthEl) throw new Error("Month element not found in DOM");

        const calendar = this.$refs.calendar;
        const targetTop = monthEl.offsetTop + topOffset;
        const error = 5;

        return new Promise((resolve, reject) => {
            const failed = setTimeout(() => reject(false), 2000);
            const handler = () => {
                if (Math.abs(calendar.scrollTop - targetTop) <= error) {
                    calendar.removeEventListener("scroll", handler);
                    clearTimeout(failed);
                    this.resetScrollData();
                    resolve(true);
                }
            };

            if (calendar.scrollTop === targetTop) {
                clearTimeout(failed);
                this.resetScrollData();
                resolve(true);
            } else {
                calendar.addEventListener("scroll", handler);
            }

            calendar.scrollTo({ top: targetTop, behavior: "instant" });
        });
    }

    private saveScrollPos(monthIndex: string): void {
        const monthEl = document.getElementById(monthIndex);
        if (!monthEl) return;

        this.savedScrollMonthIndex = monthIndex;
        this.savedCalendarScrollTop = this.$refs.calendar.scrollTop - monthEl.offsetTop;
    }

    private scrollToMonth(monthIndex: string): void {
        const el = document.getElementById(monthIndex);
        el?.scrollIntoView({ behavior: "instant" });
    }

    private changeCalendarBounds({ newStartDate, newEndDate }: { newStartDate?: Date; newEndDate?: Date }): void {
        if (newStartDate) this.startDate = newStartDate;
        if (newEndDate) this.endDate = newEndDate;
    }

    private resetScrollData(): void {
        this.savedScrollMonthIndex = undefined;
        this.savedCalendarScrollTop = undefined;
    }

    private resetInitialization(): void {
        this.isInitialized = false;
    }

    // --- Проверки ---
    isToday(year = this.selectedYear!, month = this.selectedMonth!, day: number): boolean {
        const today = new Date();
        const date = new Date(year, month, day);
        return today.toDateString() === date.toDateString();
    }

    isCurrentMonth(year = this.selectedYear!, month = this.selectedMonth!): boolean {
        const now = new Date();
        return now.getFullYear() === year && now.getMonth() === month;
    }

    isSelectedMonth(year: number, month: number): boolean {
        return this.selectedYear === year && this.selectedMonth === month;
    }

    isSameDay(date1: string | Date, date2: string | Date): boolean {
        return isSameDay(new Date(date1), new Date(date2));
    }

    isSameWeek(date1: string | Date, date2: string | Date): boolean {
        return isSameWeek(new Date(date1), new Date(date2), { weekStartsOn: 1 });
    }

    isEventIntersectSelectedMonth(event: EventData): boolean {
        const evStart = format(new Date(event.beginning), "yyyy-MM-dd");
        const evEnd = format(new Date(event.ending), "yyyy-MM-dd");
        const monthStart = format(new Date(this.selectedYear!, this.selectedMonth!, 1), "yyyy-MM-dd");
        const monthEnd = format(new Date(this.selectedYear!, this.selectedMonth! + 1, 0), "yyyy-MM-dd");

        return areIntervalsOverlapping({ start: evStart, end: evEnd }, { start: monthStart, end: monthEnd }, { inclusive: true });
    }

    // --- Магические свойства, добавляемые Alpine.js ---
    $el!: HTMLElement;
    $refs!: { calendar: HTMLElement };
    $nextTick!: (callback: () => void) => Promise<void>;
}
