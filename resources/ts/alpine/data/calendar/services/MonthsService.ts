import type { MonthData } from "../types";

import ValidatorService from "./ValidatorService";
import MonthGenerator from "../utils/MonthGenerator";
import LoaderService from "./LoaderService";

const validatorService: ValidatorService = new ValidatorService();

export default class MonthsService {
    private data = Alpine.reactive({
        months: [] as MonthData[],
    });
    public monthGenerator: MonthGenerator;

    // --- Инициализация ---
    constructor(year: number, month: number) {
        this.monthGenerator = new MonthGenerator();
        const date = new Date(year, month);

        validatorService.ValidateDate(date);
        this.months = this.monthGenerator.InitializedMonths(date);

        Alpine.effect(() => {
            if (this.data.months.length === 0) return;
            this.RemoveUnshownMonths();
            this.AddMonthsIfNeeded();
        });
    }
    // --- ### ---

    // --- Методы для управления месяцами ---
    public ReInitialize(year: number, month: number): void {
        this.months = this.monthGenerator.InitializedMonths(
            new Date(year, month),
        );
    }

    public MonthShown(id: string): void {
        const month = this.GetMonthById(id);
        if (month) {
            month.isShown = true;
        }
    }

    public MonthUnShown(id: string): void {
        const month = this.GetMonthById(id);
        if (month) {
            month.isShown = false;
        }
    }

    public GetMonthById(id: string): MonthData | undefined {
        return this.months.find((month) => month.id === id);
    }

    /*
        Удаляет месяцы из начала и конца массива months.
        Месяц будет удален, если он не отображается, является первым и после него есть не отображаемый месяц.
        Или месяц будет удален, если он не отображается, является последним и перед ним есть не отображаемый месяц.
    */
    private RemoveUnshownMonths(): void {
        if (!this.months.some((m) => m.isShown)) return;
        LoaderService.addTask({ name: "monthsService.RemoveUnshownMonths" });

        let start = 0;
        let end = this.months.length - 1;

        // удаляем с начала
        while (
            start < end &&
            !this.months[start].isShown &&
            !this.months[start + 1].isShown
        ) {
            start++;
        }

        // удаляем с конца
        while (
            end > start &&
            !this.months[end].isShown &&
            !this.months[end - 1].isShown
        ) {
            end--;
        }

        const months = this.months.slice(start, end + 1);

        this.months = months;

        LoaderService.removeTask("monthsService.RemoveUnshownMonths");
    }

    /*
        Добавляет недостающие месяцы в начало или конец массива month.
        Если первый элемент массива month отображается, добавляет месяц в начало массива.
        Если последний элемент массива month отображается, добавляет месяц в конец массива.
    */
    private AddMonthsIfNeeded(): void {
        LoaderService.addTask({ name: "monthsService.AddMonthsIfNeeded" });

        const firstMonth = this.months[0];
        const lastMonth = this.months[this.months.length - 1];

        if (firstMonth.isShown) this.AddMonth("unshift");
        if (lastMonth.isShown) this.AddMonth("push");

        LoaderService.removeTask("monthsService.AddMonthsIfNeeded");
    }
    private AddMonth(addType: "unshift" | "push"): void {
        const month =
            addType === "unshift"
                ? this.months[0]
                : this.months[this.months.length - 1];
        const date = new Date(month.year, month.month);
        const newMonth = this.monthGenerator.InitializeMonth(
            date,
            addType === "unshift" ? -1 : 1,
        );

        if (addType === "unshift") {
            this.months.unshift(newMonth);
        } else {
            this.months.push(newMonth);
        }
    }
    // --- ### ---

    // --- Методы для проверки ---
    public IsMonthCanBeSelected(year: number, month: number): boolean {
        const dateToCheck = new Date(year, month);

        const idToFind = this.monthGenerator.GetMonthId(dateToCheck);
        const foundMonth = this.months.find((m) => m.id === idToFind);

        return !!foundMonth;
    }
    // --- ### ---

    // --- Getters & Setters ---
    public get months(): MonthData[] {
        return this.data.months;
    }
    private set months(months: MonthData[]) {
        this.data.months.length = 0;
        this.data.months.push(...months);
    }
    // --- ### ---
}
