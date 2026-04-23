import { addMonths, subMonths } from "date-fns";

import MonthsService from "./MonthsService";
import ValidatorService from "./ValidatorService";
import ScrollService from "./ScrollService";

import { MONTH_NAMES } from "../constants";
import type { CalendarData, CalendarServiceParams } from "../types";

const validatorService: ValidatorService = new ValidatorService();
const scrollService: ScrollService = new ScrollService();

export default class CalendarService {
    private _data: CalendarData;
    private _monthsService: MonthsService;

    // --- Инициализация ---
    constructor(params: CalendarServiceParams = {}) {
        const today = new Date();
        const {
            year = today.getFullYear(),
            month = today.getMonth(),
        }: CalendarServiceParams = params;

        validatorService.ValidateDateParams(year, month);

        this._data = {
            selectedDate: new Date(year, month, 1),
            selectedYear: year,
            selectedMonth: month,
            selectedMonthName: MONTH_NAMES[month],
        };
        this._monthsService = new MonthsService(year, month);
    }
    // --- ### ---

    // --- Управление календарем ---
    public SelectMonth(year: number, month: number): void {
        if (!this.monthsService.IsMonthCanBeSelected(year, month)) {
            throw new Error(
                `Month ${month} of year ${year} cannot be selected`,
            );
        }

        const monthId = this.monthsService.monthGenerator.GetMonthId(
            new Date(year, month, 1),
        );

        this._SelectMonth(year, month);
        this.monthsService.MonthShown(monthId);
    }
    private _SelectMonth(year: number, month: number): void {
        validatorService.ValidateDateParams(year, month);

        this.selectedDate = new Date(year, month, 1);
        this.selectedYear = year;
        this.selectedMonth = month;
        this.selectedMonthName = MONTH_NAMES[month];
    }

    public SwitchMonth(year: number, month: number): void {
        const date = new Date(year, month, 1);
        const monthId = this.monthsService.monthGenerator.GetMonthId(date);

        this._SelectMonth(year, month);
        this.monthsService.ReInitialize(year, month);
        this.monthsService.MonthShown(monthId);

        scrollService.scrollToMonth(monthId);
    }

    public SwitchToPreviousMonth(): void {
        const previousDate = subMonths(this._data.selectedDate, 1);
        const previousYear = previousDate.getFullYear();
        const previousMonth = previousDate.getMonth();

        this.SwitchMonth(previousYear, previousMonth);
    }

    public SwitchToNextMonth(): void {
        const previousDate = addMonths(this._data.selectedDate, 1);
        const previousYear = previousDate.getFullYear();
        const previousMonth = previousDate.getMonth();

        this.SwitchMonth(previousYear, previousMonth);
    }

    public SwitchToCurrentMonth(): void {
        const currentDate = new Date();
        const currentYear = currentDate.getFullYear();
        const currentMonth = currentDate.getMonth();

        this.SwitchMonth(currentYear, currentMonth);
    }
    // --- ### ---

    // --- Функции проверки ---
    public IsSelectedMonth(year: number, month: number): boolean {
        return (
            this._data.selectedYear === year &&
            this._data.selectedMonth === month
        );
    }
    // --- ### ---

    // --- Getters & Setters ---
    public get data(): CalendarData {
        return this._data;
    }
    private set selectedDate(value: Date) {
        this._data.selectedDate = value;
    }
    private set selectedYear(value: number) {
        this._data.selectedYear = value;
    }
    private set selectedMonth(value: number) {
        this._data.selectedMonth = value;
    }
    private set selectedMonthName(value: string) {
        this._data.selectedMonthName = value;
    }

    public get monthsService(): MonthsService {
        return this._monthsService;
    }
    private set monthsService(value: MonthsService) {
        this._monthsService = value;
    }
    // --- ### ---
}
