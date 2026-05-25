export interface MonthYear {
    month: number;
    year: number;
}

export interface DayMonthYear extends MonthYear {
    day: number;
}

export interface CalendarConfig {
    enableEventsLoading?: boolean;
    enableEventRendering?: boolean;

    events?: EventData[];
}

export interface ApiRes {
    data: any;
    success: boolean;
}

export interface CalendarServiceParams extends Partial<MonthYear> {}

export interface ConvertedEventData {
    data: EventData;
    layer: number;
    offsetHeight: number;
    isHovered: boolean;
}

export interface EventData {
    id: number;
    name: string;
    beginning: string;
    ending: string;
    color: string;
}

export interface MonthData {
    id: string;
    monthName: string;
    month: number;
    year: number;
    daysCount: number;
    leadingEmptyDays: number;
    trailingEmptyDays: number;
    isShown: boolean;
}

export interface CalendarData {
    selectedDate: Date;
    selectedYear: number;
    selectedMonth: number;
    selectedMonthName: string;
}

export interface LoaderTask {
    name: string;
}
