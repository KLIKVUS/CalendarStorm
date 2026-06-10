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

    calendarName?: string;
    calendarId?: number;
    rights_of_the_current_user?: {
        is_user_can_update?: boolean;
        is_user_can_delete?: boolean;
        is_user_can_create_events?: boolean;
    };
    eventsUrl?: string;

    events?: EventData[];
}

export interface ApiRes {
    data: any;
    success: boolean;
    message: string;
}

export interface CalendarServiceParams extends Partial<MonthYear> {}

export interface EventsByDay {
    [key: string]: DayEventsData;
}

export interface DayEventsData {
    events: Array<Array<DayEventData>>;
}

export interface DayEventData {
    globalData: GlobalEventData;
    dayDate: Date;
    adjacent: {
        left: boolean;
        right: boolean;
    };
}

export interface GlobalEventData {
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
    count?: number;
}
