import {
    areIntervalsOverlapping,
    differenceInCalendarDays,
    differenceInDays,
    endOfMonth,
    endOfWeek,
    format,
    getISODay,
    getWeek,
    isSameDay,
    isSameWeek,
    min,
} from "date-fns";

import type { ConvertedEventData, EventData } from "../types";

interface WeeksLayersData {
    [weekIndex: string]: {
        [layer: string]: {
            height: number;
        };
    };
}

export default class EventRender {
    private weeksLayersData: WeeksLayersData = {};

    public GetEventLengthRelativeToWeekDay(
        weekDayDate: Date,
        event: EventData,
    ): number {
        const date = format(weekDayDate, "yyyy-MM-dd");
        const maxEventLength = 7 - getISODay(date);

        const diffToBeginning = differenceInDays(
            date,
            format(event.beginning, "yyyy-MM-dd"),
        );
        let length = differenceInDays(
            format(event.ending, "yyyy-MM-dd"),
            format(event.beginning, "yyyy-MM-dd"),
        );

        if (diffToBeginning > 0) length -= diffToBeginning;
        return Math.min(length, maxEventLength);
    }

    public getTrimmedEventLengthInLastWeekOfMonth(
        startDate: Date,
        eventLength: number,
    ): number {
        const monthEnd = endOfMonth(startDate);
        const weekEnd = endOfWeek(startDate, { weekStartsOn: 1 });

        if (weekEnd.getMonth() === startDate.getMonth()) {
            return eventLength;
        }

        const eventEnd = new Date(startDate);
        eventEnd.setDate(startDate.getDate() + eventLength);

        const visibleEnd = min([eventEnd, monthEnd]);

        return differenceInCalendarDays(visibleEnd, startDate);
    }

    public InsertDivWithHeight(
        el: HTMLElement,
        initialLevelNumber: number,
        endLevelNumber: number,
        weekIndex: string,
    ): void {
        Alpine.nextTick(() => {
            if (!(el instanceof HTMLElement))
                throw new Error("Invalid DOM element");
            if (
                initialLevelNumber >= endLevelNumber - 1 ||
                !this.weeksLayersData[weekIndex]
            )
                return;

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

    public InitEventHeight(
        event: ConvertedEventData,
        el: HTMLElement,
        weekIndex: string,
    ): void {
        Alpine.nextTick(() => {
            const height = el.offsetHeight;
            event.offsetHeight = height;

            const parentStyle = window.getComputedStyle(el.parentElement!);
            const totalHeight =
                height +
                parseFloat(parentStyle.marginTop) +
                parseFloat(parentStyle.marginBottom);

            const layerKey = `layer${event.layer}`;
            const weekLayer = (this.weeksLayersData[weekIndex] ||= {});
            const layer = (weekLayer[layerKey] ||= { height: 0 });

            if (totalHeight > layer.height) layer.height = totalHeight;
        });
    }

    public IsSameDay(date1: string | Date, date2: string | Date): boolean {
        return isSameDay(new Date(date1), new Date(date2));
    }

    public IsSameWeek(date1: string | Date, date2: string | Date): boolean {
        return isSameWeek(new Date(date1), new Date(date2), {
            weekStartsOn: 1,
        });
    }

    public IsEventIntersectMonth(
        event: EventData,
        year: number,
        month: number,
    ): boolean {
        const evStart = format(new Date(event.beginning), "yyyy-MM-dd");
        const evEnd = format(new Date(event.ending), "yyyy-MM-dd");
        const monthStart = format(new Date(year, month, 1), "yyyy-MM-dd");
        const monthEnd = format(new Date(year, month + 1, 0), "yyyy-MM-dd");

        return areIntervalsOverlapping(
            { start: evStart, end: evEnd },
            { start: monthStart, end: monthEnd },
            { inclusive: true },
        );
    }

    public GetDayWeekIndex(year: number, month: number, day: number): string {
        const weekIndex = getWeek(new Date(year, month, day), {
            weekStartsOn: 1,
        });
        return `${year}-week=${weekIndex}`;
    }
}
