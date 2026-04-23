import { isValid, set } from "date-fns";

export default class ValidatorService {
    public ValidateDateParams(
        year: number,
        month: number,
        date: number = 1,
    ): void {
        const candidate = set(new Date(), { year, month, date });
        if (!isValid(candidate)) {
            throw new Error(
                `Invalid date: year=${year}, month=${month}, date=${date}`,
            );
        }
    }

    public ValidateDate(date: Date): void {
        if (!isValid(date)) {
            throw new Error(`Invalid date: ${date.toString()}`);
        }
    }

    public ValidateDateRange(startDate: Date, endDate: Date): void {
        this.ValidateDate(startDate);
        this.ValidateDate(endDate);

        if (startDate > endDate) {
            throw new Error(
                `Invalid date range: ${startDate.toISOString()} > ${endDate.toISOString()}`,
            );
        }
    }

    public ValidateBothOrNeither(
        a: any | undefined,
        b: any | undefined,
        message: string,
    ): void {
        const aDefined = a !== undefined;
        const bDefined = b !== undefined;

        if (aDefined !== bDefined) {
            throw new Error(message);
        }
    }
}
