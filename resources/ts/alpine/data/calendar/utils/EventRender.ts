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
    isSameMonth,
    isSameWeek,
    min,
} from "date-fns";

import type { GlobalEventData, EventData, MonthData } from "../types";

export default class EventRender {
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

    public IsSameDay(date1: string | Date, date2: string | Date): boolean {
        return isSameDay(new Date(date1), new Date(date2));
    }

    public IsSameWeek(date1: string | Date, date2: string | Date): boolean {
        return isSameWeek(new Date(date1), new Date(date2), {
            weekStartsOn: 1,
        });
    }

    IsSameMonth(date1: string | Date, date2: string | Date): boolean {
        return isSameMonth(new Date(date1), new Date(date2));
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

    public GetEventRight(monthData: MonthData, day: number, event: GlobalEventData) {
        const weekDayDate = new Date(monthData.year, monthData.month, day);
        const eventLength = this.GetEventLengthRelativeToWeekDay(
            weekDayDate,
            event.data,
        );
        const trimmedLength = this.getTrimmedEventLengthInLastWeekOfMonth(
            weekDayDate,
            eventLength,
        );

        return `calc(-${trimmedLength * 100}% - ${trimmedLength * 2}px)`;
    }

    public GetDayIndex(year: number, month: number, day: number): string {
        return `${year}-${month}-${day}`;
    }

    public GetDayWeekIndex(year: number, month: number, day: number): string {
        const weekIndex = getWeek(new Date(year, month, day), {
            weekStartsOn: 1,
        });
        return `${year}-week=${weekIndex}`;
    }
}
