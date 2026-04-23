import { addMonths, getDay, startOfMonth } from "date-fns";

import type { MonthData } from "../types";
import { MONTH_NAMES } from "../constants";

export default class MonthGenerator {
    public InitializedMonths(curMonth: Date): MonthData[] {
        const curMonthDataForRender = this.InitializeMonth(curMonth, 0);
        const nextMonthDataForRender = this.InitializeMonth(curMonth, 1);
        const prevMonthDataForRender = this.InitializeMonth(curMonth, -1);

        return [
            prevMonthDataForRender,
            curMonthDataForRender,
            nextMonthDataForRender,
        ];
    }
    public InitializeMonth(date: Date, offset: number): MonthData {
        return this.GetMonthData(addMonths(date, offset));
    }
    private GetMonthData(date: Date): MonthData {
        return {
            id: this.GetMonthId(date),
            monthName: MONTH_NAMES[date.getMonth()],
            month: date.getMonth(),
            year: date.getFullYear(),
            daysCount: this.GetDaysCount(date.getFullYear(), date.getMonth()),
            leadingEmptyDays: this.GetLeadingEmptyDays(
                date.getFullYear(),
                date.getMonth(),
            ),
            trailingEmptyDays: this.GetTrailingEmptyDays(
                date.getFullYear(),
                date.getMonth(),
            ),
            isShown: false,
        };
    }
    private GetDaysCount(year: number, month: number): number {
        return new Date(year, month + 1, 0).getDate();
    }
    private GetLeadingEmptyDays(year: number, month: number): number {
        const date = startOfMonth(new Date(year, month));
        const day = getDay(date);

        return (day + 6) % 7;
    }
    private GetTrailingEmptyDays(year: number, month: number): number {
        const daysCount = this.GetDaysCount(year, month);
        const emptyDays = this.GetLeadingEmptyDays(year, month);
        const total = emptyDays + daysCount;

        return (7 - (total % 7)) % 7;
    }

    public GetMonthId(date: Date): string {
        return `${date.getMonth()}-${date.getFullYear()}`;
    }
}
